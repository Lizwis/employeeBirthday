<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use DateTime;

use Illuminate\Support\Facades\Mail;
use App\Mail\employeeMail;


class employeeController extends Controller
{


    public function __construct()
    {
        $this->todaysDate =  new DateTime();
    }
  

    public function index()
    {
      $employees = Http::get('https://interview-assessment-1.realmdigital.co.za/employees')->json();
      $doNotSend =  Http::get('https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes')->json();

      $birthdayNames = "";
      
        foreach($employees as $employee){

            if(!in_array($employee['id'],$doNotSend)){

                $dateOfBirthConvert = date_create($employee['dateOfBirth']);
                $dateOfBirth = $dateOfBirthConvert->format("m-d");
               
                if($employee['employmentEndDate'] == null && $employee['employmentStartDate'] !== null){

                    $notificationYear = " ";
                    
                    if($employee['lastBirthdayNotified'] ?? null){
                        $checkLastNotificationYear = date_create($employee['lastBirthdayNotified']);
                        $notificationYear = $checkLastNotificationYear->format("Y");
                    }


                    if($notificationYear !== $this->todaysDate->format('Y')){
                       $checkDOB = $this->leapYear($dateOfBirth, $dateOfBirthConvert);

                       if($checkDOB == $this->todaysDate->format('m-d')){
                            $birthdayNames .= $employee['name']. ' ,';
                            Http::patch('https://interview-assessment-1.realmdigital.co.za/employees/'.$employee['id'],['lastBirthdayNotified' => date('Y-m-d')]);
                        }
                    }
                }
            }
        }

        return $this->sendEmail($birthdayNames);
    }


    private function sendEmail($birthdayNames){
        if($birthdayNames){
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new employeeMail($birthdayNames));
        }
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