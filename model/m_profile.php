<?php
require_once "./library/MySQL.php";

class M_Profile extends Model
{
    function getUserById($userId)
    {
        $res = MySQL::getInstance()->fetch("SELECT * FROM user WHERE id = " . $userId . ";");
        if($res)
        {
            $res = [
                "login" => $res['login'],
                "firstName" => $res['first_name'],
                "lastName" => $res['last_name'],
                "middleName" => $res['middle_name'],
                "sex" => ($res['sex']==1) ? i18n::get("male")  : i18n::get("female"),
                "birthday" => $res['birthday'],
                "email" => $res['email'],
                "phone" => $res['phone'],
                "hometown" => $res['hometown']];
            return [
                "result"=>true,
                "data"=>$res
            ];
        }
        else
        {
            return ["result"=>false]; // ,"message"=>"MESSAGE WITH PARAMS"];
        }
        return $res;
    }
}
