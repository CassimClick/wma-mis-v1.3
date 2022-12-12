<?php

// use NumberFormatter;

function  trimmed(string $str): string
{
    return str_replace(' ', '', $str);
}

function toWords($number): string
{
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucwords($f->format($number)) . ' Tanzanian Shillings Only';
}


function numString(int $size){
    return random_string('numeric', $size);
}


function randomString(){
    return random_string('alnum', 42);
}

function printer($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
      
}


