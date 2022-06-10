<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class employeeController extends Controller
{
  
    public function index()
    {
       $employees = Http::get('https://interview-assessment-1.realmdigital.co.za/employees')->json();

       $todaysDate = date("m-d");

        foreach($employees as $employee){

            $dateOfBirthConvert = date_create($employee['dateOfBirth']);
            
            $dateOfBirth = $dateOfBirthConvert->format("m-d");

            if($dateOfBirth == $todaysDate){
                $this->sendEmail();
            }

        }
    }


    private function sendEmail(){
        //send email here
    }
}