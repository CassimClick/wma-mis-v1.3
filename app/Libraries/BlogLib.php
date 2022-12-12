<?php namespace App\Libraries; 
 class BlogLib{
     public function postItem($params){
         return view('Components/postItem', $params);
     }
 }

?>