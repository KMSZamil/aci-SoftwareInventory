<?php

use Illuminate\Support\Facades\DB;


if (!function_exists('get_period')) {
    function get_period()
    {
        return date('M y');
    }
}

if (!function_exists('get_period_formatted')) {
    function get_period_formatted()
    {
        return date('Ym');
    }
}

if (!function_exists('mssql_escape')) {
    function mssql_escape($str)
    {
        if (mssql_escape($str)) {
            $str = stripslashes(nl2br($str));
        }
        return str_replace("'", "''", $str);
    }
}

if (!function_exists('period_to_details')) {
    function period_to_details($period)
    {
        $date = DateTime::createFromFormat('Ym', $period);
        return $date->format('M Y');
    }

    if (!function_exists('get_software_id')) {
        function get_software_id()
        {

            $MaxLastSoftwareID = DB::select("SELECT MAX(CAST(RIGHT(SoftwareID,4) AS INT)) AS SoftwareID FROM Software");

            $LastSoftwareID = $MaxLastSoftwareID[0]->SoftwareID + 1;
            //dd($LastSoftwareID);

            $LastSoftwareIDLen = strlen($LastSoftwareID);
            switch ($LastSoftwareIDLen) {
                case 1:
                    $SoftwareID = '0000' . $LastSoftwareID;
                    break;
                case 2:
                    $SoftwareID = '000' . $LastSoftwareID;
                    break;
                case 3:
                    $SoftwareID = '00' . $LastSoftwareID;
                    break;
                case 4:
                    $SoftwareID = '0' . $LastSoftwareID;
                    break;
                default:
                    $SoftwareID = $LastSoftwareID;
            }
            $SoftwareID = "S" . $SoftwareID;
            return $SoftwareID;
        }
    }
}
