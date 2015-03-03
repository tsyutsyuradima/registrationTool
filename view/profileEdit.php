<!DOCTYPE html>
<html>
<head>
    <title>Edit profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="/js/jquery.js"></script>
    <link type="text/css" href="/css/main.css" rel="stylesheet" />
</head>

<script>
    $(document).ready(function(){

        $("#save").on("click", function(){
            $.ajax({
                type: 'post',
                url: '/profile/saveChanges',
                data: $('form').serialize(),
                dataType: "json",
                success: function (json) {
                    if (json.result == 'success') {
                        window.location.href="/";
                    } else {
                        var errorlist = '';
                        $.each(json.errorlist, function(i, error) {
                            errorlist += error + '<br />';
                        });
                        document.getElementById('results').innerHTML = errorlist;
                        $('#results').css('display', 'block');
                    }
                }
            });
            return false;
        });

        $("#cancel").on("click", function(){
            window.location.href = '/';
            return false;
        });

        function checkDaysInMonth(month)
        {
            var e = document.getElementById('day');
            while(e.length>0)
                e.remove(e.length-1);
            var j=-1;
            if(month=="na")
                k=0;
            else if(month==2)
                k=28;
            else if(month==4||month==6||month==9||month==11)
                k=30;
            else
                k=31;

            var userDay = $("#day").data('day');

            while(j++<k)
            {
                var s=document.createElement('option');
                var day=document.getElementById('day');
                if(j==0)
                {
                    s.text="<?=i18n::get('day');?>"    ;
                    s.value="na";
                    try
                    {
                        day.add(s,null);
                    }
                    catch(ex)
                    {
                        day.add(s);
                    }
                }
                else
                {
                    s.text=j;
                    s.value=j;
                    try
                    {
                        day.add(s,null);
                        if(j == userDay)
                        {
                            s.selected = 'selected';
                        }
                    }
                    catch(ex)
                    {
                        day.add(s);
                    }
                }
            }
        }

        checkDaysInMonth($("#month").val());

        $('#month').on('change', function (e) {
            checkDaysInMonth($("#month").val());
        });

        //fill years dropdown
        y = 2015;
        var year = $("#year").data('year');

        while (y-->1960)
        {
            var s = document.createElement('option');
            var e = document.getElementById('year');
            s.text=y;
            s.value=y;
            try
            {
                e.add(s,null);
                if(y == year)
                {
                    s.selected = 'selected';
                }
            }
            catch(ex)
            {
                e.add(s);
            }
        }
    });
</script>

<body>
<div id="results"></div>
<form id="form" class="container" >
    <table  cellspacing="12">
        <tr>
            <td class="label" width="140"><?= i18n::get('firstName'); ?></td>
            <td class="td2"><input type="text" name="firstName" value="<?=$data['firstName']?>" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('lastName'); ?></td>
            <td class="td2"><input type="text" name="lastName" value="<?=$data['lastName']?>" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('middleName'); ?></td>
            <td class="td2"><input type="text" name="middleName" value="<?=$data['middleName']?>" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('sex'); ?></td>
            <td class="td2">
                <input type="radio" name="sex" id="sex" value="female"
                       <?=($data['sex'] == 'female') ? "checked" : ""?> > <?= i18n::get('female'); ?>
                <input type="radio" name="sex" value="male"
                    <?=($data['sex'] == 'male') ? "checked" : ""?> > <?= i18n::get('male'); ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('birthday'); ?></td>
            <td class="td2">
                <select name="month" id="month">
                    <option value="na"> <?=i18n::get('month');?> </option>
                    <?php for($i=1; $i<=12; $i++) :?>
                    <option value="<?=$i;?>" <?=($data['month'] == $i) ? "selected" : "" ?> > <?=i18n::get('month_'.$i);?> </option>
                    <?php endfor;?>
                </select>
                <select name="day" id="day" data-day="<?=$data['day']?>">
                    <option value="na"> <?=i18n::get('day');?> </option>
                </select>
                <select name="year" id="year" data-year="<?=$data['year']?>">
                    <option value="na"><?=i18n::get('year');?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('email') ?></td>
            <td class="td2"><input type="text" name="email" value="<?=$data['email']?>" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('phone'); ?></td>
            <td class="td2"><input type="text" name="phone" value="<?=$data['phone']?>" required></td>
        </tr>
        <tr>
            <td class="label"><?= i18n::get('hometown'); ?></td>
            <td class="td2"><input type="text" name="hometown" value="edit" required></td>
        </tr>
    </table>

    <button style="padding: 5px 10px 7px 10px; border-radius: 5px; background-color: azure;" id="save"><?=i18n::get('ok');?></button>
    <button style="padding: 5px 10px 7px 10px; border-radius: 5px; background-color: azure;" id="cancel"><?=i18n::get('cancel');?></button>
</form>

<?php include "./view/footer.php"?>
</body>
</html>