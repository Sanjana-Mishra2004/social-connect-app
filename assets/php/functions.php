<?php
require_once 'config.php';

//function for showing pages
function show_page($page, $data = "")
{
    include("assets/pages/$page.php");
}

function gettime($date)
{
    return date('H:i (M jS, y)', strtotime($date));
}

function show_time($time)
{
    return '<time style="font-size:small" class="timeago text-muted text-small" datetime="' . $time . '"></time>';
}

//function to show error
function show_error($field)
{
    if (isset($_SESSION['error']['field']) && $_SESSION['error']['field'] === $field) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['error']['msg']) . '</div>';
    }
}


// function for storing form data
function show_formdata($field)
{
    if (isset($_SESSION['formdata'][$field])) {
        return  htmlspecialchars($_SESSION['formdata'][$field]);
    }
    return ''; // Return empty string if the form data isn't available
}

// for checking duplicate email
function emailExist($email)
{
    global $con;
    $sql = "SELECT count(*) FROM `user_data2` WHERE `email`='$email'";
    $result = mysqli_query($con, $sql);
    $return_data = mysqli_fetch_assoc($result);

    if ($result) {
        // $return_data = $result->fetch_assoc();
        return $return_data['count(*)'];
    } else {
        // Handle query failure
        return false;
    }
}

// for checking duplicate username
function unameExist($uname)
{
    global $con;
    $sql = "SELECT count(*) FROM `user_data2` WHERE `username`='$uname'";
    $result = mysqli_query($con, $sql);
    $return_data = mysqli_fetch_assoc($result);

    if ($result) {
        // $return_data = $result->fetch_assoc();
        return $return_data['count(*)'];
    } else {
        // Handle query failure
        return false;
    }
}

// for checking duplicate new username
function newUnameExist($uname)
{
    global $con;
    $uid = $_SESSION['user_id']['id'];
    $sql = "SELECT count(*) FROM `user_data2` WHERE `username`='$uname' && id!=$uid";
    $result = mysqli_query($con, $sql);
    $return_data = mysqli_fetch_assoc($result);

    if ($result) {
        // $return_data = $result->fetch_assoc();
        return $return_data['count(*)'];
    } else {
        // Handle query failure
        return false;
    }
}


