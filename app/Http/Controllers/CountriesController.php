<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Country, AssignedCountries};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CountriesController extends Controller
{
      protected $userId;

      /**
       * Set the user id
       */
      public function __construct(){

         $this->middleware(function ($request, $next) {
           $this->userId = auth()->user()->id; 
           return $next($request);
         });
      }

      /**
       * Get the countries legend and countries for a particular year and month (dayColors)
       */
      public function index(Request $request){

         $year = (int)$request->input('year');
         $month = (int)$request->input('month');

         //Get the legend
         $legend = $this->getLegend($year, $month);

         //Get the month day colors
         $monthColors = $this->getMonthColors($year, $month); //dd($monthColors);

         return response()->json([
            'legend' => $legend,
            'monthColors' => $monthColors
         ]);
      }

      public function getMonthColors($year, $month){
         $firstDay = $year . '-' . $month . '-01';
         $daysInMonth = Carbon::create($year . '-' . $month . '-01')->daysInMonth;
         $lastDay = $year . '-' . $month . '-' . $daysInMonth; 

         $monthColors = Country::
               selectRaw('dayofmonth(selected_date) as monthday, group_concat(color) as color')
               ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
               ->where('user_id', '=', $this->userId)
               ->whereBetween('selected_date', [$firstDay, $lastDay])
               ->groupBy('monthday')
               ->get(); 

         $data = [];
         foreach($monthColors as $row){
            $m = $row['monthday'];
            $colors = explode(',', $row['color']);
            $data[$m] = $colors;
         }

         return $data;
      }
   
      public function getAssignedCountries(Request $request){

         $date = $request->input('date');

         //Get all the countries for the dropdown
         $countries = Country::select('id as value', 'name as text')->orderBy('name')->get(); 

         //Get the saved/assigned countries
         $assigned = Country::select('id as value', 'name as text')
                  ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
                  ->where('user_id', '=', $this->userId)
                  ->where('selected_date', '=', $date)
                  ->orderBy('name')
                  ->get(); 
         
         //dd($countries);
         return response()->json([
            'countries' => $countries,
            'dayCountries' => $assigned
         ]);
      }

      public function getLegend($year, $month){
         $firstDay = $year . '-' . $month . '-01';
         $daysInMonth = Carbon::create($year . '-' . $month . '-01')->daysInMonth;
         $lastDay = $year . '-' . $month . '-' . $daysInMonth;

         $legend = Country::select('color', 'name')
               ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
               ->where('user_id', '=', $this->userId)
               ->whereBetween('selected_date', [$firstDay, $lastDay])
               ->groupBy('countries.id')
               ->orderBy('name')
               ->get(); 

         return $legend;
      }

      public function saveAssignedCountries(Request $request){
         $date = $request->input('date');
         $countries = $request->input('countries');

         $data = $ids = [];
         foreach($countries as $countryId){
            $ids[] = $countryId;
            $data[] = ['user_id'=>$this->userId, 'country_id'=>$countryId, 'selected_date'=>$date];
         }

         //Delete any countries that weren't posted
         $query = AssignedCountries::where([
                  ['user_id', '=', $this->userId],
                  ['selected_date', '=', $date],
         ]);

         if($ids) $query->whereNotIn('country_id', $ids);
         $query->delete();
                     
        
         $result = AssignedCountries::insertOrIgnore($data);

         list($y, $m, $d) = explode('-', $date);

         //Now get all the countries assigned to this user for the given date
         $monthColors = $this->getMonthColors($y, $m);

         //Next get the legend
         $legend = $this->getLegend($y, $m);
         
         return response()->json([
            'monthColors' => $monthColors,
            'legend' => $legend
         ]);
      }
}