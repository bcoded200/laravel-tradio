<?php

namespace Chris\Calculator\Controllers;

use App\Http\Controllers\Controller;
use Chris\Calculator\helper;
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

         return view('calculator::calc');
    }

    public function Date()
    {
        /**
         *  you can change the timezone from config/codedcalculate.php
         * the default timezone is Africa/lagos
         */
        return Carbon::now()->timezone(config('codedcalculate.time_zone'));
    }

    /**
     *  @param int number of days! you can get the duration from your plan model
     * this is the duration intervals for users profits to be incremented. after the first increment,
     * the next increment date will be determined by the integer value provided.
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
     * get the expiry date from he model to help calculate it dynamically
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

    /**
     * get the next profit date to set to your model. the profit will increment exactly on the next profit date
     * till the end of the investment tenure
     * @param integer
     */
    public function GetnextProfitsDate($numofdays)
    {
        $next_profit_date = date('Y-m-d h:i:s',strtotime("+$numofdays day", strtotime($this->Date())));

        return $next_profit_date;
    }

    /**
     * this method  will calculate the proper return of investment for each plan and dynamic amount
     *  @param percentage 2.3>float will be rounded up to nearest fraction 3.
     */
    public function GetDailyRoi($percentage,$amount)
    {

        $daily_roi = $this->getPercentage($percentage,$amount);
        return $daily_roi;
    }

    /**
     * this is a helper function for date difference calculation! can be called within the view file
     *#WARNING# dont edit this code!
     */
    static function DateDiff($date1, $date2){
        //formulate the difference b/w two dates
       $date1 = strtotime($date1);
       $date2 = strtotime($date2);

        $diff = abs($date1 - $date2);

        //to get the year, divide the resultant data into total seconds in a year (365*60*60*24)
        $years = floor($diff / (365*60*60*24));

        //to get the month, subtract it with years and divide the resultant date into
        //total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

        //to get the day subtract it with years and months and divide the
        //resultant date into total seconds in a days(60*60*24)
       $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));


       //to get the hours subtract it with years months and seconds and divide the resultant date into total seconds
       // in a hour (60*60)

        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

        //to get the minuites subtrat it with years months seconds and hours and
        //divide the resultant date into total seconds i.e (60)

        $minuites = floor(($diff - $years * 365 *60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days*60*60*24-$hours*60*60) /60);

        //to get the minuites , subtract it with  years , month , seconds hours and minuites

        $seconds = floor(($diff - $years * 365*60*60*24 - $months *30*60*60*24 - $days *60*60*24 - $hours*60*60 - $minuites *60));

        //print result

         printf("%d years, %d months, %d days, %d hours, "."%d minuites, %d seconds", $years, $months, $days, $hours, $minuites, $seconds);

       }


       static function getPercentage($PercentageAmount, $MoneyAmount): int
       {

          $count1 = ($PercentageAmount/100*$MoneyAmount/1);
          $count2 = $count1;
          $count = round($count2);

           return $count;
       }

       public function CheckIncrementTime($nextdate)
       {

        if($this->Date() >= $nextdate)//fetch the next profit date from the model
        {
           //perform a database profits update at this point

           return true;

         }else
         {

            return false;
         }



       }

       public function CalculateProfits($oldbalance,$modelbalance,$dailyroi)
       {
        /**
         *  @param oldbalance = 0 outside a loop
         *  $oldbalance += $amount_in_the_user_model + calculated_daily_percentage
         */

           //get the old balance and add to the new balance
           $calcbalance = $oldbalance += $modelbalance + $dailyroi;

           return $calcbalance;
       }




}
