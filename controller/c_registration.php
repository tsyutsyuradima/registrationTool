<?php
include_once("library/MySQL.php");

class C_Registration extends Controller
{
    function __construct()
    {
        $this->model = new M_Registration();
    }

    function index()
    {
        if (isSet($_SESSION['userId']))
        {
            header('Location: /index', true, 303);
            die();
        }
        else
        {
            include './view/registration.php';
        }
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
            $sLogin = $_POST['login'];
            $sPass = $_POST['pass'];
            $sCPass = $_POST['cpass'];
            $sEmail = $_POST['email'];
            $sSex = (int)($_POST['sex'] == 'male') ? 1 : 0;

            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $middle_name = $_POST['middleName'];
            $month = $_POST['month'];
            $day = $_POST['day'];
            $year = $_POST['year'];
            $hometown = $_POST['hometown'];
            $phone = $_POST['phone'];
            $birthday = $year.'-'.$month.'-'.$day;

            if ($month=='na' OR $day=='na' OR $year=='na')
            {
                $sErrors[] = i18n::get('Birthday is wrong');
            }

            if ($sSex < 0 OR $sSex > 1)
            {
                $sErrors[] = i18n::get('Sex is wrong');
            }

            if (strlen($sEmail) <= 0)
            {
                $sErrors[] = i18n::get('Address email is too short');
            }

            if (strlen($sEmail) > 55)
            {
                $sErrors[] = i18n::get('Address email is too short');
            }

            if (!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $sEmail))
            {
                $sErrors[] = i18n::get('Email is wrong');
            }

            if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $sEmail))
            {
                $sErrors[] = i18n::get('Email with special characters');
            }

            if (strlen($sPass) < 6)
            {
                $sErrors[] = i18n::get('Password is too short');
            }

            if (strlen($sPass) > 25)
            {
                $sErrors[] = i18n::get('Password is too long');
            }

            if ($sPass != $sCPass)
            {
                $sErrors[] = i18n::get('Passwords are not the same');
            }

            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $sPass))
            {
                $sErrors[] = i18n::get('Passwords with special characters');
            }

            if (strlen($sLogin) < 3)
            {
                $sErrors[] = i18n::get('Login is too short');
            }

            if (strlen($sLogin) > 25)
            {
                $sErrors[] = i18n::get('Login is too long');
            }

            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $sLogin))
            {
                $sErrors[] = i18n::get('Login with special characters');
            }

            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $hometown))
            {
                $sErrors[] = i18n::get('Hometown with special characters');
            }

            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $first_name))
            {
                $sErrors[] = i18n::get('First name with special characters');
            }
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $last_name))
            {
                $sErrors[] = i18n::get('Last name with special characters');
            }
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $middle_name))
            {
                $sErrors[] = i18n::get('Middle name with special characters');
            }

            if (count($sErrors))
            {
                echo json_encode(['result'=>'error', 'errorlist' => $sErrors]);
                return false;
            }

            $connectDB = MySQL::getInstance();
            $sErrors = [];
            $rowLogin = $connectDB->fetch('SELECT * FROM user WHERE login = "' . $sLogin . '"');
            if ($rowLogin['id'])
            {
                $sErrors[] =  i18n::get("This login is already exist");
            }

            $rowEmail = $connectDB->fetch('SELECT * FROM user WHERE email = "' . $sEmail . '"');
            if ($rowEmail['id'])
            {
                $sErrors[] = i18n::get("This Email is already exist");
            }

            if (count($sErrors))
            {
                echo json_encode(['result'=>'error', 'errorlist' => $sErrors]);
                return false;
            }

            $connectDB->query("INSERT INTO user (login, password, first_name, last_name, middle_name, sex, birthday, email, phone, hometown)
                               VALUES ('".$sLogin."', '".md5($sPass)."', '".$first_name."', '".$last_name."', '".$middle_name."', '".$sSex."', '".$birthday."', '".$sEmail."', '".$phone."', '".$hometown."');");
            $row = $connectDB->fetch('SELECT LAST_INSERT_ID() as userID FROM user');

            echo json_encode(['result'=>'success', 'userID'=>$row['userID']]);
            return false;
        }
    }
}