<?php
if(isset($_FILES['image']))
{
    $errors = array();
    $userID = $_POST['userID'];
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$file_name)));

    $expensions = array("jpeg","jpg","png","gif");
    if(in_array($file_ext,$expensions) === false)
    {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152)
    {
        $errors[] = 'File size must be excately 2 MB';
    }

    if(!count($errors))
    {
        move_uploaded_file($file_tmp,'./../content/avatar/'.$userID.'.jpg');
        echo json_encode([
            "result" => 'success',
            "file_name" => $userID.'.jpg'
        ]);
        return false;
    }
    else
    {
        echo json_encode([
            "result" => 'error',
            "errorlist" => $errors
        ]);
        return false;
    }
}