//validation of signup form
function validSignup($form_data)
{
    $response = array('status' => true);

    if (!isset($form_data['pwd']) || empty($form_data['pwd'])) {
        $response['msg'] = "Password is required";
        $response['status'] = false;
        $response['field'] = 'pwd';
    }
    if (!isset($form_data['uname']) || empty($form_data['uname'])) {
        $response['msg'] = "Username is required";
        $response['status'] = false;
        $response['field'] = 'uname';
    }
    if (!isset($form_data['email']) || empty($form_data['email'])) {
        $response['msg'] = "Email is required";
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (!isset($form_data['lname']) || empty($form_data['lname'])) {
        $response['msg'] = "Last name is required";
        $response['status'] = false;
        $response['field'] = 'lname';
    }
    if (!isset($form_data['fname']) || empty($form_data['fname'])) {
        $response['msg'] = "First name is required";
        $response['status'] = false;
        $response['field'] = 'fname';
    }
    if (emailExist($form_data['email'])) {
        $response['msg'] = "Email already exist";
        $response['status'] = false;
        $response['field'] = 'email';
    }
    if (unameExist($form_data['uname'])) {
        $response['msg'] = "Username already exist";
        $response['status'] = false;
        $response['field'] = 'uname';
    }


    return $response;
}

//validation of login form
function validLogin($form_data)
{
    $response = array('status' => true);
    $blank = false;

    if (!isset($form_data['password']) || empty($form_data['password'])) {
        $response['msg'] = "Password is required";
        $response['status'] = false;
        $response['field'] = 'password';
        $blank = true;
    }
    if (!isset($form_data['uname_email']) || empty($form_data['uname_email'])) {
        $response['msg'] = "Username/Email is required";
        $response['status'] = false;
        $response['field'] = 'uname_email';
        $blank = true;
    }

    if (!$blank && !checkUser($form_data)['status']) {
        $response['msg'] = "User not Found!";
        $response['status'] = false;
        $response['field'] = 'checkuser';
    } else {
        $response['user'] = checkUser($form_data)['user'];
    }


    return $response;
}


// for checking user in database
function checkUser($login_data)
{
    global $con;
    $uname_email = $login_data['uname_email'];
    $password = md5($login_data['password']);
    $sql = "SELECT * FROM `user_data2` WHERE (`email`='$uname_email' || `username`='$uname_email')";
    $sql .= "&& `password`='$password'";
    $result = mysqli_query($con, $sql);
    $return_data['user'] = mysqli_fetch_assoc($result) ?? array();
    if (count($return_data['user']) > 0) {
        $return_data['status'] = true;
    } else {
        $return_data['status'] = false;
        $return_data['msg'] = 'Invalid username/email or password';
    }

    return $return_data;
}

// for fetching userdata using ID
function getUserdata($user_id)
{
    global $con;

    $sql = "SELECT * FROM `user_data2` WHERE `id` = $user_id";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_assoc($result);
}

// for creating/adding users
function createUser($data)
{
    global $con;
    $fname = mysqli_real_escape_string($con, $data['fname']);
    $lname = mysqli_real_escape_string($con, $data['lname']);
    $gender = $data['gender'];
    $email = mysqli_real_escape_string($con, $data['email']);
    $uname = mysqli_real_escape_string($con, $data['uname']);
    $pwd = mysqli_real_escape_string($con, $data['pwd']);
    $pwd = md5($pwd);
    $sql = "INSERT INTO `user_data2`(`fname`, `lname`, `gender`, `email`, `username`, `password`)";
    $sql .= "VALUES ('$fname','$lname','$gender','$email','$uname','$pwd')";

    return mysqli_query($con, $sql);
}

// function to verify email
function verifyEmail($email)
{
    global $con;
    $sql = "UPDATE `user_data2` SET `ac_status`='1' WHERE `email`='$email'";
    return mysqli_query($con, $sql);
}

//  function to reset password
function resetPassword($email, $newpassword)
{
    global $con;
    $newpassword = md5($newpassword);
    $sql = "UPDATE `user_data2` SET `password`='$newpassword' WHERE `email`='$email'";
    return mysqli_query($con, $sql);
}

// Validating edit_profile form
function validUpdateform($form_data, $image_data)
{
    $response = array('status' => true);


    if (!isset($form_data['uname']) || empty($form_data['uname'])) {
        $response['msg'] = "Username is not given";
        $response['status'] = false;
        $response['field'] = 'uname';
    }

    if (!isset($form_data['lname']) || empty($form_data['lname'])) {
        $response['msg'] = "Last name is  not given";
        $response['status'] = false;
        $response['field'] = 'lname';
    }
    if (!isset($form_data['fname']) || empty($form_data['fname'])) {
        $response['msg'] = "First name is  not given";
        $response['status'] = false;
        $response['field'] = 'fname';
    }

    if (!isset($form_data['uname']) || newUnameExist($form_data['uname'])) {
        $response['msg'] = $form_data['uname'] . " is already registered";
        $response['status'] = false;
        $response['field'] = 'uname';
    }

    if (!isset($image_data['name']) || $image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['msg'] = "Only jpg,jpeg,png type are allowed";
            $response['status'] = false;
            $response['field'] = 'profile';
        }
        if (!isset($image_data['size']) || $size > 1000) {
            $response['msg'] = "Image size should be 1 MB or less";
            $response['status'] = false;
            $response['field'] = 'profile';
        }
    }

    return $response;
}

// to update user profile
function updateProfile($form_data, $image_data)
{
    global $con;

    $fname = mysqli_real_escape_string($con, $form_data['fname']);
    $lname = mysqli_real_escape_string($con, $form_data['lname']);
    $uname = mysqli_real_escape_string($con, $form_data['uname']);

    // If password field is empty, use the existing password
    if (!$form_data['password']) {
        $password = $_SESSION['user_id']['password'];
    } else {
        $password = md5(mysqli_real_escape_string($con, $form_data['password']));
        $_SESSION['user_id']['password'] = $password;
    }

    $profile_img_sql = ''; // Empty by default

    // Check if image is uploaded
    if (isset($image_data['name']) && $image_data['name']) {
        $image_name = time() . basename($image_data['name']);
        $image_dir = "../images/profile/$image_name";

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($image_data['tmp_name'], $image_dir)) {
            $profile_img_sql = ", profile_img='$image_name'";
            $_SESSION['user_id']['profile_img'] = $image_name; // Update session if image is changed
        }
    }

    // Update query: Only include profile_img if there's a new image
    $sql = "UPDATE `user_data2` 
            SET `fname`='$fname',
                `lname`='$lname',
                `username`='$uname',
                `password`='$password'
                $profile_img_sql 
            WHERE `id` = " . $_SESSION['user_id']['id'];

    return mysqli_query($con, $sql);
}

