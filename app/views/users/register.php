<?php require APPROOT.'/views/inc/header.php'; ?>


<div class="error_first">
    <?=$data['display_error']?>
</div>

<div id="bgimg">
    <form class="register" action="<?php echo URLROOT; ?>users/register" method="POST">
        <h1>Welcome To Ride Share</h1><br>
        <fieldset class="row1">
            <p>
                <label for="name"> Full Name</label>
                <input type="text" name="name" value="<?php echo $data['post']['name']; ?>">
            </p>
            <p>
                <label for="name"> Email</label>
                <input type="email" name="email" value="<?php echo $data['post']['email']; ?>">
            </p>
            <p>
                <label for="password"> Password</label>
                <input type="password" name="password" value="<?php echo $data['post']['password']; ?>">
            </p>
            <p>
                <label for="confirm_pasword"> Confirm Password</label>
                <input type="password" name="confirm_password" value="<?php echo $data['post']['confirm_password']; ?>">
            </p>
        </fieldset>

        <div class="btn"><button class="button">Register &raquo;</button></div>
        <!--<button class="button" type="submit" value="Register"> <br>-->
        <a href="<?php echo URLROOT; ?>users/login">
            <h2>Have an account?</h2>
        </a>
    </form>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>