<?php
require_once 'functions.php';



if (isset($_GET['follow'])) {
    $user_id = $_POST['user_id'];
    if (followUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


if (isset($_GET['unfollow'])) {
    $user_id = $_POST['user_id'];
    if (unfollowUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


if (isset($_GET['like'])) {
    $post_id = $_POST['post_id'];

    if (!checkLikeStatus($post_id)) {
        if (likePost($post_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
    }

    echo json_encode($response);
}


if (isset($_GET['unlike'])) {
    $post_id = $_POST['post_id'];

    if (checkLikeStatus($post_id)) {
        if (unlikePost($post_id)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
    }

    echo json_encode($response);
}


if (isset($_GET['addcomment'])) {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];

    if (addComment($post_id, $comment)) {
        $cuser = getUserdata($_SESSION['user_id']['id']);
        $time = date("Y-m-d H:i:s");
        $response['status'] = true;
        $response['comment'] = '<div class="d-flex align-items-center p-2">
                                        <div><img src="assets/images/profile/' . $cuser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border">
                                        </div>
                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                        <div class="d-flex flex-column justify-content-start align-items-start">
                                            <h6 style="margin: 0px;"><a href="?user=' . $cuser['username'] . '" class="text-decoration-none text-dark">@' . $cuser['username'] . '</a></h6>
                                            <p style="margin:0px;" class="text-muted">' . $_POST['comment'] . '</p>
                                             <p style="margin:0px;" class="text-muted" style="font-size:small">(just now)</p>
                                        </div>
                                    </div>';
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


if (isset($_GET['search'])) {
    $keyword = $_POST['keyword'];
    $data = searchUser($keyword);
    $users = "";
    if (count($data) > 0) {
        $response['status'] = true;
        foreach ($data as $suser) {
            $fbtn = '';
            $users .= '<div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center p-2">
                                <div><img src="assets/images/profile/' . $suser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border"></div>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="?user=' . $suser['username'] . '" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;">' . $suser['fname'] . ' ' . $suser['lname'] . '</h6></a>
                                    <p style="margin:0px;font-size:small" class="text-muted">@' . $suser['username'] . '</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">' . $fbtn . '</div>
                        </div>';
        }
        $response['users'] = $users;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}


if (isset($_GET['unblock'])) {
    $user_id = $_POST['user_id'];
    if (unblockUser($user_id)) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


if (isset($_GET['notread'])) {
    if (setNotifStatusAsRead()) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


// to update read status of message
if (isset($_GET['updateReadStatus'])) {

    if (updateReadstatus($_POST['user_id'])) {
        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    echo json_encode($response);
}


// to send chats
if (isset($_GET['sendMessage'])) {
    if (sendMessage($_POST['user_id'], $_POST['msg'])) {
        $response['status'] = true;
    } else {
        $response['status'] = true;
    }

    echo json_encode($response);
}


// for chat list
if (isset($_GET['getMessage'])) {
    $chats = getAllMessages();
    $chatlist = '';
    foreach ($chats as $chat) {
        $ch_user = getUserdata($chat['user_id']);

        $seen = false;
        if ($chat['message'][0]['read_status'] == 1 || $chat['message'][0]['from_user_id'] == $_SESSION['user_id']['id']) {
            $seen = true;
        }
        $chatlist .= '<div class="d-flex justify-content-between border-bottom chatlist_item" data-bs-toggle="modal" data-bs-target="#chatbox" onclick="popchat(' . $ch_user['id'] . ')">
                        <div class="d-flex align-items-center p-2">
                        <div><img src="assets/images/profile/' . $ch_user['profile_img'] . ' " alt="" height="40" width="40" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-center">
                            <a href="?user=' . $ch_user['username'] . '" class="text-decoration-none text-dark">
                                <h6 style="margin: 0px;font-size: small;">' . $ch_user['fname'] . ' ' . $ch_user['lname'] . '</h6>
                            </a>
                            <p style="margin: 0px;font-size:small" class="' . ($chat['message'][0]['read_status'] ? 'text-muted' : '') . '">@' . $ch_user['username'] . ' - ' . $chat['message'][0]['msg'] . '</p>
                            <time style="font-size:small;" class="timeago ' . ($chat['message'][0]['read_status'] ? 'text-muted' : '') . ' text-small" datetime="' . $chat['message'][0]['created_at'] . '">' . gettime($chat['message'][0]['created_at']) . '</time>
                        </div>
                        </div>
           
                        <div class="d-flex align-items-center">
                            <div class="p-1 bg-primary rounded-circle ' . ($seen ? 'd-none' : '') . '"></div>
                        </div>
                    </div>';
    }

    $response['chatlist'] = $chatlist;

    $chat_msg = null;
    if (isset($_POST['chatter_id']) && $_POST['chatter_id'] != 0) {

        $chatter_id = $_POST['chatter_id'];

        if (checkBS($chatter_id)) {
            $response['blocked'] = true;
        } else if (!checkFollowStatus($chatter_id) || !checkFollowStatus2($chatter_id)) {
            $response['blocked'] = true;
        } else {
            $response['blocked'] = false;
        }
        updateReadstatus($chatter_id);
        $chat_msg = getMessages($chatter_id);

        $chatmsg = "";
        foreach ($chat_msg as $cm) {
            if ($cm['from_user_id'] == $_SESSION['user_id']['id']) {
                $cl1 = 'bg-primary text-light align-self-end';
                $cl2 = 'text-light';
            } else {
                $cl1 = '';
                $cl2 = 'text-muted';
            }

            $chatmsg .= '<div class="py-2 px-3 border rounded shadow-sm col-8 ' . $cl1 . '">' . $cm['msg'] . ' <br>
                            <span style="font-size: small;" class="' . $cl2 . '">' . gettime($cm['created_at']) . '</span>
                        </div>';
        }
        $response['chat']['msgs'] = $chatmsg;
        $response['chat']['userdata'] = getUserdata($chatter_id);
    } else {
        $response['chat']['msgs'] = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>';
    }

    $response['newmsg'] = newMessageCount();

    echo json_encode($response);
}
