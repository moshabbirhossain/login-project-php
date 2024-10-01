<?php
session_start();
include_once 'db.php';

// Check if the form is submitted
if (isset($_POST['verify'])) {
    // Combine individual OTP fields into a single OTP string
    $entered_otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    // Check if entered OTP matches the session OTP
    if ($entered_otp == $_SESSION['otp']) {
        // Update verification status in the database
        $unique_id = $_SESSION['unique_id'];
        $sql = mysqli_query($conn, "UPDATE users SET verification_status = '1' WHERE unique_id = '$unique_id'");

        if ($sql) {
            // Clear OTP session and redirect to the welcome page
            unset($_SESSION['otp']); // Unset OTP
            $_SESSION['email'] = $_SESSION['email']; // Assuming you want to keep the email in session
            header("Location: welcome.php"); // Redirect to welcome.php
            exit();
        } else {
            echo "Error in updating verification status. Please try again.";
        }
    } else {
        echo "Incorrect OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification</title>
    <link rel="stylesheet" href="./verify.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-full bg-base-100">
        <div class="text-center w-96 border bg-base-200 mx-auto my-14 rounded shadow-lg">
            <div class="px-4 py-8">
                <h1 class="text-lg font-semibold">Verify Your Account</h1>
                <p>
                    We emailed you a four-digit OTP code to verify your account.
                    Please enter the code below.
                </p>
                <form method="POST" action="">
                    <div class="text-white error-text hidden border rounded-lg py-1 bg-error my-2">
                        Error
                    </div>
                    <div class="text-center fields-input flex justify-center items-center mx-0 my-4">
                        <input type="number" name="otp1" class="otp-field outline-none" placeholder="0" min="0" max="9"
                            required onpaste="false" />
                        <input type="number" name="otp2" class="otp-field outline-none" placeholder="0" min="0" max="9"
                            required onpaste="false" />
                        <input type="number" name="otp3" class="otp-field outline-none" placeholder="0" min="0" max="9"
                            required onpaste="false" />
                        <input type="number" name="otp4" class="otp-field outline-none" placeholder="0" min="0" max="9"
                            required onpaste="false" />
                    </div>
                    <div>
                        <input type="submit" name="verify" value="Verify Now"
                            class="btn w-full bg-green-500 hover:bg-green-600 my-2 text-white text-lg font-medium" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const otp = document.querySelectorAll('.otp-field');
        // Focus on the first input
        otp[0].focus();
        otp.forEach((field, index) => {
            field.addEventListener('keydown', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    otp[index].value = "";
                    setTimeout(() => {
                        otp[index + 1]?.focus();
                    }, 4);
                } else if (e.key === 'Backspace') {
                    setTimeout(() => {
                        otp[index - 1]?.focus();
                    }, 4);
                }
            })
        });
    </script>
</body>

</html>
