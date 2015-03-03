<?php
class i18n
{
    private static $strings = [];
    private static function getStatic()
    {
        if(empty(self::$strings))
        {
            if(isSet($_SESSION['lang']))
            {
                $lang = $_SESSION['lang'];
            }
            else if(isSet($_COOKIE['lang']))
            {
                $lang = $_COOKIE['lang'];
            }
            else
            {
                $lang = 'en';
            }

            $file = "./localization/local_".$lang.".json";
            if(file_exists($file))
            {
                $json = json_decode(file_get_contents($file));
            }
            else
            {
                $file = "./localization/local_en.json";
                $json = json_decode(file_get_contents($file));
            }
            self::$strings = $json;
        }
    }

    public static function setLang($lang)
    {
        $_SESSION['lang'] = $lang;
        setcookie("lang", $lang, time() + (60 * 60 * 24 * 30));
        self::$strings = [];
    }

    public static function get($string)
    {
        self::getStatic();
        if (isset(self::$strings->$string))
        {
            return self::$strings->$string;
        }
        return '';
    }
}