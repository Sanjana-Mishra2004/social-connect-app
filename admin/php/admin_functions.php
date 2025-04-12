<?php
require_once($function_url ?? '../../assets/php/functions.php');


//for checking whether the user is admin or not 
function checkAdminUser($login_data)
{
    global $con;
    $email = $login_data['email'];
    $password = $login_data['password'];

    // Query to get the user by email
    $sql = "SELECT * FROM `admin_data` WHERE `email`='$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $data['user'] = mysqli_fetch_assoc($result)??array();

        // Verify the password
        if (password_verify($password, $data['user']['password'])) {
            // Password is correct
            $data['status'] = true;
            $data['user_id'] = $data['user']['admin_id'];
        } else {
            // Password is incorrect
            $data['status'] = false;
        }
    } else {
        // User not found
        $data['status'] = false;
    }
    return $data;
}




// fetching admin data
function getAdmin($user_id)
{
    global $con;
    $sql = "SELECT * FROM `admin_data` WHERE `admin_id` = '$user_id'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}


// get total comments count
function totalCommentsCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `comments`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}


// get total posts count
function totalPostsCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `post`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}


// get total users count
function totalUsersCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `user_data2`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}


// get total blocked users count
function totalBlockedCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `block_list`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

// get total notifications count
function totalNotifCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `notifications`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

// get total connections count
function totalConnectCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `connections`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

// get total chats group count
function totalChatGroupsCount()
{
    global $con;
    
    $sql = "SELECT COUNT(DISTINCT LEAST(from_user_id, to_user_id), GREATEST(from_user_id, to_user_id)) AS chat_groups 
            FROM messages";
    
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['chat_groups'];
    }
    
    return 0; // Return 0 if query fails
}



// get total likes count
function totalLikesCount()
{
    global $con;
    $sql = "SELECT count(*) as total FROM `likes`";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}


