<?php require_once(__ROOT__ . "Views/_header.php"); ?>
<h2>Change password</h2>
<form action="settings/password" method="POST">
    <div class="form-group">
        <label for="oldPassword">
            Old password
        </label>
        <input class="form-control" id="oldPassword" name="oldPassword" required type="password">
    </div>
    <div class="form-group">
        <label for="password">
            New password
        </label>
        <input class="form-control" id="password" name="password" required type="password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">
            Verify password
        </label>
        <input class="form-control" id="password_confirmation" name="password_confirmation" required type="password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" name="changePasswordSubmit" type="submit" value="Change password">
    </div>
</form>

<h2>Delete account</h2>
<p class="text-danger">This can't be undone! Use with caution!</p>
<a onclick='return confirm_delete("Do you really want to delete your account?")' href="settings/delete" class="btn btn-primary">Delete account</a>
<?php require_once(__ROOT__ . "Views/_footer.php"); ?>
