<?php 

function Success(){
 
    $flashData = session()->getFlashdata('success');
   
    if($flashData != null){
        return <<<"HTML"
        <script>
           swal({
           title:'$flashData',
           icon: "success",
           });
        </script>
     HTML;
    }
}
function Error(){
  
    $flashData = session()->getFlashdata('error');
   
     if($flashData != null){
      return <<<"HTML"
        <script>
           swal({
           title:'$flashData',
           icon: "warning",
           });
        </script>
     HTML;
     }
}
