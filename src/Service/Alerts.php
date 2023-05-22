<?php

namespace App\Service;

class Alerts
{
    public static function getAlerts()
    {
        $tempArray = $_SESSION['alerts'];
        $_SESSION['alerts'] = [];

        return $tempArray;
    }

    public static function addAlert($type, $message)
    {
        array_push($_SESSION['alerts'], ['type' => $type, 'message' => $message]);
    }
}
