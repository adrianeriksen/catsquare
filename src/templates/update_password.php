<div class="main white-background">
    <h1>Update password</h1>

    <form method="post">
        <p>
            <label>Current password</label>
            <input name="current_password" type="password" value="">
        </p>
        <p>
            <label>New password</label>
            <?php if (isset($form_errors["new_password"])): ?>
            <pre><?= $form_errors["new_password"]; ?></pre>
            <?php endif; ?>
            <input name="new_password" type="password" value="">
        </p>
        <p>
            <label>Confirm new password</label>
            <input name="confirm_new_password" type="password" value="">
        </p>
        <p>
            <button type="submit">Update password</button>
        </p>
    </form>

    <hr>

    <p>
        <a href="settings.php">Back to profile settings</a>
    </p>
</div>