// get all users data
function getUsersList()
{
    global $con;
    $sql = "SELECT * FROM `user_data2` ORDER BY `id` DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// get all users data
function getUserById($id)
{
    global $con;
    $sql = "SELECT * FROM `user_data2` WHERE `id` = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}


// to login user by admin
// function loginUserByAdmin($email)
// {
//     global $con;
//     $sql = "SELECT * FROM `user_data2` WHERE `email`='$email'";
//     $result = mysqli_query($con, $sql);
//     $data['user'] = mysqli_fetch_assoc($result) ?? array();
//     if (count($data['user']) > 0) {
//         $data['status'] = true;
//     } else {
//         $data['status'] = false;
//     }

//     return $data;
// }


// to block user by admin
function blockUserByAdmin($user_id)
{
    global $con;
    $sql = "UPDATE `user_data2` SET `ac_status`=2 WHERE `id`=$user_id";
    return mysqli_query($con, $sql);
}


// to unblock user by admin
function unblockUserByAdmin($user_id)
{
    global $con;
    $sql = "UPDATE `user_data2` SET `ac_status`=1 WHERE `id`=$user_id";
    return mysqli_query($con, $sql);
}

// to update admin profile
function updateAdmin($data)
{
    global $con;
    $name = $data['name'];
    $email = $data['email'];
    $user_id = $data['user_id'];

    // Check if a new password is provided
    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE `admin_data` SET `name`='$name', `email`='$email', `password`='$password' WHERE `admin_id` = '$user_id'";
    } else {
        // If password is not provided, update without changing the password
        $sql = "UPDATE `admin_data` SET `name`='$name', `email`='$email' WHERE `admin_id` = '$user_id'";
    }

    return mysqli_query($con, $sql);
}

// for searching the user
function searchUser2($keyword)
{
    global $con;
    $sql = "SELECT * FROM `user_data2` WHERE `username` LIKE '%" . $keyword . "%' || (`fname` LIKE '%" . $keyword . "%' || `lname` LIKE '%" . $keyword . "%') LIMIT 10";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// for user wise post
function searchPost($user)
{
    global $con;
    $sql = "SELECT * FROM `post` WHERE `user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// for user wise followers
function searchFollowers($user)
{
    global $con;
    $sql = "SELECT * FROM `connections` WHERE `user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// for user wise followings
function searchFollowing($user)
{
    global $con;
    $sql = "SELECT * FROM `connections` WHERE `con_user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// for user wise comments
function searchComments($user)
{
    global $con;
    $sql = "SELECT * FROM `comments` WHERE `user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

// for user wise blocked users
function searchBlockedUsers($user)
{
    global $con;
    $sql = "SELECT * FROM `block_list` WHERE `user_id` = $user";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, true);
}

function getUsersByDateRange($type, $from, $to) {
    global $con;
    $query = "";

    if ($type == "New Users") {
        $query = "SELECT * FROM user_data2 WHERE created_at BETWEEN '$from' AND '$to' ORDER BY id DESC";
    } elseif ($type == "Active Users") {
        $query = "SELECT DISTINCT u.* FROM user_data2 u
                  INNER JOIN (
                      SELECT user_id FROM post WHERE created_at BETWEEN '$from' AND '$to'
                      UNION
                      SELECT user_id FROM comments WHERE created_at BETWEEN '$from' AND '$to'
                      UNION
                      SELECT from_user_id FROM messages WHERE created_at BETWEEN '$from' AND '$to'
                  ) AS active_users ON u.id = active_users.user_id
                  ORDER BY u.id DESC";
    } elseif ($type == "Inactive Users") {
        $query = "SELECT * FROM user_data2 u
                  WHERE u.id NOT IN (
                      SELECT user_id FROM post WHERE created_at BETWEEN '$from' AND '$to'
                      UNION
                      SELECT user_id FROM comments WHERE created_at BETWEEN '$from' AND '$to'
                      UNION
                      SELECT from_user_id FROM messages WHERE created_at BETWEEN '$from' AND '$to'
                  )
                  ORDER BY u.id DESC";
    }

    $result = mysqli_query($con, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function getUsersByYearMonth($type, $year, $month) {
    global $con;
    $month_number = date("m", strtotime("1-$month-$year")); // Convert month name to number
    $query = "";

    if ($type == "New Users") {
        $query = "SELECT * FROM user_data2 WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number' ORDER BY id DESC";
    } elseif ($type == "Active Users") {
        $query = "SELECT DISTINCT u.* FROM user_data2 u
                  INNER JOIN (
                      SELECT user_id FROM post WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                      UNION
                      SELECT user_id FROM comments WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                      UNION
                      SELECT from_user_id FROM messages WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                  ) AS active_users ON u.id = active_users.user_id
                  ORDER BY u.id DESC";
    } elseif ($type == "Inactive Users") {
        $query = "SELECT * FROM user_data2 u
                  WHERE u.id NOT IN (
                      SELECT user_id FROM post WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                      UNION
                      SELECT user_id FROM comments WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                      UNION
                      SELECT from_user_id FROM messages WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month_number'
                  )
                  ORDER BY u.id DESC";
    }

    $result = mysqli_query($con, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


// to dispaly users
function displayUsers($users) {
    if (empty($users)) {
        echo '<div class="card w-60 m-auto">
                <div class="card-body bg-danger">
                    <p class="card-text ">No users found for the selected criteria.</p>
                </div>
            </div>';
        return;
    }

    echo '<div class="card w-100">';
    echo '<div class="card-body">';
    echo '<table class="table table-bordered table-hover">';
    echo '<thead>';
    echo '<tr><th>#No</th><th>User Info</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $count = 1;
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>#{$count}</td>";
        echo "<td>
                <div class='d-flex'>
                    <div>
                        <img src='../assets/images/profile/{$user['profile_img']}' class='rounded-circle border border-2 shadow-sm mx-2' width='55px' height='55px' />
                    </div>
                    <div>
                        <h5>{$user['fname']} {$user['lname']} - <span class='text-muted'>@{$user['username']}</span></h5>
                        <h6 class='text-muted'>{$user['email']}</h6>
                    </div>
                </div>
              </td>";
        echo "</tr>";
        $count++;
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
}



