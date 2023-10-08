<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Country, AssignedCountries};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
         $lastDay = $year . '-' . $month . '-31';

         $legend = Country::select('color', 'name')
               ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
               ->where('user_id', '=', $this->userId)
               ->whereBetween('selected_date', [$firstDay, $lastDay])
               ->groupBy('countries.id')
               ->orderBy('name')
               ->get(); 

         return $legend;
      }

      public function getMonthColors($year, $month){
         $firstDay = $year . '-' . $month . '-01';
         $lastDay = $year . '-' . $month . '-31';

         $monthColors = Country::select('color')
               ->selectRaw('dayofmonth(selected_date) as monthday')
               ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
               ->where('user_id', '=', $this->userId)
               ->whereBetween('selected_date', [$firstDay, $lastDay])
               ->orderBy('name')
               ->get(); 

         $data = [];
                  
         //Now populate with actual data
         foreach($monthColors as $row){
            $data[$row['monthday']][] = $row['color']; 
         }

         //Fill in any unassigned days with a blank array
         foreach(range(1, 31) as $day){
            if(!isset($data[$day])){
               $data[$day] = [];
            }
         }

         return $data;
      }

      public function getDayColors($date){

         $dayColors = Country::select('color')
                        ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
                        ->where('user_id', '=', $this->userId)
                        ->where('selected_date', '=', $date)
                        ->orderBy('name')
                        ->get();  

         return $dayColors;
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
         AssignedCountries::where([
                  ['user_id', '=', $this->userId],
                  ['selected_date', '=', $date],
               ])
               ->whereNotIn('country_id', $ids)
               ->get();
                     
        
         $result = AssignedCountries::insertOrIgnore($data);

         //Now get all the countries assigned to this user for the given date
         $dayColors = $this->getDayColors($date);

         //Next get the legend
         list($y, $m, $d) = explode('-', $date);
         $legend = $this->getLegend($y, $m);
         
         return response()->json([
            'dayColors' => $dayColors,
            'legend' => $legend
         ]);
      }
}