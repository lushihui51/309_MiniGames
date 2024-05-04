<?php

function checkUserName($dbconn, $user_name) {
    $un_errors = [];
    $un_highlight = [];
    if ($user_name=='') {
        $un_errors[] = "User Name should not be empty.";
        $un_highlight[] = 'user_name';
        return [$un_errors, $un_highlight];
    }
    if (!ctype_alnum($user_name)) {
        $un_errors[] = "User Name should only contain letters and numbers.";
        $un_highlight[] = 'user_name';
    }
    $result = pg_prepare($dbconn, "user_name_check", 'SELECT userid FROM appuser WHERE userid = $1');
    $result = pg_execute($dbconn, "user_name_check", [$user_name]);
    if ($row = pg_fetch_assoc($result)) {
        $un_errors[] = "User Name taken.";
        $un_highlight[] = 'user_name';
    }
    return [$un_errors, $un_highlight];
}

function checkUserNameProfile($dbconn, $user_name) {
    $un_errors = [];
    $un_highlight = [];
    if ($user_name=='') {
        $un_errors[] = "User Name should not be empty.";
        $un_highlight[] = 'user_name';
        return [$un_errors, $un_highlight];
    }
    if (!ctype_alnum($user_name)) {
        $un_errors[] = "User Name should only contain letters and numbers.";
        $un_highlight[] = 'user_name';
    }
    return [$un_errors, $un_highlight];
}

function checkPasswords($set_password, $confirm_password) {
    $pass_errors = [];
    $pass_highlight = [];
    if ($set_password == '') {
        $pass_errors[] = "Please set password.";
        $pass_highlight[] = 'set_password';
        return [$pass_errors, $pass_highlight];
    }
    if ($confirm_password == '') {
        $pass_errors[] = "Please confirm password.";
        $pass_highlight[] = 'confirm_password';
        return [$pass_errors, $pass_highlight];
    }
    if (!ctype_alnum($set_password)) {
        $pass_errors[] = "Password should only contain letters and numbers.";
        $pass_highlight[] = 'set_password';
    }
    if ($set_password != $confirm_password) {
        $pass_errors[] = "Passwords do not match.";
        $pass_highlight[] = 'confirm_password';
    }
    return [$pass_errors, $pass_highlight];
}

function checkEmail($email) {
    $email_errors = [];
    $email_highlight = [];
    if ($email == '') {
        return [$email_errors, $email_highlight];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_errors[] = "Please enter a valid email.";
        $email_highlight[] = 'email';
    } 
    return [$email_errors, $email_highlight];
}

function checkRegister($dbconn, $user_name, $set_password, $confirm_password, $email) {
    $un = checkUserName($dbconn, $user_name);
    $pass = checkPasswords($set_password, $confirm_password);
    $email = checkEmail($email);

    $errors = array_merge($un[0], $pass[0], $email[0]);
    $highlight = array_merge($un[1], $pass[1], $email[1]);

    return [$errors, $highlight];
}

function checkRegisterProfile($dbconn, $user_name, $set_password, $confirm_password, $email) {
    $un = checkUserNameProfile($dbconn, $user_name);
    $pass = checkPasswords($set_password, $confirm_password);
    $email = checkEmail($email);

    $errors = array_merge($un[0], $pass[0], $email[0]);
    $highlight = array_merge($un[1], $pass[1], $email[1]);

    return [$errors, $highlight];
}
?>