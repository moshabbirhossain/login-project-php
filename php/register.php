<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>
    <style>
        /* Custom CSS translated from Tailwind */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
        }

        .form {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 1rem;
        }

        label {
            font-size: 0.875rem;
            color: #4a5568;
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #63b3ed;
            outline: none;
            box-shadow: 0 0 0 3px rgba(100, 181, 255, 0.2);
        }

        .error-text {
            background-color: #f56565;
            color: white;
            text-align: center;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        .submit {
            display: inline-block;
            width: 100%;
            background-color: #3182ce;
            color: white;
            padding: 0.75rem;
            text-align: center;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit:hover {
            background-color: #2b6cb0;
        }

        .text-red-500 {
            color: #f56565;
        }

        .text-center {
            text-align: center;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        a {
            color: #3182ce;
            text-decoration: none;
        }

        a:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form">
        <div class="container">
            <h2>Create a new account</h2>

            <form id="signup-form" action="signup.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="error-text">
                    Error
                </div>

                <!-- Name field -->
                <div>
                    <label for="name">Name <span style="color: red">*</span></label>
                    <input id="name" name="name" placeholder="Moshabbir Hossain" type="text" oninput="validateField('name')" required />
                    <p id="name-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Username field -->
                <div>
                    <label for="username">Username <span style="color: red">*</span></label>
                    <input id="username" name="username" placeholder="moshabbir_hossain" type="text" oninput="validateField('username')" required />
                    <p id="username-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Phone field -->
                <div>
                    <label for="phone">Phone <span style="color: red">*</span></label>
                    <input id="phone" name="phone" placeholder="01738****92" type="text" oninput="validateField('phone')" required />
                    <p id="phone-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Email field -->
                <div class="mt-6">
                    <label for="email">Email address <span style="color: red">*</span></label>
                    <input id="email" name="email" placeholder="user@example.com" type="email" oninput="validateField('email')" required />
                    <p id="email-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Password field -->
                <div class="mt-6">
                    <label for="password">Password <span style="color: red">*</span></label>
                    <input id="password" name="password" type="password" oninput="validateField('password')" required />
                    <p id="password-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Confirm Password field -->
                <div class="mt-6">
                    <label for="confirm_password">Confirm Password <span style="color: red">*</span></label>
                    <input id="confirm_password" name="confirm_password" type="password" oninput="validateField('confirm_password')" required />
                    <p id="confirm-password-error" class="text-red-500 text-sm mt-1"></p>
                </div>

                <!-- Submit button -->
                <div class="mt-6">
                    <input type="submit" value="Create account" class="submit" />
                </div>
            </form>

            <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                Or
                <a href="login.php">login to your account</a>
            </p>
        </div>
    </div>

    <script>
        // Validate individual fields in real-time as the user types
        function validateField(field) {
            const value = document.getElementById(field).value;
            let error = "";
            switch (field) {
                case "name":
                    if (!/^[A-Za-z\s.]+$/.test(value)) {
                        error = "Name should only contain letters, spaces, and (.) operator.";
                    }
                    break;

                case "username":
                    if (!/^[a-z0-9_]{5,15}$/.test(value)) {
                        error = "Username should be 5-15 characters, lowercase letters, numbers, and underscores only.";
                    }
                    break;

                case "phone":
                    if (!/^(\+?88)?01[3-9]\d{8}$/.test(value)) {
                        error = "Please enter a valid Bangladeshi phone number.";
                    }
                    break;

                case "email":
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        error = "Please enter a valid email address.";
                    }
                    break;

                case "password":
                    if (!/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}/.test(value)) {
                        error = "Password must be at least 8 characters long, with uppercase, lowercase, a number, and a special character.";
                    }
                    break;

                case "confirm_password":
                    const password = document.getElementById("password").value;
                    if (value !== password) {
                        error = "Passwords do not match.";
                    }
                    break;
            }

            // Display the error message and hide it if the input is valid
            const errorElement = document.getElementById(`${field}-error`);
            if (error) {
                errorElement.innerText = error;
            } else {
                errorElement.innerText = "";  // Clear error message when valid
            }
        }

        // Form validation on submit
        function validateForm() {
            const fields = [
                "name",
                "username",
                "phone",
                "email",
                "password",
                "confirm_password",
            ];
            let isValid = true;

            fields.forEach((field) => {
                validateField(field);
                const error = document.getElementById(`${field}-error`).innerText;
                if (error) isValid = false;
            });

            return isValid;  // Submit form only if all fields are valid
        }
    </script>
</body>

</html>
