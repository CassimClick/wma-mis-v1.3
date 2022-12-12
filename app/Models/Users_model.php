<?php namespace App\Models;
use CodeIgniter\Model;



class Users_model extends Model {

  public function getData()
  {
     $subjects = [
     
      
       [ "subject" => "JavaScript Object Notation","abr"=>"JSON"],
       [ "subject" => "HyperText Pre Processor","abr"=>"PHP"],
       [ "subject" => "Application Programming Interface","abr"=>"API"],
       [ "subject" => "Asynchronous JavaScript and XML","abr"=>"Ajax"],
    
      
      ];

      return $subjects;
     
  }

  

}