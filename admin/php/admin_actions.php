<?php
require_once('admin_functions.php');
require_once '../../assets/php/send_code.php';

// for admin login
if (isset($_GET['login'])) {
    $result = checkAdminUser($_POST); 
    if ($result['status']) {
        $_SESSION['admin_auth'] = $result['user_id'];
        header('Location:../');
        exit();
    } else {
        $_SESSION['error']=[
        "field" => "useraccess",
        "msg" => "Invalid email or password",
        ];
        header('Location:../');
        // var_dump($_SESSION['error']); exit;
        exit();
    }
}

// for logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../');
    exit();
}

// to update admin profile
if (isset($_GET['updateprofile'])) {
    if (updateAdmin($_POST)) {
        $_SESSION['error'] = [
            "field" => "adminprofile",
            "msg" => "profile updated successfully!",
        ];
        header('Location:../?edit_profile');
    } else {
        $_SESSION['error'] = [
            "field" => "adminprofile",
            "msg" => "something went wrong, please check",
        ];
        header('Location:../?edit_profile');
    }
}

// if (isset($_GET['userlogin']) && isset($_SESSION['admin_auth'])) {

//     $response = loginUserByAdmin($_GET['userlogin']);

//     if ($response['status']) {
//         $_SESSION['temp'] = true;
//         $_SESSION['user_id'] = $response['user'];

//         if ($response['user']['ac_status'] == 0) {
//             $_SESSION['code'] = $code = rand(111111, 999999);
//             sendCode($response['user']['email'],$code);
//         }

//         header("location:../../");
//     }
// }
