<?php

namespace App\Service;

class Alerts
{
    public static function getAlerts(): array
    {
        $tempArray = $_SESSION['alerts'];
        $_SESSION['alerts'] = [];

        return $tempArray;
    }

    public static function addAlert(string $type, string $message): void
    {
        array_push($_SESSION['alerts'], ['type' => $type, 'message' => $message]);
    }
}
