<?php require APPROOT.'/views/inc/header.php'; ?>

<div class="error_first">
    <?=$data['display_error']?>
</div>

<div class="bg-ls">
    <div class="ls-contain">
        <img src="<?php echo URLROOT; ?>images/Asset login.png" width="99" height="99" style="margin-bottom: 20px ;">
        <form action="<?php echo URLROOT; ?>users/login" method="POST">


            <label for="name"> Email </label>
            <input type="email" name="email" value="<?php echo $data['post']['email']; ?>"
                style="width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">
            <br>

            <label for="password"> Password </label>
            <input type="password" name="password" value="<?php echo $data['post']['password']; ?>"
                style="width:270px; height:42px; border: solid 1px #c2c4c6; font-size:16px; padding-left:8px;">
            <br>

            <input type="submit" value="Login"> <br>

            <a href="<?php echo URLROOT; ?>users/register"> Don't have an account? </a>
        </form>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>