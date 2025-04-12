<!-- addPost Modal -->
<div class="modal fade" id="addPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" style="display:none" id="post_img" class="w-100 rounded border">
                <form method="post" action="assets/php/actions.php?addpost" enctype="multipart/form-data">
                    <div class="my-3">

                        <input class="form-control" type="file" name="post_img" id="select_post_img">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
                        <textarea class="form-control" name="post_text" id="exampleFormControlTextarea1" rows="1"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Notification Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Notifications</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        $notifications = getNotifications();
        // echo var_dump($notifications);

        foreach ($notifications as $notif) {
            $time = $notif['created_at'];
            $from_user = getUserdata($notif['from_user_id']);
            // echo var_dump($from_user);

            $post = '';
            if ($notif['post_id']) {
                $post = 'data-bs-toggle="modal" data-bs-target="#postview' . $notif['post_id'] . '"';
            }
            $fbtn = '';

        ?>

            <div class="d-flex justify-content-between border-bottom">
                <div class="d-flex align-items-center p-2">
                    <div><img src="assets/images/profile/<?= $from_user['profile_img'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                    </div>
                    <div>&nbsp;&nbsp;</div>
                    <div class="d-flex flex-column justify-content-center" <?= $post ?>>
                        <a href='?user=<?= $from_user['username'] ?>' class="text-decoration-none text-dark">
                            <h6 style="margin: 0px;font-size: small;"><?= $from_user['fname'] ?> <?= $from_user['lname'] ?></h6>
                        </a>
                        <p style="margin: 0px;font-size:small" class="<?= $notif['read_status'] ? 'text-muted' : '' ?>">@<?= $from_user['username'] ?> <?= $notif['message'] ?></p>
                        <time style="font-size: small;" class="timeago <?= $notif['read_status'] ? 'text-muted' : '' ?> text-small" datetime="<?= $time ?>"></time>
                    </div>
                </div>


                <div class="d-flex align-items-center">
                    <?php
                    if ($notif['read_status'] == 0) {
                        echo '<div class="p-1 bg-primary rounded-circle"></div>';
                    } else if ($notif['read_status'] == 2) {
                        echo '<span class="badge bg-danger">Post Deleted</span>';
                    }

                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>




<!-- Chatbox Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="message_sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Messages</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="chatlist">



    </div>
</div>

<!-- Modal for chats -->
<div class="modal fade" id="chatbox" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <a href="" id="clink" class="text-decoration-none text-dark">
                <h5 class="modal-title fs-5" id="exampleModalLabel"><img src="assets/images/profile/defaultprofile.jpg" alt="" id="chatter_img" height="40" width="40" class="m-1 rounded-circle border"><span id="chatter_fname"></span>(@<span id="chatter_uname">loading...</span>)</h5>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column-reverse gap-2" id="user_chat">
                loading.....
            </div>
            <div class="modal-footer">
                <p class="p-2 text-danger mx-auto" style="display: none;" id="blockerror"><i class="bi bi-x-circle-fill"></i>You are not allowed to send message to this user!</p>
                <div class="input-group p-2" id="msg_sender">
                    <input type="text" class="form-control rounded-0 border-0" id="msginput" placeholder="say something.." aria-label="Recipient username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary rounded-0 border-0" id="sendmsg"  type="button">Send</button>
                </div>

            </div>
        </div>
    </div>
</div>




<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery-3.5.1.js"></script>
<script src="assets/js/angular.min.js"></script>
<script src="assets/js/jquery.timeago.js"></script>
<script src="assets/js/custom.js?v=<?php echo time() ?>"></script>
</body>

</html>