// for validating post
function validatePost($image_data)
{
    $response = array('status' => true);


    if (!isset($image_data['name']) || empty($image_data['name'])) {
        $response['msg'] = "Image is not selected";
        $response['status'] = false;
        $response['field'] = 'post_img';
    }

    if (!isset($image_data['name']) || $image_data['name']) {
        $image = basename($image_data['name']);
        $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $size = $image_data['size'] / 1000;

        if ($type != 'jpg' && $type != 'jpeg' && $type != 'png') {
            $response['msg'] = "Only jpg,jpeg,png type are allowed";
            $response['status'] = false;
            $response['field'] = 'post_img';
        }
        if (!isset($image_data['size']) || $size > 3000) {
            $response['msg'] = "Image size should be 3 MB or less";
            $response['status'] = false;
            $response['field'] = 'post_img';
        }
    }

    return $response;
}

//  for creating/adding post
function addPost($text, $image)
{
    global $con;
    $post_text = mysqli_real_escape_string($con, $text['post_text']);
    $user_id = $_SESSION['user_id']['id'];

    // if (isset($image['name']) && $image['name']) {
    $image_name = time() . basename($image['name']);
    $image_dir = "../images/posts/$image_name";

    move_uploaded_file($image['tmp_name'], $image_dir);

    // }

    $sql = "INSERT INTO `post`(`user_id`, `post_text`, `post_img`) VALUES ('$user_id','$post_text','$image_name')";
    return mysqli_query($con, $sql);
}

// for displaying post
function getPost()
{
    global $con;

    $sql = "SELECT user_data2.id as uid, post.post_id,post.user_id, post.post_text, post.post_img, post.created_at, user_data2.fname, user_data2.lname, user_data2.username, user_data2.profile_img FROM post JOIN user_data2 ON post.user_id = user_data2.id ORDER BY post_id DESC";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_all($result, true);
}

// for fetching userdata by username
function getUser($username)
{
    global $con;

    $sql = "SELECT * FROM `user_data2` WHERE `username` = '$username'";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_assoc($result);
}

// for fetching user's post by userid
function userPost($user_id)
{
    global $con;

    $sql = "SELECT * FROM `post` WHERE `user_id`=$user_id  ORDER BY post_id DESC";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_all($result, true);
}


// for checking followed users
function checkFollowStatus($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT 1 FROM `connections` WHERE `user_id`='$user_id' AND `con_user_id`='$loggedin_user' LIMIT 1";
    $result = mysqli_query($con, $sql);

    // Return true if a row exists, meaning the logged-in user already follows this user
    if ($result && mysqli_num_rows($result) > 0) {
        return true; // Already followed
    } else {
        return false; // Not followed
    }
}

function checkFollowStatus2($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT 1 FROM `connections` WHERE `user_id`='$loggedin_user' AND `con_user_id`='$user_id' LIMIT 1";
    $result = mysqli_query($con, $sql);

    // Return true if a row exists, meaning the logged-in user already follows this user
    if ($result && mysqli_num_rows($result) > 0) {
        return true; // Already followed
    } else {
        return false; // Not followed
    }
}

// for fetching follow suggestions
function getFollowSuggestions()
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT * FROM `user_data2` WHERE `id`!=$loggedin_user";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_all($result, true);
}

// to filter follow suggestions
function filterSuggestions()
{
    $list = getFollowSuggestions();
    $filter_list = array();
    foreach ($list as $user) {
        if (!checkFollowStatus($user['id']) && count($filter_list) < 5 && !checkBS($user['id'])) {
            $filter_list[] = $user;
        }
    }
    return $filter_list;
}

// to follow users
function followUser($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "INSERT INTO `connections`( `user_id`, `con_user_id`) VALUES ('$user_id','$loggedin_user')";

    createNotification($loggedin_user, $user_id, "started following you!");
    return mysqli_query($con, $sql);
}

