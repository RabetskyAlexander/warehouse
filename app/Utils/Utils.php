<?php

namespace App\Utils;

class Utils
{
    public static function stringFormat ( $str ){
        return    str_replace([',','.',' ','-','+','!','?','/','=','"'],'', $str);
    }
}