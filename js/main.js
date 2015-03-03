var leng = "en";

function setLeng(newLeng)
{
       leng = newLeng;
}

function compare_valid(field, field2) {
    var fiend_value = document.getElementById(field).value;
    var  fiend2_value = document.getElementById(field2).value;

    if(fiend_value.length > 0){
        if (fiend_value == fiend2_value) {
            updateClass(field2, 2);
            result = 1;
        } else {
            updateClass(field2, 1);
            result = 0;
        }
    }
    return result;
}

function check_v_mail(field) {
    var fiend_value = document.getElementById(field).value;
    var is_valid = 0;
    if(fiend_value.length > 0) {
        if (fiend_value.indexOf('@') >= 1) {
            var m_valid_dom = fiend_value.substr(fiend_value.indexOf('@')+1);
            if (m_valid_dom.indexOf('@') == -1) {
                if (m_valid_dom.indexOf('.') >= 1) {
                    var  m_valid_dom_e = m_valid_dom.substr(m_valid_dom.indexOf('.')+1);
                    if (m_valid_dom_e.length >= 1) {
                        is_valid = 1;
                    }
                }
            }
        }
        if (is_valid) {
            updateClass(field, 2);
            result = 1;
        } else {
            updateClass(field, 1);
            result = 0;
        }
    }
    return result;
}

function valid_length(field) {
    var length_df = document.getElementById(field).value.length;
    if (length_df >= 3 && length_df <= document.getElementById(field).maxLength) {
        updateClass(field, 2);
        result = 1;
    } else {
        updateClass(field, 1);
        result = 0;
    }
    return result;

}function valid_length_pass(field) {
    var length_df = document.getElementById(field).value.length;
    if (length_df >= 6 && length_df <= document.getElementById(field).maxLength) {
        updateClass(field, 2);
        result = 1;
    } else {
        updateClass(field, 1);
        result = 0;
    }
    return result;
}

function updateClass(field, class_index) {
    if (class_index == 1) {
        classAdd = 'wrong';
    } else if (class_index == 2) {
        classAdd = 'correct';
    }
    document.getElementById(field).className = classAdd;
    return 1;
}

function valid_date(fieldDay, fieldMonth, fieldYear)
{
    var day = document.getElementById(fieldDay).value;
    var month = document.getElementById(fieldMonth).value;
    var year = document.getElementById(fieldYear).value;

    if (day != 'na' && month != 'na' && year != 'na') {
        result = 1;
    } else {
        result = 0;
    }
    return result;
}

function validateAll(output)
{
    var valStep1 = valid_length('login');
    var valStep2 = valid_length_pass('pass');
    var valStep3 = compare_valid('pass', 'c_password');
    var valStep4 = check_v_mail('email');
    var valStep5 = valid_date('day', 'month', 'year');

    errorlist = '';
    if (! valStep1)
    {
        errorlist += (leng == "en") ? "Login is too short/long<br />" : "Логин слишком длинный/короткий<br />";
    }
    if (! valStep2)
    {
        errorlist += (leng == "en") ? "Password is too short/long<br />" : "Пароль слишком длинный/короткий<br />";
    }
    if (! valStep3)
    {
        errorlist += (leng == "en") ? "Passwords are not the same<br />" : "Пароли не соответствуют<br />";
    }
    if (! valStep4)
    {
        errorlist += (leng == "en") ? "Mail is wrong<br />" :"Ошибка с 'полем Email'<br />";
    }
    if (! valStep5)
    {
        errorlist += (leng == "en") ? "Birthday is wrong<br />" :"Ошибка с полем 'День рождения'<br />";
    }

    if (errorlist)
    {
        document.getElementById(output).innerHTML = errorlist;
        $('#' + output).css('display', 'block');
        return false;
    }
    return true;
}