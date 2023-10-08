<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Country, AssignedCountries};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
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
   
      public function dashboard(){

         $now = now();
         $nowDateString = $now->toDateString();

         $subYear = $now->subYear();

         //Get the number of countries visited in the last year :: no query builder (sometimes it's just easier to see the query)
         $sql = 'select count(*) as total 
                  from (
                     SELECT country_id, count(ca.country_id) as total
                     FROM assigned_countries ca
                     WHERE ca.selected_date between ? and ? and ca.user_id = ?
                  group by ca.country_id) as x';
         $yearMetric = DB::select($sql, [$subYear->toDateString(), $nowDateString, $this->userId]); 

         //Get the number of countries visited in the last month 
         $subMonth = $now->subMonth();
         $sql = 'select count(*) as total 
                  from (
                     SELECT country_id, count(ca.country_id) as total
                     FROM assigned_countries ca
                     WHERE ca.selected_date between ? and ? and ca.user_id = ?
                  group by ca.country_id) as x';
         $monthMetric = DB::select($sql, [$subMonth->toDateString(), $nowDateString, $this->userId]);

         //Get the number of countries visited in the last week 
         $subWeek = $now->subWeek();
         $sql = 'select count(*) as total 
                  from (
                     SELECT country_id, count(ca.country_id) as total
                     FROM assigned_countries ca
                     WHERE ca.selected_date between ? and ? and ca.user_id = ?
                  group by ca.country_id) as x';
         $weekMetric = DB::select($sql, [$subWeek->toDateString(), $nowDateString, $this->userId]);

         //Get the most recent countries visited
         $recentVisits = Country::select('id', 'name', 'selected_date')
               ->join('assigned_countries', 'countries.id', '=', 'assigned_countries.country_id')
               ->where('user_id', '=', $this->userId)
               ->orderBy('selected_date')
               ->limit(6)
               ->get();

         //Get the table data
         $visits = DB::select('SELECT c.id, c.name, c.code, GROUP_CONCAT(DATE_FORMAT(ca.selected_date, "%D %M %Y")) as dates
                              FROM countries c, assigned_countries ca 
                              where c.id = ca.country_id and ca.user_id = ?
                              group by c.id
                              order by c.name
                              limit 0, 15', [$this->userId]);
        
         return response()->json([
            'yearMetric' => $yearMetric[0]->total,
            'monthMetric' => $monthMetric[0]->total,
            'weekMetric' => $weekMetric[0]->total,
            'recentVisits' => $recentVisits,
            'visits'=>$visits
         ]);
      }
}