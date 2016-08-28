<?php
/**
 * Author: Xavier Au
 * Date: 27/8/2016
 * Time: 2:33 PM
 */

namespace App\Contracts;


interface InStream
{
    public function stream();
    public function loadStandardFetchSetting();
}