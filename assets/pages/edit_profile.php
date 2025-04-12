<?php  global $user;?>
<div class="container col-md-9 col-sm-12 rounded-0 d-flex justify-content-between">
    <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
        <form method="post" action="assets/php/actions.php?updateprofile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">


            </div>
            <h1 class="h5 mb-3 fw-normal">Edit Profile</h1>
            <?php if (isset($_GET['success'])) {
                echo "<p class='text-success'>Profile is updated successfully</p>";
            } ?>
            <div class="form-floating mt-1 col-md-6 col-sm-12">
                <img src="assets/images/profile/<?php echo $user['profile_img']?>" class="img-thumbnail my-3" style="height:150px;width:150px" alt="...">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Change Profile Picture</label>
                    <input class="form-control" type="file" id="formFile" name="profile_img">
                </div>
                <?php show_error('profile');?>
            </div>
            <div class="d-flex">
                <div class="form-floating mt-1 col-6 ">
                    <input type="text" name="fname" value="<?php echo $user['fname']?>" class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">first name</label>
                </div>
               
                <div class="form-floating mt-1 col-6">
                    <input type="text" name="lname" value="<?php echo $user['lname']?>" class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">last name</label>
                </div>
                
            </div>
            <?php show_error('fname');?>
            <?php show_error('lname');?>
            
            <div class="d-flex gap-3 my-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                        value="option1" <?php echo $user['gender']==1?'checked':' '?> disabled>
                    <label class="form-check-label" for="exampleRadios1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                        value="option2" <?php echo $user['gender']==2?'checked':' '?> disabled>
                    <label class="form-check-label" for="exampleRadios3">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                        value="option2" <?php echo $user['gender']==0?'checked':' '?> disabled>
                    <label class="form-check-label" for="exampleRadios2">
                        Other
                    </label>
                </div>
            </div>
            <div class="form-floating mt-1">
                <input type="email" value="<?php echo $user['email']?>" class="form-control rounded-0" placeholder="email" disabled>
                <label for="floatingInput">email</label>
            </div>
            <div class="form-floating mt-1">
                <input type="text" value="<?php echo $user['username']?>" name="uname" class="form-control rounded-0" placeholder="username">
                <label for="floatingInput">username</label>
            </div>
            <?php show_error('uname');
                ?>
            <div class="form-floating mt-1">
                <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">new password</label>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Update Profile</button>



            </div>

        </form>
    </div>

</div>