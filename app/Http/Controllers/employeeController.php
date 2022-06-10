<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use DateTime;


class employeeController extends Controller
{


    public function __construct()
    {
        $this->todaysDate =  new DateTime();
    }
  

    public function index()
    {
      $employees = Http::get('https://interview-assessment-1.realmdigital.co.za/employees')->json();
      
      
        foreach($employees as $employee){

            
            $dateOfBirthConvert = date_create($employee['dateOfBirth']);
            
            $dateOfBirth = $dateOfBirthConvert->format("m-d");

            $checkDOB = $this->leapYear($dateOfBirth, $dateOfBirthConvert);
            
            if($checkDOB == $this->todaysDate->format('m-d')){
                $this->sendEmail();
            }

        }
    }


    private function sendEmail(){
        //send email here
    }

    private function leapYear($dateOfBirth, $dateOfBirthConvert){

        if($this->todaysDate->format('L') == '1'){
            if($this->todaysDate->format('m') == '02' && $dateOfBirthConvert->format('d')=='29' ){
           
             $dateOfBirth = '02-28';
           }
         }

         return $dateOfBirth;

    }
}