<?php
session_start();
include_once 'db.php'; // Make sure your database connection is included

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash the password (replace with the hashing method used during registration)
    $hashed_password = md5($password);

    // Query to check the user's email and password
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
    $result = mysqli_query($conn, $sql);

    // If user is found in the database
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['unique_id'] = $row['unique_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone'] = $row['phone'];  // Assuming you also store phone

        // Redirect to welcome.php
        header("Location: welcome.php");
        exit();
    } else {
        // Show error message if credentials are invalid
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Login
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <!-- If there is an error message, show it here -->
                <?php if (isset($error_message)) { ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline"><?php echo $error_message; ?></span>
                    </div>
                <?php } ?>
                <form method="POST" action="login.php">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="email" name="email" placeholder="moshabbir@gmail.com" type="email" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                            Password
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password" name="password" type="password" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <input type="submit" value="Login"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        </span>
                    </div>
                </form>
                <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                    <a href="reset.php" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Forgotten Password?
                    </a>
                </p>

                <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                    OR
                </p>
                <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                    <a href="register.php" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
