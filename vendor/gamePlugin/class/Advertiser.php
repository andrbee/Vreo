<?php

class Advertiser
{
    protected function receiveJson()
    {
        return json_decode(file_get_contents("php://input"), true);

    }

    protected function score($screenPercentage, $costPerView)
    {
        $percentage = $screenPercentage;
        $cost = $costPerView;
        if ($percentage >= 3 && $percentage <= 10) {
            return round((($percentage / 100) * 10), 3);
        } elseif ($percentage >= 10) {
            return 1;
        } else {
            return 0;
        }
    }
}
