<?php
require_once "./library/MySQL.php";

class M_Index extends Model
{
    function signin($login, $pass)
    {
        $passMD5 = md5($pass);
        $res = MySQL::getInstance()->fetch("SELECT id FROM user WHERE login = '".$login."' AND password = '".$passMD5."';");
        if($res)
        {
            $_SESSION['userId'] = $res['id'];
            return ["result"=>true];
        }
        else
        {
            return ["result"=>false]; // ,"message"=>"MESSAGE WITH PARAMS"];
        }
    }
}
