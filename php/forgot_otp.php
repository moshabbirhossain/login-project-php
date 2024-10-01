<?php 
session_start();
include_once 'db.php';

if (isset($_POST['verify'])) {
    $entered_otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'];

    if ($entered_otp == $_SESSION['otp']) {
        unset($_SESSION['otp']); // Clear OTP session
        header("Location: forgot.php"); // Redirect to set new password
        exit();
    } else {
        $error_message = "Incorrect OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="verify.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex justify-center py-12">
        <div class="max-w-md w-full border rounded bg-base-200 p-10">
            <h2 class="text-center text-3xl font-bold">Verify OTP</h2>
            <form method="POST" action="">
                <?php if (isset($error_message)) { ?>
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded"><?php echo $error_message; ?></div>
                <?php } ?>

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