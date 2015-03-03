<!DOCTYPE html>
<html>
<head>
    <title>Authentication</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="./js/jquery.js"></script>
    <link type="text/css" href="./css/main.css" rel="stylesheet" />
</head>

<script>
    $(document).ready(function(){
        $("#signin").on("click", function(){
            var login = $("#login").val();
            var pass = $("#pass").val();

            if(login.length > 0 && pass.length >0)
            {
                $("#error").hide();
                 $.ajax({
                    type: 'post',
                    url: './index/signin',
                    data: {login : login, pass : pass},
                    dataType: "json",
                    success: function (json) {
                        if(json.result == true) {
                            window.location.href="/profile";
                        } else {
                            $("#error").show();
                            //$("#error").html(json.message).show();
                        }
                    }
                });
            }
            else
            {
                $("#error").html("Login or password is not correct").show();
            }
        });

        $("#signup").on("click", function(){
            window.location.href="/registration";
        });
    });
</script>

<body>

<div class="auth">
    <div class="row">
        <div class="coll c30 label"><?= i18n::get('login'); ?></div>
        <div class="coll c80"><input type="text" maxlength="25" name="login" id="login" required></div>
    </div>
    <div class="row">
        <div class="coll c30 label"><?= i18n::get('pass'); ?></div>
        <div class="coll c70"><input type="password" name="pass" id="pass" required></div>
    </div>
    <div class="row">
        <div class="coll c30"></div>
        <div class="coll c40 right"><button class="btn" id="signin"><?= i18n::get('signIn'); ?></button></div>
        <div class="coll c30 right"><button id="signup"><?= i18n::get('signUp'); ?></button></div>
    </div>
    <i style="padding-left: 32px; color: red" hidden="true" id="error"><?= i18n::get('wrongLogin'); ?></i>
</div>

<?php include "./view/footer.php"?>

</body>
</html>