// for displaying post dynamically
function filterPosts()
{
    $list = getPost();
    $filter_list = array();
    foreach ($list as $post) {
        if (checkFollowStatus($post['user_id']) || $post['user_id'] == $_SESSION['user_id']['id']) {
            $filter_list[] = $post;
        }
    }
    return $filter_list;
}

// get followers count
function getFollowersCount($user_id)
{
    global $con;
    $sql = "SELECT * FROM `connections` WHERE `user_id`=$user_id";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_all($result, true);
}

// get following count
function getFollowingCount($user_id)
{
    global $con;
    $sql = "SELECT * FROM `connections` WHERE `con_user_id`=$user_id";
    $result = mysqli_query($con, $sql);
    return  mysqli_fetch_all($result, true);
}

// function to unfollow users
function unfollowUser($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "DELETE FROM `connections` WHERE `con_user_id` = $loggedin_user && `user_id` = $user_id";

    createNotification($loggedin_user, $user_id, "unfollowed you!");
    return mysqli_query($con, $sql);
}

// for getting poster id
function getPosterId($post_id)
{
    global $con;
    $sql = "SELECT `user_id` FROM `post` WHERE `post_id` = $post_id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['user_id'];
}

// to like posts
function likePost($post_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "INSERT INTO `likes`(`post_id`, `user_id`) VALUES ('$post_id','$loggedin_user')";

    $poster_id = getPosterId($post_id);
    if ($poster_id != $loggedin_user) {
        createNotification($loggedin_user, $poster_id, "liked your post!", $post_id);
    }
    return mysqli_query($con, $sql);
}



// to unlike posts
function unlikePost($post_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "DELETE FROM `likes` WHERE `post_id`='$post_id' && `user_id`='$loggedin_user'";

    $poster_id = getPosterId($post_id);
    if ($poster_id != $loggedin_user) {
        createNotification($loggedin_user, $poster_id, "unliked your post!", $post_id);
    }
    return mysqli_query($con, $sql);
}


