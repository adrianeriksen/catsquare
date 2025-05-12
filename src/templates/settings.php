<div class="main white-background">
    <h1>Profile</h1>

    <form method="post">
        <p>
            <label>Tagline</label>
            <input name="tagline" type="text" value="<?= $profile["tagline"] ?>">
        </p>
        <p>
            <label>Webpage</label>
            <input name="webpage" type="url" value="<?= $profile["webpage"] ?>">
        </p>
        <p>
            <button>Update profile</button>
        </p>
    </form>

    <hr>

    <p>
        <a href="password.php">Change password</a>
    </p>
</div>
