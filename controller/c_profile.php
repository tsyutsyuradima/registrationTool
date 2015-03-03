<?php
class C_Profile extends Controller
{
    function __construct()
    {
        $this->model = new M_Profile();
    }

    function index()
    {
        $data = [];

        if (isSet($_SESSION['userId'])) {
            $res = $this->model->getUserById($_SESSION['userId']);
            if ($res["result"] == true) {
                $data = $res["data"];
                include './view/profile.php';
            } else {
                $this->logout();
            }
        } else {
            header('Location: /index', true, 303);
            die();
        }
    }

    function logout()
    {
        unset($_SESSION['userId']);
        header('Location: /index', true, 303);
        die();
    }

    function edit()
    {
        if (isSet($_SESSION['userId'])) {
            $res = $this->model->getUserById($_SESSION['userId']);
            if ($res["result"] == true) {
                $data = $res["data"];

                $d = date_parse_from_format("Y-m-d", $data['birthday']);
                $data['day'] = $d["day"];
                $data['month'] = $d["month"];
                $data['year'] = $d["year"];

                include './view/profileEdit.php';
            } else {
                $this->logout();
            }
        } else {
            header('Location: /index', true, 303);
            die();
        }
    }

    function saveChanges()
    {
        if (isSet($_SESSION['userId']))
        {
            $res = $this->model->getUserById($_SESSION['userId']);
            if ($res)
            {
                $sEmail = $_POST['email'];
                $sSex = (int)($_POST['sex'] == 'male') ? 1 : 0;

                $first_name = $_POST['firstName'];
                $last_name = $_POST['lastName'];
                $middle_name = $_POST['middleName'];
                $phone = $_POST['phone'];
                $hometown = $_POST['hometown'];
                $month = $_POST['month'];
                $day = $_POST['day'];
                $year = $_POST['year'];
                $birthday = $year.'-'.$month.'-'.$day;

                $sErrors = [];

                if ($sSex < 0 OR $sSex > 1) {
                    $sErrors[] = 'Sex is wrong';
                }

                if (strlen($sEmail) <= 0) {
                    $sErrors[] = 'Address email is too short';
                }

                if (strlen($sEmail) > 55) {
                    $sErrors[] = 'Address email is too long';
                }

                if (!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $sEmail)) {
                    $sErrors[] = 'Email is wrong';
                }

                if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-]/', $sEmail)) {
                    $sErrors[] = 'Email with special characters';
                }

                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $hometown)) {
                    $sErrors[] = 'Hometown with special characters';
                }

                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $first_name)) {
                    $sErrors[] = 'First name with special characters';
                }
                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $last_name)) {
                    $sErrors[] = 'Last name with special characters';
                }
                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $middle_name)) {
                    $sErrors[] = 'Middle name with special characters';
                }

                if (count($sErrors)) {
                    echo json_encode(['result' => 'error', 'errorlist' => $sErrors]);
                    return false;
                }

                $connectDB = MySQL::getInstance();
                $connectDB->query("UPDATE user SET email = '" . $sEmail . "', sex = ".$sSex.", first_name = '" . $first_name . "', last_name = '".$last_name."', middle_name = '".$middle_name."', hometown = '".$hometown."', birthday = '".$birthday."', phone = '".$phone."' WHERE id = " . $_SESSION['userId']);

                echo json_encode(['result' => 'success']);
                return false;

            }
            else
            {
                $this->logout();
            }
        }
        else
        {
            header('Location: /index', true, 303);
            die();
        }
    }
}
