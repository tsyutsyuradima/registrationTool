<?php
    //http://www.script-tutorials.com/form-validation-with-javascript-and-php/ useful
    //http://runnable.com/Uaki4q9qiqlLAACJ/how-to-validate-a-form-in-php-using-jquery-for-validation
    //http://www.the-art-of-web.com/javascript/ajax-validate/
    //http://php-html.net/tutorials/model-view-controller-in-php/
    //http://habrahabr.ru/post/150267/#RouterCoding

    session_start();
    require_once 'core/model.php';
    require_once 'core/controller.php';
    require_once 'core/route.php';
    require_once 'localization/i18n.php';
    Route::start();
?>
