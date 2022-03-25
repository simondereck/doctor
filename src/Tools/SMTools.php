<?php
namespace App\Tools;



class SMTools
{

    public static  $IS_ADMIN = 0x001;

    public static $IS_USER = 0x002;

    public static function publish($arr){
        echo "<pre>";
        var_dump($arr);
        die;
    }

    public static function getDateString():string
    {
        return date_format(date_create(), 'Y-m-d H:i:s');
    }


    public static function getDateLocal():string
    {
        return date_format(date_create(), 'y-m');
    }




}