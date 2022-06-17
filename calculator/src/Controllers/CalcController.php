<?php

namespace Chris\Calculator\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalcController extends Controller
{
    protected $time;
    protected $object;
    protected $encrypt;
    protected $calculate;


    public function index()
    {
        $d = $this->Date();
        $inv = "10days";

        $t = $this->GetIncrementTime($inv);

        $b =  $this->GetnextProfitsDate($t);

         return view('calculator::calc',compact(
            'd','t','b'
         ));
    }

    public function Date()
    {
        return Carbon::now()->timezone(config('codedcalculate.time_zone'));
    }

    /**
     *  @param int number of days! you can get the duration from your plan model
     */
    public function GetnumOfDays($duration): int
    {
        //get the investment number of days
        $duration = $duration;
        $duration = str_replace(['Days','days','months','month','years','year','week','weeks']," ",$duration);
       return  $duration = intval($duration);
    }

     /**
     *  @param Date/time  2022-06-17 00:41:41  pass expiry date for plans
     */
    public function CheckMaturityDate($enddate): string
    {
        if($this->Date() > $enddate)
        {
          return  json_encode(array(
                'code' => 500,
                'message'=> 'Trades has expired and no longer Active!',
            ));

        }
    }

    /**
     *get the profits increment intervals. can be increment after 5days. fetch from model
     */
    public function GetIncrementTime($numofdays)
    {

        $increment_time = $numofdays;//increment after ?
        $increment_time = str_replace(["day",'days'], " ",$increment_time);
       return  $increment_time = intval($increment_time);
    }

    public function GetnextProfitsDate($numofdays)
    {
        $next_profit_date = date('Y-m-d h:i:s',strtotime("+$numofdays day", strtotime($this->Date())));

        return $next_profit_date;
    }





}
