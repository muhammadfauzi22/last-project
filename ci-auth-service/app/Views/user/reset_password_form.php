<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <form id="resetPasswordForm">
        <input type="hidden" id="token" name="token" value="<?= $token ?>">
        <input type="hidden" id="email" name="email" value="<?= $email ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="password">Confirm New Password:</label>
        <input type="password" id="confirmpassword" name="confirmpassword" required>
        <button type="submit">Reset Password</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resetPasswordForm').submit(function(e) {
                e.preventDefault();
                if ($('#password').val().trim() === '') {
                    alert('Password cannot be empty');
                    return;
                }
                if ($('#password').val().trim() === $('#confirmpassword').val().trim()) {
                    $.ajax({
                        url: '/api/reset-password',
                        type: 'POST',
                        data: {
                            token: $('#token').val(),
                            email: $('#email').val(),
                            password: $('#password').val()
                        },
                        success: function(response) {
                            alert(response.message);
                        },
                        error: function(xhr) {
                            alert('Failed to reset password: ' + xhr.responseText);
                        }
                    });
                } else {
                    alert('Passwords do not match');
                    return;
                }
            });
        });
    </script>
</body>

</html>