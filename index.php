<?php
require_once 'assets/php/functions.php';


if (isset($_GET['newfp'])) {
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgotpass_code']);
    unset($_SESSION['temp']);
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user = getUserdata($_SESSION['user_id']['id']);
    $posts = filterPosts();
    $follow_suggestions = filterSuggestions();
}

$pagecount = count($_GET);

// manage page display
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 1 && !$pagecount) {
    show_page('header', ['page_title' => 'Home']);
    show_page('navbar');
    show_page('home');
} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 0 && !$pagecount) {
    show_page('header', ['page_title' => 'Verify Your Email']);
    show_page('verify_email');
} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 2 && !$pagecount) {
    show_page('header', ['page_title' => 'Blocked']);
    show_page('blocked');
} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_GET['editprofile']) && $user['ac_status'] == 1) {
    show_page('header', ['page_title' => 'Edit Profile']);
    show_page('navbar');
    show_page('edit_profile');
} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_GET['user']) && $user['ac_status'] == 1) {
    $profile = getUser($_GET['user']);
    if (!$profile) {
        show_page('header', ['page_title' => 'no user found with this username']);
        show_page('navbar');
        show_page('user_notfound');
    }else{
        $user_post = userPost($profile['id']);
        $profile['followers'] = getFollowersCount($profile['id']);
        $profile['following'] = getFollowingCount($profile['id']);
        show_page('header', ['page_title' => $profile['fname'].' '. $profile['lname']]);
        show_page('navbar');
        show_page('profile');
    }
} elseif (isset($_GET['signup'])) {
    show_page('header', ['page_title' => 'SignUp']);
    show_page('signup');
} elseif (isset($_GET['login'])) {
    show_page('header', ['page_title' => 'Login']);
    show_page('login');
} elseif (isset($_GET['forgot_pass'])) {
    show_page('header', ['page_title' => 'Forgot_Password']);
    show_page('forgot_password');
} else {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 1) {
        show_page('header', ['page_title' => 'Home']);
        show_page('navbar');
        show_page('home');
    } elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 0) {
        show_page('header', ['page_title' => 'Verify Your Email']);
        show_page('verify_email');
    } elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $user['ac_status'] == 2) {
        show_page('header', ['page_title' => 'Blocked']);
        show_page('blocked');
    } else {
        show_page('header', ['page_title' => 'Login']);
        show_page('login');
    }
}




show_page('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);


