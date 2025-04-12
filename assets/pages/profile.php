<?php
global $user;
global $profile;
global $user_post;

if (checkFollowStatus($profile['id']) && checkFollowStatus2($profile['id'])) {
    $followed_both = true;
} else {
    $followed_both = false;
}
// print_r($followed_both);
?>
<div class="container col-md-9 col-sm-11 rounded-0">
    <div class="col-12 rounded p-4 mt-4 d-md-flex gap-5">
        <div class="col-md-4 col-sm-12 d-flex justify-content-center mx-auto align-items-start">
            <div class="px-md-5"></div><img src="assets/images/profile/<?php echo $profile['profile_img'] ?>"
                class="img-thumbnail rounded-circle mb-3" style="height:170px;width:170px;" alt="...">
        </div>
        <div class="col-md-8 col-sm-11">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <span class="fs-4 text-break me-3"><?php echo $profile['fname'] ?> <?php echo $profile['lname'] ?></span>
                    <?php
                    if ($user['id'] != $profile['id'] && !checkBS($profile['id'])) {
                        echo '<div class="dropdown">
                        <span class="" style="font-size:xx-large" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i> </span>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item ' . ($followed_both ? '' : 'disabled') . '" href="#" data-bs-toggle="modal" data-bs-target="#chatbox" onclick="popchat(' . $profile['id'] . ')"><i class="bi bi-chat-fill"></i> Message</a></li>
                            <li><a class="dropdown-item" href="assets/php/actions.php?block=' . $profile['id'] . '&username=' . $profile['username'] . '"><i class="bi bi-x-circle-fill"></i> Block</a></li>
                        </ul>
                    </div>';
                    }

                    ?>

                </div>
                <span style="font-size: larger;" class="text-secondary">@<?php echo $profile['username'] ?></span>
                <?php
                if (!checkBS($profile['id'])) {
                ?>
                    <div class="d-flex gap-2 align-items-center my-3">

                        <a class="btn btn-sm btn-primary"><i class="bi bi-file-post-fill"></i> <?php echo count($user_post) ?> Posts</a>
                        <a class="btn btn-sm btn-primary <?php echo count($profile['followers']) < 1 ? 'disabled' : '' ?>" data-bs-toggle="modal" data-bs-target="#followersList"><i class="bi bi-people-fill"></i> <?php echo count($profile['followers']) ?> Followers</a>
                        <a class="btn btn-sm btn-primary <?php echo count($profile['following']) < 1 ? 'disabled' : '' ?>" data-bs-toggle="modal" data-bs-target="#followingList"><i class="bi bi-person-fill"></i> <?php echo count($profile['following']) ?> Following</a>


                    </div>
                <?php
                }
                ?>

                <?php
                if ($user['id'] != $profile['id']) {
                    echo '<div class="d-flex gap-2 align-items-center my-3">';
                    if (checkBlockStatus($user['id'], $profile['id'])) {

                        echo '<button class="btn btn-sm btn-danger unblockbtn" data-user-id=' . $profile['id'] . '>Unblock</button>';
                    } else if (checkBlockStatus($profile['id'], $user['id'])) {
                        echo '<div class="alert alert-danger" role="alert">
                            <i class="bi bi-x-octagon-fill"></i> @' . $profile['username'] . ' blocked you!
                        </div>';
                    } else if (checkFollowStatus($profile['id'])) {
                        echo '<button class="btn btn-sm btn-danger unfollowbtn" data-user-id=' . $profile['id'] . '>Unfollow</button>';
                    } else {
                        echo '<button class="btn btn-sm btn-primary followbtn" data-user-id=' . $profile['id'] . '>Follow</button>';
                    }
                    echo '</div>';
                }

                ?>
            </div>
        </div>


    </div>

    <!-- to display post -->
    <h3 class="border-bottom">Posts</h3>
    <?php

    if (checkBS($profile['id'])) {
        $user_post = array();
        echo '<div class="alert alert-secondary text-center" role="alert">
            <i class="bi bi-x-octagon-fill"></i> You are not allowed to see post!
        </div>';
    } else if (count($user_post) < 1) {
        echo "<p class='p-2 bg-white border rounded text-center my-3'>Not posted anything yet!</p>";
    }
    ?>
    <div class="gallery row g-2 mb-4">
        <?php
        foreach ($user_post as $posts) {
            $likes = countLikes($posts['post_id']);
        ?>
            <div class="col-6 col-sm-4 col-md-3">
                <div class="ratio ratio-1x1">
                    <img src="assets/images/posts/<?= $posts['post_img'] ?>" class="w-100 h-100 object-fit-cover rounded" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#postview<?= $posts['post_id'] ?>" />
                </div>
            </div>

            <div class="modal fade" id="postview<?= $posts['post_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl ">
                    <div class="modal-content">

                        <div class="modal-body p-0 d-flex flex-column flex-md-row" style="max-height: 90vh; overflow:hidden">
                            <div class="w-100 p-2">
                                <img src="assets/images/posts/<?= $posts['post_img'] ?>" class="w-100 h-100 rounded object-fit-contain" style="max-height:85vh">
                            </div>



                            <div class="w-100 d-flex flex-column p-2 border-start bg-white" style="max-height: 90vh; overflow-y: auto;">
                                <div class="d-flex align-items-center <?= $posts['post_text'] ? '' : 'border-bottom' ?>">
                                    <img src="assets/images/profile/<?= $profile['profile_img'] ?>" alt="" height="50" width="50" class="rounded-circle border me-2">
                                    <div class="d-flex flex-column justify-content-start">
                                        <h6 class="mb-0"> <?= $profile['fname'] ?> <?= $profile['lname'] ?></h6>
                                        <p class="text-muted mb-0">@<?= $profile['username'] ?></p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end flex-fill">
                                        <div class="dropdown text-end">

                                            <span class="<?= count($likes) < 1 ? 'disabled' : '' ?>" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?= count($likes) ?> likes
                                            </span>


                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                                <?php
                                                foreach ($likes as $like) {
                                                    $lu = getUserdata($like['user_id']);
                                                ?>
                                                    <li><a class="dropdown-item" href="?user= <?= $lu['username'] ?>"> <?= $lu['fname'] . ' ' . $lu['lname'] ?>(@<?= $lu['username'] ?>)</a></li>

                                                <?php
                                                }
                                                ?>

                                            </ul>
                                        </div>
                                        <div class="text-muted small">Posted <?= show_time($posts['created_at']) ?></div>
                                    </div>
                                </div>
                                <div class="border-bottom p-2<?= $posts['post_text'] ? '' : 'd-none' ?>"><?= $posts['post_text'] ?></div>
                                <div class="flex-grow-1 overflow-auto p-2" style="min-height:100px;" id="comment-section<?= $posts['post_id'] ?>">
                                <?php
                                $comments = getComments($posts['post_id']);
                                if (count($comments) < 1) {
                                    echo "<p class='p-2 text-center my-3 nce'>No Comments Yet</p>";
                                }
                                foreach ($comments as $comment) {
                                    $cuser = getUserdata($comment['user_id']);
                                    echo '<div class="d-flex align-items-start mb-2">
                                        <img src="assets/images/profile/' . $cuser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border me-2">
                                        <div>
                                            <h6 class="mb-0"><a href="?user=' . $cuser['username'] . '" class="text-decoration-none text-dark">@' . $cuser['username'] . '</a> - ' . $comment['content'] . '</h6>
                                            <small class="text-muted">' . show_time($comment['created_at']) . '</small>
                                        </div>
                                    </div>';
                                }
                                echo '</div>';
                                if (checkFollowStatus($profile['id']) || $profile['id'] == $user['id']) {
                                    echo '<div class="input-group p-2 border-top">
                                    <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.."
                                    aria-label="Recipient username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-cs="comment-section' . $posts['post_id'] . '"  data-post-id="' . $posts['post_id'] . '"  type="button"
                                    id="button-addon2">Post</button>
                                </div>';
                                } else {
                                    echo '<div class="text-center p-2">
                                    Follow this user to comment </div>';
                                }
                                echo '    </div>



                        </div>

                    </div>
                </div>
            </div>';
                            }
                                ?>
                                </div>

                            </div>

                            <!-- showing followers list -->
                            <div class="modal fade" id="followersList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Followers</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            foreach ($profile['followers'] as $fers) {
                                                $fuser = getUserdata($fers['con_user_id']);
                                                $fbtn = ' ';
                                                if (checkFollowStatus($fers['con_user_id'])) {
                                                    $fbtn = '<button class="btn btn-sm btn-danger unfollowbtn" data-user-id="' . $fuser['id'] . '">Unfollow</button>';
                                                } elseif ($user['id'] == $fers['con_user_id']) {
                                                    $fbtn = ' ';
                                                } else {
                                                    $fbtn =  '<button class="btn btn-sm btn-primary followbtn" data-user-id="' . $fuser['id'] . '">Follow</button>';
                                                }
                                                echo '<div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center p-2">
                                                            <div><img src="assets/images/profile/' . $fuser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border">
                                                            </div>
                                                            <div>&nbsp;&nbsp;</div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                            <a href="?user=' . $fuser['username'] . '" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;">' . $fuser['fname'] . ' ' . $fuser['lname'] . '</h6></a>
                                                                <p style="margin:0px;font-size:small" class="text-muted">@' . $fuser['username'] . '</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            ' . $fbtn . '

                                                        </div>
                                                    </div>';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- showing following list -->
                            <div class="modal fade" id="followingList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Following</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            foreach ($profile['following'] as $fing) {
                                                $fuser = getUserdata($fing['user_id']);
                                                $fbtn = ' ';
                                                if (checkFollowStatus($fing['user_id'])) {
                                                    $fbtn = '<button class="btn btn-sm btn-danger unfollowbtn" data-user-id="' . $fuser['id'] . '">Unfollow</button>';
                                                } elseif ($user['id'] == $fing['user_id']) {
                                                    $fbtn = ' ';
                                                } else {
                                                    $fbtn =  '<button class="btn btn-sm btn-primary followbtn" data-user-id="' . $fuser['id'] . '">Follow</button>';
                                                }
                                                echo '<div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center p-2">
                                                            <div><img src="assets/images/profile/' . $fuser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border">
                                                            </div>
                                                            <div>&nbsp;&nbsp;</div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                            <a href="?user=' . $fuser['username'] . '" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;">' . $fuser['fname'] . ' ' . $fuser['lname'] . '</h6></a>
                                                                <p style="margin:0px;font-size:small" class="text-muted">@' . $fuser['username'] . '</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            ' . $fbtn . '

                                                        </div>
                                                    </div>';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>