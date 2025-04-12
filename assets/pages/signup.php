<div class="login" ng-app="">
    <div class="col-lg-4 col-md-8 col-sm-12 bg-white border rounded p-4 shadow-sm">
        <form method="post" action="assets/php/actions.php?signup" name="signupForm" novalidate>
            <div class="d-flex justify-content-center">
                <img class="mb-4" src="assets/images/myicon2.jpg" alt="" height="45">
                <span style="font-size: 20px;font-weight:bold;color:brown">MyCollegeConnect</span>

            </div>
            <h1 class="h5 mb-3 fw-normal">Create new account</h1>
            <div class="d-flex">
                <div class="form-floating mt-1 col-6 ">
                    <input type="text" name="fname" ng-model="fname" value="<?php echo show_formdata('fname') ?>" class="form-control rounded-0" placeholder="username/email" id="floatingInput1" ng-required="true">
                    <label for="floatingInput1">first name</label>
                    <span style="color:red" ng-show="signupForm.fname.$touched && signupForm.fname.$error.required">Firstname is Required</span>
                </div>
                <div class="form-floating mt-1 col-6">
                    <input type="text" name="lname" ng-model="lname" value="<?php echo show_formdata('lname') ?>" class="form-control rounded-0" placeholder="username/email" id="floatingInput2" ng-required="true">
                    <label for="floatingInput2">last name</label>
                    <span style="color:red" ng-show="signupForm.lname.$touched && signupForm.lname.$error.required">Lastname is Required</span>
                </div>
            </div>
            <?php show_error('fname'); ?>
            <?php show_error('lname'); ?>
            <div class="d-flex gap-3 my-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios1"
                        value="1" <?php echo show_formdata('gender') == 1 ? 'checked' : ''  ?>>
                    <!-- <?php isset($_SESSION['formdata']) ? '' : 'checked' ?> -->
                    <label class="form-check-label" for="exampleRadios1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                        value="2" <?php echo show_formdata('gender') == 2 ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="exampleRadios3">
                        Female
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                        value="0" <?php echo show_formdata('gender') == 0 ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="exampleRadios2">
                        Other
                    </label>
                </div>
            </div>
            <div class="form-floating mt-1">
                <input type="email" class="form-control rounded-0" placeholder="username/email" id="floatingInput3" name="email" ng-model="email" value="<?php echo show_formdata('email') ?>" ng-required="true">
                <label for="floatingInput3">email</label>
                <span style="color:red" ng-show="signupForm.email.$touched && signupForm.email.$error.required">Email is Required</span>
                <span style="color:red" ng-show="signupForm.email.$touched && signupForm.email.$error.email">Please Enter A Valid Email</span>
            </div>
            <?php show_error('email'); ?>
            <div class="form-floating mt-1">
                <input type="text" class="form-control rounded-0" placeholder="username/email" id="floatingInput4" name="uname" ng-model="uname" value="<?php echo show_formdata('uname') ?>" ng-required="true">
                <label for="floatingInput4">username</label>
                <span style="color:red" ng-show="signupForm.uname.$touched && signupForm.uname.$error.required">Username is Required</span>
            </div>
            <?php show_error('uname'); ?>
            <div class="form-floating mt-1">
                <input type="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password" name="pwd" ng-model="pwd" value="<?php echo show_formdata('pwd') ?>" ng-required="true" ng-pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/">
                <label for="floatingPassword">password</label>
                <span style="color:red" ng-show="signupForm.pwd.$touched && signupForm.pwd.$error.required">Password is Required</span>
                <span style="color:red" ng-show="signupForm.pwd.$touched && signupForm.pwd.$error.pattern">Password must have 8 characters, one uppercase letter, one lowercase letter, digits and special characters</span>
            </div>
            <?php show_error('pwd'); ?>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit" ng-disabled="signupForm.$invalid">Sign Up</button>
                <a href="?login" class="text-decoration-none">Already have an account ?</a>
            </div>

        </form>
    </div>
</div>

<!-- <div class=" mb-3" style="border: 3px solid black;font-weight:500;">
        <label for="city" class="form-label">City:</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
    </div>

    <div class=" mb-3" style="border: 3px solid black;font-weight:500;">
        <label for="state" class="form-label">State:</label>
        <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
    </div>

    <div class=" mb-3" style="border: 3px solid black;font-weight: 500;">
        <label for="edu" class="form-label">Education:</label>
        <input type="text" class="form-control" id="edu" name="edu" placeholder="Enter your educational background">
    </div>

    <div class=" mb-3" style="border: 3px solid black;font-weight: 500;">
        <label for="job" class="form-label">Current Job Title:</label>
        <input type="text" class="form-control" id="job" name="job" placeholder="Enter your current job title">
    </div>

    <div class=" mb-3" style="border: 3px solid black;font-weight: 500;">
        <label for="spec" class="form-label">Specialisation:</label>
        <input type="text" class="form-control" id="spec" name="spec" placeholder="Enter your area of specialisation">
    </div>

    <div class=" mb-3" style="border: 3px solid black;font-weight: 500;">
        <label for="bio" class="form-label">About:</label>
        <textarea type="text" class="form-control" id="bio" name="bio" rows="4" placeholder="Tell us more about yourself"></textarea>
    </div> -->