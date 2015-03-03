<!DOCTYPE html>
<html>
<head>
    <title>Authentication</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="/js/jquery.js"></script>
    <link type="text/css" href="/css/main.css" rel="stylesheet" />
</head>

<script>
    $(document).ready(function(){
        $("#edit").on("click", function(){
            window.location.href="/profile/edit";
        });
        $("#logout").on("click", function(){
            window.location.href="/profile/logout";
        });

        $(function(){
            $("#upload_link").on('click', function(e){
                e.preventDefault();
                $("#image:hidden").trigger('click');
            });
        });

        $('#image').on('change', function(){
            var formData = new FormData();
            formData.append('image', $('#image')[0].files[0]);
            formData.append('userID', <?=$_SESSION['userId']?>);
            $.ajax({
                url: '/library/upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (json) {
                    if (json.result == 'success') {
                        $('.avatar .img img').attr('src', '/content/avatar/<?=$_SESSION['userId']?>.jpg?' + Math.floor((Math.random() * 10000) + 999999));
                    } else {
                        var errorlist = '';
                        $.each(json.errorlist, function (i, error) {
                            errorlist += error + '<br />';
                        });
                        document.getElementById('results').innerHTML = errorlist;
                        $('#results').css('display','block');
                    }
                }
            });
        });
    });
</script>

<body>
<div id="results"></div>
<div class="profile">
    <table  cellspacing="12" width="300" style="float: left;">
        <tr>
            <td class="label"><?= i18n::get('login'); ?></td>
            <td class="td2">
                <i name="login" id="login"><?=$data['login']?></i>
            </td>
        </tr>

        <tr>
            <td class="label"><?= i18n::get('firstName'); ?></td>
            <td class="td2">
                <i name="firstName" id="firstName"><?=$data['firstName']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('lastName'); ?></td>
            <td class="td2">
                <i readonly="true" name="lastName" id="lastName"><?=$data['lastName']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('middleName'); ?></td>
            <td class="td2">
                <i readonly="true" name="middleName" id="middleName"><?=$data['middleName']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('sex'); ?></td>
            <td class="td2">
                <i readonly="true" name="sex" id="sex"><?=$data['sex']?></i>
            </td>
        </tr>
        <tr>
            <td class="label">Birthday : </td>
            <td class="td2">
                <i readonly="true" name="birthday" id="birthday"><?=$data['birthday']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('email') ?></td>
            <td class="td2">
                <i readonly="true" name="email" id="email"><?=$data['email']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('phone'); ?></td>
            <td class="td2">
                <i readonly="true" name="phone" id="phone"><?=$data['phone']?></i>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('hometown'); ?></td>
            <td class="td2">
                <i readonly="true" name="hometown" id="hometown"><?=$data['hometown']?></i>
            </td>
        </tr>
        <tr>
            <td ></td>
            <td class="td2">
                <button style="padding: 5px 10px 7px 10px; border-radius: 5px; background-color: azure;" id="edit"><?= i18n::get('edit'); ?></button>
                <button style="padding: 5px 10px 7px 10px; border-radius: 5px; background-color: azure;" id="logout"><?= i18n::get('logout'); ?></button>
            </td>
        </tr>
    </table>
    <div class="avatar">
        <div class="img">
            <?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/content/avatar/'.$_SESSION['userId'].'.jpg')) :?>
                <img src="/content/avatar/<?=$_SESSION['userId']?>.jpg" width="100">
            <?php else:?>
                <img src="/content/avatar/default.png" width="100">
            <?php endif;?>
        </div>
        <div class="link">
            <input style="display: none;" type="file" id="image" name="image" />
            <a href="#" id="upload_link"><?= i18n::get('upload'); ?></a>​
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<?php include "./view/footer.php"?>
</body>
</html>