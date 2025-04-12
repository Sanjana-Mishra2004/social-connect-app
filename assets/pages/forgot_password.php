<div class="login">
    <div class="col-lg-4 col-md-8 col-sm-12 bg-white border rounded p-4 shadow-sm">

        <?php
        if (!isset($_SESSION['forgotpass_code']) && !isset($_SESSION['temp'])) {
            $action = 'forgot_pass';
        } elseif (isset($_SESSION['forgotpass_code']) && !isset($_SESSION['temp'])) {
            $action = 'verifyCode';
        } elseif (isset($_SESSION['forgotpass_code']) && isset($_SESSION['temp'])){
            $action = 'change_pass';
        }else {
            $action = 'forgot_pass';
        }
        ?>
        <form method="post" action="assets/php/actions.php?<?php echo $action ?>">
            <div class="d-flex justify-content-center">


            </div>
            <h1 class="h5 mb-3 fw-normal">Forgot Your Password ?</h1>
            <?php
            if ($action == 'forgot_pass') {
                echo '<div class="form-floating">
               <input type="email" name="email" class="form-control rounded-0" placeholder="username/email">
               <label for="floatingInput">Enter your Email ID:</label>
               </div>';
                show_error('email');
                echo '<button class="btn btn-primary mt-3" type="submit">Send Verification Code</button>';
            }
            ?>


            <?php
            if ($action == 'verifyCode') {
                echo ' <p>Enter 6 Digit Code Sended to You</p>
                <div class="form-floating mt-1">
                <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">######</label>
                </div>';
                show_error('verify_code');
                echo '<button class="btn btn-primary mt-3" type="submit">Verify Code</button> ';
            }
            ?>

            <?php
            if ($action == 'change_pass') {
                echo '<p>Enter Your New Password</p>
                <div class="form-floating mt-1">
                <input type="password" name="chpassword" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">new password</label>
                </div>';
                show_error('chpassword');
                echo ' <button class="btn btn-primary mt-3" type="submit">Change Password</button>';
            }
            ?>

            <br>
            <br>
            <a href="?login" class="text-decoration-none mt-5"><i class="bi bi-arrow-left-circle-fill"></i> Go Back To Login</a>
        </form>
    </div>
</div>