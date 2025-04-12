<?php
// ob_start();
require_once 'functions.php';
require_once 'send_code.php';

//to delete post 
if(isset($_GET['deletepost'])){
    $post_id = $_GET['deletepost'];
      if(deletePost($post_id)){
          header("location:{$_SERVER['HTTP_REFERER']}");
          exit(); // Always exit after a header redirect
      }else{
          echo "something went wrong";
      }
    }

// for user signup
if (isset($_GET['signup'])) {
    $response = validSignup($_POST);
    if ($response['status']) {

        if (createUser($_POST)) {
            header('location:../../?login&newuser');
        } else {
            echo "<script>alert('Please recheck your inputs')</script>";
        }
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?signup");
        exit(); // Always exit after a header redirect
    }
}


// for user login
if (isset($_GET['login'])) {
    
    $response = validLogin($_POST);
    if ($response['status']) {
        $_SESSION['loggedin'] = true;
        //    $_SESSION['user_id'] = $response['user']['uname_email'];
        $_SESSION['user_id'] = $response['user'];
        if ($response['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            sendCode($response['user']['email'], $code);
        }
        header("Location: ../../");
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("Location: ../../?login");
        exit(); // Always exit after a header redirect
    }
}

if (isset($_GET['resend_code'])) {
    $_SESSION['code'] = $code = rand(111111, 999999);
    sendCode($_SESSION['user_id']['email'], $code);
    header("Location: ../../?resended");
    exit(); // Always exit after a header redirect
}

if (isset($_GET['verify_email'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['code'];
    if ($code == $user_code) {
        if (verifyEmail($_SESSION['user_id']['email'])) {
            header("Location: ../../");
            exit(); // Always exit after a header redirect
        } else {
            echo "<p class='text-danger'>Something is wrong.Please Recheck!</p>";
        }
    } else {
        $response['msg'] = "Incorrect Verification Code!";
        if (!$_POST['code']) {
            $response['msg'] = "Please enter 6-digit verification code";
        }
        $response['field'] = "verify_email";
        $_SESSION['error'] = $response;
        header("Location: ../../");
        exit(); // Always exit after a header redirect
    }
}


if (isset($_GET['forgot_pass'])) {
    if (!$_POST['email']) {
        $response['msg'] = "Please enter your Email id";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header("Location: ../../?forgot_pass");
        exit();
    } elseif (!emailExist($_POST['email'])) {
        $response['msg'] = "Email is not registered";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header("Location: ../../?forgot_pass");
        exit();
    } else {
        $_SESSION['forgot_email'] = $_POST['email'];
        $_SESSION['forgotpass_code'] = $code = rand(111111, 999999);
        sendCode($_POST['email'], $code);
        header("Location: ../../?forgot_pass&sended");
        exit();
    }
}




// to verify forgot code
if (isset($_GET['verifyCode'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['forgotpass_code'];
    if ($code == $user_code) {
        $_SESSION['temp'] = true;
        header("Location: ../../?forgot_pass&verified");
        exit(); // Always exit after a header redirect

    } else {
        $response['msg'] = "Incorrect Verification Code!";
        if (!$_POST['code']) {
            $response['msg'] = "Please enter 6-digit verification code";
        }
        $response['field'] = "verify_code";
        $_SESSION['error'] = $response;
        header("Location: ../../?forgot_pass");
        exit(); // Always exit after a header redirect
    }
}

if (isset($_GET['change_pass'])) {
    if (!$_POST['chpassword']) {
        $response['msg'] = "Please enter your new password";
        $response['field'] = 'chpassword';
        $_SESSION['error'] = $response;
        header("Location: ../../?forgot_pass");
        exit();
    } else {
        resetPassword($_SESSION['forgot_email'], $_POST['chpassword']);
        // Clear session variables related to the password reset process
        unset($_SESSION['forgot_email']);
        unset($_SESSION['forgotpass_code']);
        unset($_SESSION['temp']);
        header("Location: ../../?resetdone");
        exit();
    }
}

if (isset($_GET['updateprofile'])) {
    // $_SESSION['user_id']['profile_img'] = !empty($user_data['profile_img']) ? $user_data['profile_img'] : 'defaultprofile.jpg';
    $response = validUpdateform($_POST, $_FILES['profile_img']);
    if ($response['status']) {
        if (updateProfile($_POST, $_FILES['profile_img'])) {
            header("Location: ../../?editprofile&success");
            exit();
        } else {
            echo "Something is wrong. Please check!";
        }
    } else {
        $_SESSION['error'] = $response;
        header("Location: ../../?editprofile");
        exit();
    }
}

// for managing post
if (isset($_GET['addpost'])) {
    $response = validatePost($_FILES['post_img']);

    if ($response['status']) {
        if (addPost($_POST, $_FILES['post_img'])) {
            header("Location: ../../?postadded&success");
            exit();
        } else {
            echo "Something is wrong. Please check!";
        }
    } else {
        $_SESSION['error'] = $response;
        header("Location: ../../");
        exit();
    }
}

// to block user
if (isset($_GET['block'])) {
    $user_id = $_GET['block'];
    $user = $_GET['username'];
    if (blockUser($user_id)) {
        header("location:../../?user=$user");
    } else {
        echo "something went wrong";
    }
    
}


// for logout
{
    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: ../../");
        exit();
    }
}
