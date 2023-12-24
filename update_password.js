ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function updatePassword() {
    let oldPassword = document.getElementsByName("old_password")[0].value;
    let newPassword = document.getElementsByName("new_password")[0].value;
    let confirmPassword = document.getElementsByName("confirm_password")[0].value;

    let formData = new FormData();
    formData.append("UpdatePassword", "true");
    formData.append("old_password", oldPassword);
    formData.append("new_password", newPassword);
    formData.append("confirm_password", confirmPassword);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "update_password.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                document.getElementById("response").innerHTML = xhr.responseText;
            } else {
                console.error("Error updating password: " + xhr.status);
            }
        }
    };
    xhr.send(formData);
}
