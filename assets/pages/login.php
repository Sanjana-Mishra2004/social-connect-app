<div class="login" ng-app="">
    <div class="col-lg-4 col-md-8 col-sm-12 bg-white border rounded p-4 shadow-sm">
        <form method="post" action="assets/php/actions.php?login" name="loginForm" novalidate>
            <div class="d-flex justify-content-center">
                <img class="mb-4" src="assets/images/myicon2.jpg" alt="" height="45">
                <span style="font-size: 20px;font-weight:bold;color:brown">MyCollegeConnect</span>

            </div>
            <h1 class="h5 mb-3 fw-normal">Please Log in</h1>

            <div class="form-floating">
                <input type="text" class="form-control rounded-0" placeholder="username/email" id="floatingInput" name="uname_email" ng-model="uname_email" value="<?php echo show_formdata('uname_email') ?>" ng-required="true">
                <label for="floatingInput">username/email</label>
                <span style="color:red" ng-show="loginForm.uname_email.$touched && loginForm.uname_email.$error.required">Username/Email is Required</span>
                <!-- <span style="color:red" ng-show="loginForm.uname_email.$invalid && loginForm.uname_email.$error.email">Please Enter A Valid Email</span> -->

            </div>
            <?php show_error('uname_email'); ?>

            <div class="form-floating mt-2">
                <input type="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password" name="password" ng-model="password" value="<?php echo show_formdata('password') ?>" ng-required="true">
                <label for="floatingPassword">password</label>
                <span style="color:red" ng-show="loginForm.password.$touched && loginForm.password.$error.required">Password is Required</span>
            </div>
            <?php show_error('password'); ?>
            <?php show_error('checkuser'); ?>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit" ng-disabled="loginForm.$invalid">Log in</button>
                <!-- <a href="?signup" class="text-decoration-none">Create New Account</a> -->
            </div>

            <div class="mt-3 d-flex justify-content-center align-items-center">
                <!-- <button class="btn btn-primary" type="submit" ng-disabled="loginForm.$invalid">Log in</button> -->
                <a href="?signup" class="text-decoration-none">Create New Account</a>
            </div>
            <div class="mt-3 d-flex justify-content-center align-items-center">
                <a href="?forgot_pass&newfp" class="text-decoration-none">Forgot password ?</a>
            </div>
        </form>
    </div>
</div>