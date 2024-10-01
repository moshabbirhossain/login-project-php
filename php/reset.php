<?php
session_start();
include_once 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer's autoloader (if using Composer)
require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $otp = rand(1000, 9999); // Generate a random OTP
        $_SESSION['otp'] = $otp; // Store OTP in session
        $_SESSION['email'] = $email; // Store email for verification

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'hossainmoshabbir337@gmail.com'; // Your SMTP username (Gmail address)
            $mail->Password = 'xgodhmksgiscrikl'; // Use App Password if 2FA is enabled
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('hossainmoshabbir337@gmail.com', 'Moshabbir'); // Set sender's email and name
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body    = 'Your OTP for password reset is: <strong>' . $otp . '</strong>';
            $mail->AltBody = 'Your OTP for password reset is: ' . $otp;

            $mail->send();
            header("Location: forgot_otp.php");
            exit();
        } catch (Exception $e) {
            $error_message = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex justify-center py-12 ">
        <div class="max-w-md w-full bg-base-200 border p-10 rounded-lg">
            <h2 class="text-center text-3xl font-bold">Reset Password</h2>
            <form method="POST" action="reset.php">
                <?php if (isset($error_message)) { ?>
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded"><?php echo $error_message; ?></div>
                <?php } ?>
                <div class="mt-4">
                    <label>Email</label>
                    <input type="email" name="email" required class="block border px-3 py-1.5 rounded w-full mt-1" />
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-600 rounded text-white py-2">Send OTP</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
