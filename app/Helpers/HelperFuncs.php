<?php
use App\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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

function getSettingsFromCache(){
    return  Cache::tags(['setting'])->rememberForever('settings',function(){
        return Setting::all();
    });
}

function refreshForeverCache(String $key, $value){
    Cache::forget($key);
    Cache::rememberForever($key,function()use($value){
        return $value;
    });
}


function getWebPageMetaTags($str)
{
    $pattern = '
  ~<\s*meta\s

  # using lookahead to capture type to $1
    (?=[^>]*?
    \b(?:name|property|http-equiv)\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  )

  # capture content to $2
  [^>]*?\bcontent\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  [^>]*>

  ~ix';

    if (preg_match_all($pattern, $str, $out)) {
        return array_combine($out[1], $out[2]);
    }

    return array();
}