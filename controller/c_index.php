<?php
include_once("library/MySQL.php");

class C_Index extends Controller
{
    function __construct()
    {
        $this->model = new M_Index();
    }

    function index()
    {
        if(isSet($_SESSION['userId']))
        {
            header( 'Location: /profile', true, 303 );
            die();
        }
        else
        {
            include './view/index.php';
        }

        $connectDB = MySQL::getInstance();
        $connectDB->query("SELECT * FROM user");
    }

    function setLang()
    {
        $lang = (empty($_POST["lang"])) ? "en" : $_POST["lang"];
        i18n::setLang($lang);
    }

    function signin()
    {
        if (isSet($_SESSION['userId']))
        {
            header('Location: /index', true, 303);
            die();
        }
        else
        {
            $login = (empty($_POST["login"])) ? "" : $_POST["login"];
            $pass = (empty($_POST["pass"])) ? "" : $_POST["pass"];
            $res = $this->model->signin($login, $pass);
            echo json_encode($res);
        }
    }
}