// for checking like status
function checkLikeStatus($post_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT 1 FROM `likes` WHERE `user_id`='$loggedin_user' AND `post_id`='$post_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// function to count likes
function countLikes($post_id)
{
    global $con;
    $sql = "SELECT * FROM `likes` WHERE `post_id`='$post_id'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// to add comment
function addComment($post_id, $comment)
{
    global $con;
    $comment = mysqli_real_escape_string($con, $comment);
    // $cu = getUserdata($_SESSION['user_id']['id']);
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "INSERT INTO `comments`(`post_id`, `user_id`, `content`) VALUES ('$post_id','$loggedin_user','$comment')";

    $poster_id = getPosterId($post_id);
    if ($poster_id != $loggedin_user) {
        createNotification($loggedin_user, $poster_id, "commented on your post!", $post_id);
    }
    return mysqli_query($con, $sql);
}

// to get comment
function getComments($post_id)
{
    global $con;
    $sql = "SELECT * FROM `comments` WHERE `post_id`='$post_id' ORDER BY comment_id DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}


// for searching the user
function searchUser($keyword)
{
    global $con;
    $sql = "SELECT * FROM `user_data2` WHERE `username` LIKE '%" . $keyword . "%' || (`fname` LIKE '%" . $keyword . "%' || `lname` LIKE '%" . $keyword . "%') LIMIT 10";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// to delete the post
function deletePost($post_id)
{
    global $con;
    $user_id = $_SESSION['user_id']['id'];
    $deletelike = "DELETE FROM `likes` WHERE `post_id`='$post_id' && `user_id`='$user_id'";
    mysqli_query($con, $deletelike);
    $delcom = "DELETE FROM `comments` WHERE `post_id`='$post_id' && `user_id`='$user_id'";
    mysqli_query($con, $delcom);

    $notif = "UPDATE `notifications` SET `read_status`=2 WHERE `post_id` = $post_id && `to_user_id` = $user_id";
    mysqli_query($con, $notif);

    $sql = "DELETE FROM `post` WHERE `post_id` = '$post_id'";
    return mysqli_query($con, $sql);
}

// for blocking the user
function blockUser($blocked_user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "INSERT INTO `block_list`(`user_id`, `blocked_user_id`) VALUES ('$loggedin_user','$blocked_user_id')";

    createNotification($loggedin_user, $blocked_user_id, "blocked you!");
    $sql2 = "DELETE FROM `connections` WHERE `user_id` = $loggedin_user && `con_user_id` = $blocked_user_id";
    mysqli_query($con, $sql2);
    $sql3 = "DELETE FROM `connections` WHERE `con_user_id` = $loggedin_user && `user_id` = $blocked_user_id";
    mysqli_query($con, $sql3);

    return mysqli_query($con, $sql);
}

// for unblocking the user
function unblockUser($blocked_user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "DELETE FROM `block_list` WHERE `user_id` = $loggedin_user && `blocked_user_id` = $blocked_user_id";

    createNotification($loggedin_user, $blocked_user_id, "unblocked you!");
    return mysqli_query($con, $sql);
}

// for checking the user is blocked by current user or not
function checkBlockStatus($current_user, $user)
{
    global $con;
    $sql = "SELECT count(*) FROM `block_list` WHERE `user_id` = $current_user && `blocked_user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['count(*)'];
}

// for checking if any of current user or user is blocked by other
function checkBS($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT count(*) FROM `block_list` WHERE (`user_id` = $loggedin_user && `blocked_user_id` = $user_id) || (`user_id` = $user_id && `blocked_user_id` = $loggedin_user)";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['count(*)'];
}

// for creating notification
function createNotification($from_user_id, $to_user_id, $msg, $post_id = 0)
{
    global $con;
    $sql = "INSERT INTO `notifications`(`from_user_id`, `to_user_id`, `message`, `post_id`) VALUES ($from_user_id, $to_user_id, '$msg', $post_id)";
    mysqli_query($con, $sql);
}

// to get notifications
function getNotifications()
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT * FROM `notifications` WHERE `to_user_id`= '$loggedin_user' ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}


// to get unread notification count
function getUnreadNotifCount()
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT count(*) FROM `notifications` WHERE `to_user_id`= '$loggedin_user' && `read_status` = 0 ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['count(*)'];
}


// to set notification status as read
function setNotifStatusAsRead()
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "UPDATE `notifications` SET `read_status`= 1 WHERE `to_user_id` = '$loggedin_user' and `read_status` != 2";
    return mysqli_query($con, $sql);
}

// for getting ids of chat users
function getActiveCuserId()
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT `from_user_id`, `to_user_id` FROM `messages` WHERE (`from_user_id` = $loggedin_user || `to_user_id` = $loggedin_user) ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_all($result, true);

    $ids = array();
    foreach ($data as $chat) {
        if ($chat['from_user_id'] != $loggedin_user and !in_array($chat['from_user_id'], $ids)) {
            $ids[] = $chat['from_user_id'];
        }
        if ($chat['to_user_id'] != $loggedin_user and !in_array($chat['to_user_id'], $ids)) {
            $ids[] = $chat['to_user_id'];
        }
    }

    return $ids;
}


// for sending message
function sendMessage($user_id, $msg)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "INSERT INTO `messages`(`from_user_id`, `to_user_id`, `msg` ) VALUES ($loggedin_user,$user_id,'$msg')";
    // updateReadstatus($user_id);
    return mysqli_query($con, $sql);
}

// for getting messages
function getMessages($user_id)
{
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT * FROM `messages` WHERE (`from_user_id` = $loggedin_user and `to_user_id` = $user_id) || (`to_user_id` = $loggedin_user and `from_user_id` = $user_id) ORDER BY id DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// to get list of messages
function getAllMessages()
{
    $active_chat_ids = getActiveCuserId();
    $messages = array();
    foreach ($active_chat_ids as $index => $id) {
        $messages[$index]['user_id'] = $id;
        $messages[$index]['message'] = getMessages($id);
    }
    return $messages;
}

function newMessageCount(){
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "SELECT count(*) FROM `messages` WHERE `to_user_id` = '$loggedin_user' AND `read_status` = 0";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['count(*)'] ?? 0;

}

function updateReadstatus($user_id){
    global $con;
    $loggedin_user = $_SESSION['user_id']['id'];
    $sql = "UPDATE `messages` SET `read_status`= 1 WHERE `to_user_id` = '$loggedin_user' and `from_user_id` = $user_id";
    return mysqli_query($con, $sql);
}
