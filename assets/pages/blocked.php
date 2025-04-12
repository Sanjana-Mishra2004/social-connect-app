<?php
global $user;
?>

<div class="login">
    <div class="col-md-4 col-sm-12 bg-white border rounded p-4 shadow-sm">
        <form>
            <div class="d-flex justify-content-center">

                <img class="mb-4" src="assets/images/myicon2.jpg" alt="" height="45">
                <span style="font-size: 20px;font-weight:bold;color:brown">MyCollegeConnect</span>

            </div>
            <h1 class="h5 mb-3 fw-normal">Hello, <?php echo $user['fname'] . ' ' . $user['lname'] .
                                                        '<br>(' . $user['email'] . ')' ?>,
                <br>Your Account Is Blocked By Admin
            </h1>




            <div class="mt-3 d-flex justify-content-between align-items-center">
                <a href="assets/php/actions.php?logout" class="btn btn-danger" type="submit">Logout</a>



            </div>

        </form>
    </div>
</div>