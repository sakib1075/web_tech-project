$(document).ready(function () {
    // View Profile Button Click Event
    $("#viewProfileBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "profile.php",
            data: { action: "viewProfile" },
            success: function (data) {
                $("#additionalInfo").html(data);
                $("#additionalInfo").toggle();
            }
        });
    });

    // Update Profile Button Click Event
    $("#updateProfileBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "profile.php",
            data: { action: "updateProfile" },
            success: function (data) {
                // Handle the response as needed
                console.log(data);
            }
        });
    });
});
