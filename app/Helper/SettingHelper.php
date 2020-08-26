<?php 

namespace App\Helper;

use App\Setting;

class SettingHelper
{
    public static function getSetting()
    {
        $settings = Setting::get()->first();
        return $settings;
    }

}