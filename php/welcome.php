<?php
session_start();
include_once 'db.php'; // Include your database connection

// Redirect to login page if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get the email from the session
$email = $_SESSION['email'];

// Fetch the user details from the database
$sql = mysqli_query($conn, "SELECT name, username, phone, email FROM users WHERE email = '$email'");

// Check if the query was successful and a user was found
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
    $name = $row['name'];
    $username = $row['username'];
    $phone = $row['phone'];
    $email = $row['email'];
} else {
    // If user not found, redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="w-full bg-base-100 my-14">
    <h1 class="text-center font-bold text-xl my-6 text-green-600">Welcome, <?php echo $name; ?>!</h1>
    <div class="bg-white dark:bg-gray-900 border-2 rounded-xl shadow-xl p-4 w-72 mx-auto">
        <div class="border-b pb-6 text-center">
            <img src="../assets/profile_icon.jpeg" alt="Profile Picture"
                class="w-24 rounded-full border-4 border-white dark:border-gray-800 mx-auto my-4" />
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-1">
                <?php echo $name; ?>
            </h3>
            <div class="text-black dark:text-white">
                <div>Username: <?php echo $username; ?></div>
                <div>Phone: <?php echo $phone; ?></div>
                <div>Email: <?php echo $email; ?></div>
            </div>
        </div>
        <div class="pt-3">
            <a href="login.php">
                <button
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Logout
                </button>
            </a>
        </div>
    </div>
</body>

</html>
