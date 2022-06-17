# laravel-tradio

[![Latest Version](https://img.shields.io/github/release/bcoded200/laravel-tradio.svg?style=flat-square)](https://github.com/bcoded200/laravel-tradio/releases)

[![Issues](https://img.shields.io/github/issues/bcoded200/laravel-tradio.svg?style=flat-square)](https://packagist.org/packages/laraveltradio/calculator)

[![Forks](https://img.shields.io/github/forks/bcoded200/laravel-tradio.svg?style=flat-square)](https://packagist.org/packages/laraveltradio/calculator)


[![Forks](https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2Fbcoded200%2Flaravel-tradio.svg?style=flat-square)](https://twitter.com/codedwebltd)





a laravel package/library  that takes the  pain out of investment automatic calculation! calculating investment can be a pain in the ass especially when you are coming from core php to a php framework. this tool helps you

integrate and implement this calculation automatically! without any hassle. kindly follow the whole process and only reach out to the developer when you are stucked! if you are trying to integrate this work to a core php project then follow this link for core php version of the project.

# https://www.github.com/bcoded200/investment-auto-calculator

                If you are using laravel, kindly continue reading the instructions below!

## How to install

## composer require laraveltradio

once composer finish the installation, an automatic autoloader will be generated. if you are on laravel 5.x and lower, you have to manually register the providers. To do so, go to config/app.php and scroll down to providers array, in the list add below code.

##   Chris\Calculator\CalculatorServiceProvider::class,

now to check if the script is working, strt your laravel application and navigate to /calculate if everything works fine, then proceed with the next step.

## Changeing timezone

Timezone helps your investment return according to your own timezone. the defualt is Africa/lagos. to change the timezone, we neeed to publish the vendor with below command

# php artisan vendor:publish

choose the option that says  Chris\Calculator\CalculatorServiceProvider. A file called codedcalculate.php will be created in the config folder, open the file and set your timezone accordingly!

# How to use the script to calculate investment

in your controller, import the script class

# use Chris\Calculator\Controllers\CalcController as Codedwebltd;

$calculate = new   Codedwebltd;

# to fetch date

$date = $calculate->Date(); //output 2022-06-17 00:41:41

# format duration of investment to a well-formed integer

$days = $calculate->GetnumOfDays($duration); //output "3 Days" => becomes 3

# check if an investment has reached its maturity date / ended.

$enddate = $calculate->CheckMaturityDate($enddate);

if($enddate == 1) //data type is boolean . 1means posetive and false means negative
{
    //logic to notify users that the said plan has ended.
}else
{
    //logic to incrememnt the users profits
}

# get the increment time for the next profit date

$incrementdate = $calculate->GetIncrementTime($days)//output an integer ready to be added to the current date. E.g 5

# add current date to the increment time to get the next profit date

$Addtodate = GetnextProfitsDate($incrementdate)//outputs  2022-06-17 00:41:41 + 5 = 2022-06-22 00:41:41

# Get the daily return according to the plan percentage and amount user invested

$getpercent =  GetDailyRoi($percentage,$amount); //output E.g 3.5 % of 500usd = 17.5usd every next profit date

# get the percentage of the amount invested
 $calc = Codedwebltd::getPercentage($PercentageAmount, $MoneyAmount);//output the total percentage of a number with result rounded  up to the nearest fraction. 6.7Usd becomes 7Usd.

# calculatethe right time to increment the user balance

$righttime = CheckIncrementTime($Addtodate);;//returns boolean

if($righttime == 1)
{
     //perform a database profits update at this point to automatically incrememnt the users profit with the calculated  profits percentage.

     //you can set this in crun job

}else
{
//do something or nothing
}


