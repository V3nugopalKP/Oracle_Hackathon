<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="icon" type="image/png" href="logo_non_white.png">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .background-image {
            background-image: url('bg.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .container {
            width: 100%;
            max-width: 380px;
            margin: 10px auto;
            border-radius: 8px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .form-input {
            box-sizing: border-box;
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #555;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            border-color: #9a1445;
            outline: none;
        }

        .form-button {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            background-color: #9a1445;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: #701f48;
        }

        .form-button:focus {
            outline: none;
        }

        .form-title {
            text-align: center;
            font-size: 32px;
            color: #9a1445;
            margin-bottom: 30px;
        }

        .form-links {
            text-align: center;
            margin-top: 10px;
        }

        .form-links a {
            color: #9a1445;
            text-decoration: none;
            margin: 0 10px;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .error-border {
            border-color: red;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }
    </style>
</head>

<body class="background-image">
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uname = $_POST['username'];
        $pass = $_POST['password'];

        // Submit these to a database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "accounts";
        $conn = mysqli_connect($servername, $username, $password, $database);
        if (!$conn) {
            die("Sorry we failed to connect: " . mysqli_connect_error());
        } else {
            $sql = "SELECT * FROM `user-details` WHERE `username` = '$uname'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (password_verify($pass, $row['password'])) {
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $uname;
                        $_SESSION['user-id'] = $uid;
                        header("location: homepage.php");
                    }else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Your password ' . $password . ' does not match!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        </div>';
                    }
                }

            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Your username ' . $uname . ' and password ' . $password . ' does not exist!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>';
            }
        }
    }
    ?>
    <header class="header">
        <a href="index.php"><img class="logo" src="logo_non_white.png" alt="Secure Oracle Logo"></a>
    </header>
    <div class="container">
        <div class="form-title">LOGIN</div>
        <form action="/Oracle-hacks/login.php" method="post">
            <div class="form-group">
                <label class="form-label" for="username">User name</label>
                <input class="form-input" type="text" id="username" name="username" placeholder="Enter your user name">
                <span class="error-message" id="error-username"></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password"
                    placeholder="Enter your password">
                <span class="error-message" id="error-password"></span>
            </div>
            <div class="form-group">
                <button class="form-button" type="submit">Log in</button>
            </div>
        </form>
        <div class="form-links">
            <a href="forget.html">Forgot password?</a>
            <span>|</span>
            <a href="create_acc.php">Create new account</a>
        </div>
    </div>
    <script>
        // For Login Page
        document.getElementById("username").addEventListener("input", function () {
            checkEmpty(this, "error-username", "Username cannot be empty.");
        });

        document.getElementById("password").addEventListener("input", function () {
            checkPasswordLength(this, "error-password", "Password must be at least 8 characters long.");
        });

        // For Create Account Page
        document.getElementById("fullname").addEventListener("input", function () {
            checkEmpty(this, "error-fullname", "Full name cannot be empty.");
        });

        document.getElementById("email").addEventListener("input", function () {
            checkEmpty(this, "error-email", "Email cannot be empty.");
        });

        document.getElementById("password").addEventListener("input", function () {
            checkPasswordLength(this, "error-password", "Password must be at least 8 characters long.");
        });

        document.getElementById("confirm-password").addEventListener("input", function () {
            checkPasswordMatch(this, "error-confirm-password", "Passwords do not match.");
        });

        // For Forgot Password Page
        document.getElementById("email").addEventListener("input", function () {
            checkEmpty(this, "error-email", "Email cannot be empty.");
        });

        // Validation Functions
        function checkEmpty(inputElement, errorElementId, errorMessage) {
            var errorElement = document.getElementById(errorElementId);
            if (inputElement.value.trim() === "") {
                errorElement.textContent = errorMessage;
                inputElement.classList.add("error-border");
            } else {
                errorElement.textContent = "";
                inputElement.classList.remove("error-border");
            }
        }

        function checkPasswordLength(inputElement, errorElementId, errorMessage) {
            var errorElement = document.getElementById(errorElementId);
            if (inputElement.value.length > 0 && inputElement.value.length < 8) {
                errorElement.textContent = errorMessage;
                inputElement.classList.add("error-border");
            } else {
                errorElement.textContent = "";
                inputElement.classList.remove("error-border");
            }
        }

        function checkPasswordMatch(confirmPasswordElement, errorElementId, errorMessage) {
            var errorElement = document.getElementById(errorElementId);
            var passwordElement = document.getElementById("password");
            if (confirmPasswordElement.value !== passwordElement.value) {
                errorElement.textContent = errorMessage;
                confirmPasswordElement.classList.add("error-border");
            } else {
                errorElement.textContent = "";
                confirmPasswordElement.classList.remove("error-border");
            }
        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>

</html>