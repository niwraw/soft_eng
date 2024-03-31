<?php
namespace App\Helper;

class Helper
{
    public static function IDGenerator($model, $trow, $length = 5, $prefix)
    {
        $data = $model::orderBy('id', 'desc')->first();
        
        if(!$data)
        {
            $og_length = $length;
            $last_number = '1';
        }
        else
        {
            $code = substr($data->$trow, strlen($prefix) * -1);
            $actual_last_number = ($code/1) * 1;
            $last_number = $actual_last_number + 1;
            $last_number_length = strlen($last_number);
            $og_length = $length - $last_number_length;
        }

        $zeros = "";

        for($i=1; $i<=$og_length; $i++)
        {
            $zeros .= "0";
        }

        return $prefix.'-'.$zeros.$last_number;
    }
}

?>