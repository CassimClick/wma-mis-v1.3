<?php
function displayError($validation, $field)
{
  if(isset($validation)){
      if($validation->hasError($field)){
        
        return str_replace(['The', 'Field'], ['', ''], humanize($validation->getError($field)));
         
      }
      else{
          return false;
      }
  }

}


function setSelect(string $value, string $match): string
{
  if ($value ===  $match) {
    return 'selected="selected"';
  } else {
    return '';
  }
}
