<?php

namespace App\Libraries;


class CommonTasksLibrary
{

    public function getVariable($var)
    {
        $input = $this->request->getPost($var);
        return strip_tags($input);
    }





    function processFile($file)
    {
        if ($file->isValid() && !$file->hasMoved()) {

            $randomName = substr($file->getName(), 0, -4) . '_' . $file->getRandomName();
            if ($file->move(FCPATH . '/uploads/documents/', $randomName)) {


                return    base_url() . '/uploads/documents/' . $randomName;
            }
        }
    }
    function nextYear($currentDate)
    {
        $date = strtotime($currentDate);
        $nexDate = strtotime("+1 Years", $date);
        return date("Y-m-d", $nexDate);
    }
    function nextFiveYears($currentDate)
    {
        $date = strtotime($currentDate);
        $nexDate = strtotime("+5 Years", $date);
        return date("Y-m-d", $nexDate);
    }

    function dateFormatter($actualDate)
    {
        $date = strtotime($actualDate);
        return date("d M Y", $date);
    }


    function payment()
    {
        return  ['Paid', 'Pending'];
    }
}
