<div class="card card-primary col-12">
    <div class="card-header">
        <h5 class="card-title">Generate User wise Report</h5>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="mb-3">
                <label for="exampleDataList" class="form-label">Select Report Type</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList" name="type" placeholder="Type to search...">
                <datalist id="datalistOptions">
                    <option value="User wise Post">
                    <option value="User wise Followers">
                    <option value="User wise Followings">
                    <option value="User wise Comments">
                    <option value="User wise Blocked Users">
                </datalist>
            </div>
            <div class="mb-3">
                <select id="selectBox" name="user" class="form-select col-12">
                    <option selected>Select User</option>
                    <?php
                    foreach ($userslist as $user) {
                    ?>
                        <option value="<?= $user['id'] ?>"><?= $user['fname'] ?> <?= $user['lname'] ?></option>
                    <?php
                    }
                    ?>

                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="sbt1">Submit</button>

        </form>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    </div>
</div>

<?php
if (isset($_POST['sbt1'])) {
    $type = $_POST['type'];
    $user = $_POST['user'];

    if (!empty($type) && $user !== "Select User") {
        if ($type == "User wise Post") {
            $row = searchPost($user);
?>
            <div class="card  mb-4">
                <div class="card-header">
                    <h5 class="card-title">User Post</h5>
                </div>
                <div class="card-body d-flex flex-wrap">
                    <?php
                    if (!empty($row) && $row !== 0) {
                    foreach ($row as $posts) {
                        // $likes = countLikes($posts['post_id']);
                    ?>
                        <img src="../assets/images/posts/<?= $posts['post_img'] ?>" data-bs-toggle="modal" data-bs-target="#postview<?= $posts['post_id'] ?>" width="300px" class="rounded m-2 shadow-sm" />
                    <?php
                    }
                }else {
                    echo '<div class="card w-60 m-auto">
                <div class="card-body bg-danger">
                    <p class="card-text ">No Post Found for this User.</p>
                </div>
            </div>';
                }
                    ?>
                </div>
            </div>
        <?php
        } elseif ($type == "User wise Followers") {
            $row = searchFollowers($user);
        ?>
            <div class="card w-100">
                <?php $count = 1 ?>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <?php
                            if (!empty($row) && $row !== 0) {
                            foreach ($row as $post) {
                                $userslist = getUserById($post['con_user_id']);
                                foreach ($userslist as $user) {
                            ?>
                                    <tr>
                                        <td>#<?= $count ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <img src="../assets/images/profile/<?= $user['profile_img'] ?>" class="rounded-circle border border-2 shadow-sm mx-2" width="55px" height="55px" />
                                                </div>
                                                <div>
                                                    <h5><?= $user['fname'] . ' ' . $user['lname'] ?> - <span class="text-muted">@<?= $user['username'] ?></span></h5>
                                                    <h6 class="text-muted"><?= $user['email'] ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                                $count++;
                            }
                        }else {
                            echo '<div class="card w-60 m-auto">
                        <div class="card-body bg-danger">
                            <p class="card-text ">This User has no Followers.</p>
                        </div>
                    </div>';
                        }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } elseif ($type == "User wise Followings") {
            $row = searchFollowing($user);

        ?>
            <div class="card w-100">
                <?php $count = 1 ?>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <?php
                            if (!empty($row) && $row !== 0) {
                            foreach ($row as $post) {
                                $userslist = getUserById($post['user_id']);
                                foreach ($userslist as $user) {
                            ?>
                                    <tr>
                                        <td>#<?= $count ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <img src="../assets/images/profile/<?= $user['profile_img'] ?>" class="rounded-circle border border-2 shadow-sm mx-2" width="55px" height="55px" />
                                                </div>
                                                <div>
                                                    <h5><?= $user['fname'] . ' ' . $user['lname'] ?> - <span class="text-muted">@<?= $user['username'] ?></span></h5>
                                                    <h6 class="text-muted"><?= $user['email'] ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                                $count++;
                            }
                        }else {
                            echo '<div class="card w-60 m-auto">
                        <div class="card-body bg-danger">
                            <p class="card-text ">This User is not Following anyone.</p>
                        </div>
                    </div>';
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php

        } elseif ($type == "User wise Comments") {
            $row = searchComments($user);
        ?>
            <div class="card w-100">
                <?php $count = 1 ?>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Comment</th>
                                <th>Post ID</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($row) && $row !== 0) {
                            foreach ($row as $post) {
                                // $userslist = getUserById($post['blocked_user_id']);
                                // foreach ($userslist as $user) {
                            ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= $post['content'] ?></td>
                                    <td><?= $post['post_id'] ?></td>
                                    <td><?= gettime($post['created_at']) ?></td>
                                </tr>
                            <?php

                                $count++;
                            }
                        }else {
                            echo '<div class="card w-60 m-auto">
                        <div class="card-body bg-danger">
                            <p class="card-text ">No Comments Found for this User.</p>
                        </div>
                    </div>';
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php

        } elseif ($type == "User wise Blocked Users") {
            $row = searchBlockedUsers($user);
        ?>
            <div class="card w-100">
                <?php $count = 1 ?>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <?php
                            if (!empty($row) && $row !== 0) {
                            foreach ($row as $post) {
                                $userslist = getUserById($post['blocked_user_id']);
                                foreach ($userslist as $user) {
                            ?>
                                    <tr>
                                        <td>#<?= $count ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <img src="../assets/images/profile/<?= $user['profile_img'] ?>" class="rounded-circle border border-2 shadow-sm mx-2" width="55px" height="55px" />
                                                </div>
                                                <div>
                                                    <h5><?= $user['fname'] . ' ' . $user['lname'] ?> - <span class="text-muted">@<?= $user['username'] ?></span></h5>
                                                    <h6 class="text-muted"><?= $user['email'] ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                                $count++;
                            }
                        }else {
                            echo '<div class="card w-60 m-auto">
                        <div class="card-body bg-danger">
                            <p class="card-text ">This User has not Blocked anyone.</p>
                        </div>
                    </div>';
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php
        }
    }
    else {
        echo '<div class="card w-60 m-auto">
                <div class="card-body bg-danger">
                    <p class="card-text ">Nothing Found. Please select both type and user!</p>
                </div>
            </div>';
    }
} 

?>