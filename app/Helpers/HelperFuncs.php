<?php
use Illuminate\Support\Collection;

/**
 * Author: Xavier Au
 * Date: 19/5/2016
 * Time: 12:56 PM
 */

function getSettingValue(Collection $settings, $code){
    $setting = $settings->first(function($index, $setting)use($code){
       return  $setting->code == $code;
    });

    if($setting)
        return $setting->value;

    return null;
}