<?php
global $user;
global $posts;
global $follow_suggestions;
?>

<div class="container col-md-10 col-sm-12 col-lg-9 rounded-0 d-flex flex-column flex-lg-row justify-content-between">
    <div class="col-lg-6 col-md-12 col-sm-12" style="max-width:93vw">
        <?php
        show_error('post_img');
        if (count($posts) < 1) {
            echo "<p style='width:100%'  class='p-2 bg-white border rounded text-center my-3'>Follow someone or Add a new Post</p>";
        }
        foreach ($posts as $post) {
            $likes = countLikes($post['post_id']);
            $comments = getComments($post['post_id']);
        ?>
            <div class="card mt-4">
                <div class="card-title d-flex justify-content-between  align-items-center">

                    <div class="d-flex align-items-center p-2">
                        <a href="?user=<?php echo $post['username'] ?>" class="text-decoration-none text-dark"> <img src="assets/images/profile/<?php echo $post['profile_img'] ?>" alt="" height="30" width="30" class="rounded-circle border">&nbsp;&nbsp;
                            <?php echo $post['fname'] ?> <?php echo $post['lname'] ?></a>

                    </div>
                    <div class="p-2">
                        <?php
                        if ($post['uid'] == $user['id']) {
                        ?>

                            <div class="dropdown">

                                <i class="bi bi-three-dots-vertical" id="option<?= $post['post_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false"></i>

                                <ul class="dropdown-menu" aria-labeledby="option<?= $post['post_id'] ?>">
                                    <li><a class="dropdown-item" href="assets/php/actions.php?deletepost=<?= $post['post_id'] ?>"><i class="bi bi-trash-fill"></i> Delete Post</a></li>
                                </ul>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="ratio ratio-4x3">
                    <img src="assets/images/posts/<?= $post['post_img'] ?>"
                        class="w-100 h-100 object-fit-cover"
                        alt="Post image"
                        loading="lazy">
                </div>
                <h4 style="font-size: x-larger" class="p-2 border-bottom">
                    <span>
                        <?php
                        if (checkLikeStatus($post['post_id'])) {
                            $like_btn = 'none';
                            $unlike_btn = ' ';
                        } else {
                            $unlike_btn = 'none';
                            $like_btn = ' ';
                        }
                        ?>
                        <i class="bi bi-heart-fill unlike_btn text-danger" style="display: <?php echo $unlike_btn ?>" data-post-id="<?php echo $post['post_id'] ?>"></i>
                        <i class="bi bi-heart like_btn" style="display: <?php echo $like_btn ?>" data-post-id="<?php echo $post['post_id'] ?>"></i>
                    </span>
                    &nbsp;&nbsp;<i class="bi bi-chat-left"><span class="p-1 mx-2 text-small" style="font-size:small" data-bs-toggle="modal" data-bs-target="#postview<?php echo $post['post_id'] ?>"><?php echo count($comments) ?> comments</span></i>

                </h4>
                <div>
                    <span class="p-1 mx-2" data-bs-toggle="modal" data-bs-target="#likeList<?php echo $post['post_id'] ?>"><span id="likecount<?php echo $post['post_id'] ?>"><?php echo count($likes) ?></span> likes</span>
                    <span style="font-size:small" class="text-muted">Posted</span> <?= show_time($post['created_at']) ?>

                </div>
                <?php
                if ($post['post_text']) {
                ?>
                    <div class="card-body">
                        <?php echo $post['post_text'] ?>
                    </div>
                <?php
                }
                ?>

                <div class="input-group p-2 <?php echo $post['post_text'] ? 'border-top' : ' ' ?> ">
                    <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.."
                        aria-label="Recipient username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-page='home' data-cs="comment-section<?php echo $post['post_id'] ?>" data-post-id="<?php echo $post['post_id'] ?>" type="button"
                        id="button-addon2">Post</button>
                </div>

            </div>


            <!-- to show users who commented on the post -->
            <div class="modal fade" id="postview<?php echo $post['post_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Likes and Comments</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="ratio ratio-4x3 mb-3" style="max-height: 90vh;">
                                <img src="assets/images/posts/<?= $post['post_img'] ?>" class="img-fluid object-fit-cover w-100 h-100 rounded" alt="Post Image">
                            </div>


                            <div class="d-flex align-items-center p-2 border-bottom">
                                <div><img src="assets/images/profile/<?php echo $post['profile_img'] ?>" alt="" height="50" width="50" class="rounded-circle border">
                                </div>
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-start align-items-center">
                                    <h6 style="margin: 0px;"><?php echo $post['fname'] ?> <?php echo $post['lname'] ?></h6>
                                    <p style="margin:0px;" class="text-muted">@<?php echo $post['username'] ?></p>
                                </div>
                                <div class="d-flex flex-column align-items-end flex-fill">
                                    <div class=""></div>
                                    <div class="dropdown">
                                        <span class="<?php echo count($likes) < 1 ? 'disabled' : '' ?>" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo count($likes) ?> likes
                                        </span>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <?php
                                            foreach ($likes as $like) {
                                                $lu = getUserdata($like['user_id']);
                                            ?>
                                                <li><a class="dropdown-item" href="?user=<?php echo $lu['username'] ?>"><?php echo $lu['fname'] . ' ' . $lu['lname'] ?> (@<?php echo $lu['username'] ?>)</a></li>

                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                    <div style="font-size:small" class="text-muted">Posted <?= show_time($post['created_at']) ?> </div>

                                </div>
                            </div>
                            <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?php echo $post['post_id'] ?>" style="height: 200px;">
                                <?php
                                if (count($comments) < 1) {
                                    echo "<p class='p-2 my-3 nce'>Currently 0 Comments</p>";
                                }
                                foreach ($comments as $comment) {
                                    $cuser = getUserdata($comment['user_id']);
                                ?>
                                    <div class="d-flex align-items-center p-2">
                                        <div><img src="assets/images/profile/<?php echo $cuser['profile_img'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                                        </div>
                                        <div>&nbsp;&nbsp;&nbsp;</div>
                                        <div class="d-flex flex-column justify-content-start align-items-start">
                                            <h6 style="margin: 0px;"><a href="?user=<?php echo $cuser['username'] ?>" class="text-decoration-none text-dark">@<?php echo $cuser['username'] ?></a></h6>
                                            <p style="margin:0px;" class="text-muted"><?php echo $comment['content'] ?></p>
                                            <p style="margin:0px;" class="text-muted">(<?= show_time($comment['created_at']) ?>)</p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="input-group p-2 border-top">
                                <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="say something.."
                                    aria-label="Recipient username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-page='home' data-cs="comment-section<?php echo $post['post_id'] ?>" data-post-id="<?php echo $post['post_id'] ?>" type="button"
                                    id="button-addon2">Post</button>
                            </div>
                            <!-- </div> -->



                        </div>
                    </div>
                </div>
            </div>


            <!-- showing users list who liked the post -->
            <div class="modal fade" id="likeList<?php echo $post['post_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Likes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            if (count($likes) < 1) {
                                echo '<p>Currently 0 Likes</p>';
                            }
                            foreach ($likes as $like) {
                                $luser = getUserdata($like['user_id']);
                                $lbtn = ' ';
                                if (checkBS($like['user_id'])) {
                                    continue;
                                } elseif (checkFollowStatus($like['user_id'])) {
                                    $lbtn = '<button class="btn btn-sm btn-danger unfollowbtn" data-user-id="' . $luser['id'] . '">Unfollow</button>';
                                } elseif ($user['id'] == $like['user_id']) {

                                    $lbtn = ' ';
                                } else {
                                    $lbtn =  '<button class="btn btn-sm btn-primary followbtn" data-user-id="' . $luser['id'] . '">Follow</button>';
                                }
                                echo '<div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center p-2">
                                            <div><img src="assets/images/profile/' . $luser['profile_img'] . '" alt="" height="40" width="40" class="rounded-circle border">
                                            </div>
                                            <div>&nbsp;&nbsp;</div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="?user=' . $luser['username'] . '" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;">' . $luser['fname'] . ' ' . $luser['lname'] . '</h6></a>
                                                <p style="margin:0px;font-size:small" class="text-muted">@' . $luser['username'] . '</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                        ' . $lbtn . '

                                        </div>
                                    </div>';
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>

    <!-- follow suggestions -->
    <div class="col-lg-4 col-sm-12 col-md-12 overflow-hidden mt-4 p-sm-0 p-md-3">
        <div class="d-flex align-items-center p-2">
            <div><img src="assets/images/profile/<?php echo $user['profile_img'] ?>" alt="" height="60" width="60" class="rounded-circle border">
            </div>
            <div>&nbsp;&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center">
                <a href="?user=<?php echo $user['username'] ?>" class="text-decoration-none text-dark">
                    <h6 style="margin: 0px;"><?php echo $user['fname'] ?> <?php echo $user['lname'] ?></h6>
                </a>
                <p style="margin:0px;" class="text-muted">@<?php echo $user['username'] ?></p>
            </div>
        </div>
        <div>
            <h6 class="text-muted p-2">You Can Follow Them</h6>
            <?php
            foreach ($follow_suggestions as $fusers) {
            ?>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center p-2">
                        <div><img src="assets/images/profile/<?php echo $fusers['profile_img'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-center">
                            <a href="?user=<?php echo $fusers['username'] ?>" class="text-decoration-none text-dark">
                                <h6 style="margin: 0px;font-size: small;"><?php echo $fusers['fname'] ?> <?php echo $fusers['lname'] ?></h6>
                            </a>
                            <p style="margin:0px;font-size:small" class="text-muted">@<?php echo $fusers['username'] ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-primary followbtn" data-user-id="<?php echo $fusers['id'] ?>">Follow</button>

                    </div>
                </div>
            <?php
            }
            if (count($follow_suggestions) < 1) {
                echo "<p class='p-2 bg-white border rounded text-center'>No more suggestions</p>";
            }
            ?>


        </div>
    </div>
</div>