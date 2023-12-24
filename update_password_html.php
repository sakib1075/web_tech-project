
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <script src="update_password.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <section class="edit_container">
            <h3 class="heading">Update Profile</h3>
            <form id="updatePasswordForm" class="update_product product_container" method="post" novalidate>
                <div class="update-profile-fields update-fields">
                    <input type="password" name="old_password" class="input_fields fields" placeholder="Old Password">
                    <input type="password" name="new_password" class="input_fields fields" placeholder="New Password">
                    <input type="password" name="confirm_password" class="input_fields fields" placeholder="Confirm Password">
                </div>
                <div class="btns">
                    <input type="button" class="edit_btn" id="updatePasswordBtn" value="Update Password" onclick="updatePassword();">
                    <input type="button" id="close-edit" value="Cancel" class="cancel_btn">
                </div>
            </form>
        </section>
</div>
</body>

</html>
