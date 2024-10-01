<?php
session_start();
include_once 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require '../vendor/autoload.php';

$name = $_POST['name'];
$username = $_POST['username'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$cpassword = md5($_POST['confirm_password']);
$verification_status = '0'; // Initially set as unverified
$role = 'user';

// Check if fields are not empty
if (!empty($name) && !empty($username) && !empty($phone) && !empty($email) && !empty($password) && !empty($cpassword)) {
    // Validate email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email ~ Already Exists";
        } else {
            // Check if passwords match
            if ($password === $cpassword) {
                $random_id = rand(time(), 10000000); // Generate unique user ID
                $otp = mt_rand(1000, 9999); // Generate 4-digit OTP
                $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, name, username, phone, email, password, otp, verification_status, role) 
                VALUES ('$random_id', '$name', '$username', '$phone', '$email', '$password', '$otp', '$verification_status', '$role')");

                if ($sql2) {
                    // Store session variables for OTP verification
                    $_SESSION['unique_id'] = $random_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['otp'] = $otp;

                    // Setup PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                        $mail->SMTPAuth = true;
                        $mail->Username = 'hossainmoshabbir337@gmail.com'; // Your Gmail address
                        $mail->Password = 'xgodhmksgiscrikl'; // Your Gmail password or app-specific password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                        $mail->Port = 587; // TCP port to connect to

                        // Recipients
                        $mail->setFrom('hossainmoshabbir337@gmail.com', 'Moshabbir');
                        $mail->addAddress($email); // Add the user's email

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Email Verification Code';
                        $mail->Body = "Hi $name,<br><br>Your verification code is: <strong>$otp</strong><br>Please enter this code on the verification page to verify your email.";
                        
                        // Send the email
                        $mail->send();
                        echo "OTP sent to $email. Please check your email and verify.";
                        header("Location: verify.php"); // Redirect to verification page
                    } catch (Exception $e) {
                        echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                echo "Passwords don't match.";
            }
        }
    } else {
        echo "$email ~ This is not a valid email.";
    }
} else {
    echo "All input fields are required.";
}
?>
