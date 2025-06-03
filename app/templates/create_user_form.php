<p>Sign into your account.</p>

<form method="post">
    <p>
        <label>Username</label>
        <?php if (isset($form_errors["username"])) { ?>
        <pre><?= $form_errors["username"]; ?></pre>
        <?php } ?>
        <input name="username" type="text" value="<?= $form_username_value ?>">
    </p>
    <p>
        <?php if (isset($form_errors["password"])) { ?>
        <pre><?= $form_errors["password"]; ?></pre>
        <?php } ?>
        <label>Password</label>
        <input name="password" type="password" value="">
    </p>
    <p>
        <label>Confirm Password</label>
        <input name="confirm_password" type="password" value="">
    </p>
    <p>
        <button type="submit">Create account</button>
    </p>
</form>

<hr>

<p>Already have an account? <a href="login.php">Login.</a></p>
