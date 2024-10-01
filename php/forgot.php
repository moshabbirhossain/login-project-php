<?php
session_start();
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Validate password length and complexity
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W_]/", $password)) {
        $error_message = "Password must be at least 8 characters long and include uppercase, lowercase, a number, and a special character.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = md5($password); // Hash the new password
        $email = $_SESSION['email']; // Get the email from the session

        // Update the password in the database
        $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if (mysqli_query($conn, $sql)) {
            session_unset(); // Clear session after password update
            header("Location: login.php"); // Redirect to login page
            exit();
        } else {
            $error_message = "Error updating password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex justify-center py-12">
        <div class="max-w-md w-full bg-base-200 border rounded p-10">
            <h2 class="text-center text-3xl font-bold">Set New Password</h2>
            <form method="POST" action="">
                <div class="mt-4">
                    <label>New Password</label>
                    <input type="password" name="password" required class="block w-full mt-1 border rounded py-1.5 px-3" />
                </div>
                <div class="mt-4">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required class="block w-full mt-1 border rounded py-1.5 px-3" />
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Update Password</button>
                </div>
                <?php if (isset($error_message)) { ?>
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded"><?php echo $error_message; ?></div>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>
