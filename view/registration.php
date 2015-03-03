<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="./js/main.js"></script>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <link type="text/css" href="./css/main.css" rel="stylesheet" />
</head>

<script>
    setLeng('<?=$_SESSION['lang']?>');

    $(document).ready(function(){
        $('#uploadClick').on('click', function(){
            var image = $("#image").val();
            var formData = new FormData();
            formData.append('image', $('#image')[0].files[0]);

            $.ajax({
                url : '/library/upload.php',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data)
                {
                    console.log(data);
                    $("#icon").attr('src', "/content/taskicon/"+data.file_name);
                    $("#url_icon").val(data.file_name);
                    alert(data);
                }
            });
            return false;
        });


        $('#cancel').on('click', function(){
            window.location.href = '/';
            return false;
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            var res =  validateAll('results');
            if(res == true)
            {
                $.ajax({
                    type: 'post',
                    url: './registration/signin',
                    data: $('form').serialize(),
                    dataType: "json",
                    success: function (json) {
                        if (json.result == 'success')
                        {
                            var image = $("#image").val();
                            if (image !='') {
                                var formData = new FormData();
                                formData.append('image', $('#image')[0].files[0]);
                                formData.append('userID', json.userID);

                                $.ajax({
                                    url: '/library/upload.php',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: "json",
                                    success: function (json) {
                                        if (json.result == 'success')
                                        {
                                            window.location.href = '/';
                                        }
                                        else
                                        {
                                            var errorlist = '';
                                            $.each(json.errorlist, function (i, error) {
                                                errorlist += error + '<br />';
                                            });
                                            document.getElementById('results').innerHTML = errorlist;
                                            $('#results').css('display','block');
                                        }
                                    }
                                });
                            }
                            else
                            {
                                window.location.href = '/';
                            }
                        }
                        else
                        {
                            var errorlist = '';
                            $.each(json.errorlist, function(i, error) {
                                errorlist += error + '<br />';
                            });
                            document.getElementById('results').innerHTML = errorlist;
                            $('#results').css('display','block');
                        }
                    }
                });
            }
            return false;
        });

        $('#month').on('change', function (e) {
        //fill day dropdown
            var i = $(this).val();
            var e = document.getElementById('day');
            while(e.length>0)
                e.remove(e.length-1);
            var j=-1;
            if(i=="na")
                k=0;
            else if(i==2)
                k=28;
            else if(i==4||i==6||i==9||i==11)
                k=30;
            else
                k=31;
            while(j++<k)
            {
                var s=document.createElement('option');
                var e=document.getElementById('day');
                if(j==0)
                {
                    s.text="<?=i18n::get('day');?>"    ;
                    s.value="na";
                    try
                    {
                        e.add(s,null);
                    }
                    catch(ex)
                    {
                        e.add(s);
                    }
                }
                else
                {
                    s.text=j;
                    s.value=j;
                    try
                    {
                        e.add(s,null);
                    }
                    catch(ex)
                    {
                        e.add(s);
                    }
                }
            }
        });

        //fill years dropdown
        y = 2015;
        while (y-->1960)
        {
            var s = document.createElement('option');
            var e = document.getElementById('year');
            s.text=y;
            s.value=y;
            try
            {
                e.add(s,null);
            }
            catch(ex)
            {
                e.add(s);
            }
        }
    });
</script>

<body>
<header>
</header>
<div id="results"></div>

<form id="form" class="container" >
    <table  cellspacing="12">
        <tr>
            <td class="label" width="140"><?= i18n::get('login'); ?></td>
            <td class="td2">
                <input type="text" maxlength="25" name="login" id="login" required>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('pass'); ?></td>
            <td class="td2">
                <input type="password" name="pass" id="pass" required>
                <div id="pass_result"></div><br/>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('сonfirmPass'); ?></td>
            <td class="td2">
                <input type="password" name="cpass" id="c_password" onfocusout="compare_valid('pass', 'c_password')" required>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('firstName'); ?></td>
            <td class="td2">
                <input type="text" maxlength="25" name="firstName" id="firstName" required>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('lastName'); ?></td>
            <td class="td2">
                <input type="text" maxlength="25" name="lastName" id="lastName" required>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('middleName'); ?></td>
            <td class="td2">
                <input type="text" maxlength="25" name="middleName" id="middleName">
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('sex'); ?></td>
            <td class="td2">
                <input type="radio" name="sex" id="sex" value="female" checked><?= i18n::get('female'); ?>
                <input type="radio" name="sex" value="male"><?= i18n::get('male'); ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('birthday'); ?></td>
            <td class="td2">
                <select name="month" id="month">
                    <option value="na"><?=i18n::get('month');?></option>
                    <?php
                    for($i=1; $i<=12; $i++)
                    {
                        echo "<option value=".$i.">".i18n::get('month_'.$i)."</option>";
                    }?>
                </select>
                <select name="day" id="day">
                    <option value="na"><?=i18n::get('day');?></option>
                </select>
                <select name="year" id="year">
                    <option value="na"><?=i18n::get('year');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('email'); ?></td>
            <td class="td2">
                <input type="text" name="email" id="email" maxlength="50" required>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('phone'); ?></td>
            <td class="td2"><input type="text" name="phone" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('hometown'); ?></td>
            <td class="td2"><input type="text" name="hometown" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('photo'); ?></td>
            <td class="td2">
                <div>
                    <input type="file" id="image" name="image" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="<?= i18n::get('registration'); ?>">
                <input type="submit" name="cancel" id="cancel" value="<?= i18n::get('cancel'); ?>">
            </td>
        </tr>
    </table>
</form>

<?php include "./view/footer.php"?>
</body>
</html>