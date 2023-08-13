<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .header {
            background-color: #9a1445;
            padding: 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-right: 10px;
        }

        .website-info {
            display: flex;
            align-items: center;
        }

        .website-name {
            font-size: 24px;
            font-weight: bold;
            margin-left: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .home-icon {
            width: 40px;
            height: 40px;

            margin-right: 10px;
            cursor: pointer;

        }

        .user-info {
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
            margin-right: 10px;
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-name-dropdown {
            position: absolute;
            top: 60px;
            right: 10px;
            width: 180px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 5px;
            color: #555;
            display: none;
            flex-direction: column;
            padding: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .user-info.clicked .user-name-dropdown {
            display: flex;
        }

        .user-name {
            font-size: 16px;
            font-weight: bold;
            margin-right: 5px;
        }

        .logout-button {
            background-color: #9a1445;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #7c0d36;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #555;
            box-sizing: border-box;
            /* Fix the bulging issue */
        }

        .form-input::placeholder {
            color: #999;
        }

        .submit-button {
            background-color: #9a1445;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #7c0d36;
        }

        .footer {
            background-color: #9a1445;
            padding: 20px;
            color: #fff;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="website-info">
            <img class="logo" src="logo_index.png" alt="Secure Oracle Logo">
            <div class="website-name">Secure Oracle</div>
        </div>
        <div class="user-info">
            <a href="/Oracle-hacks/homepage.php">
                <img class="home-icon" src="home_icon.png" alt="Home Icon">
            </a>
            <div class="user-name">
                <?php echo $_SESSION['username'] ?>
            </div>
            <div class="user-icon"></div>
            <div class="user-name-dropdown">
                <div class="user-name">
                    <?php echo $_SESSION['username'] ?>
                </div>
                <button class="logout-button" onclick="logout()">Log Out</button>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uname = $_SESSION['username'];
        $wname = $_POST['website-name'];
        $sec_q = $_POST['your-question'];
        $sec_a = $_POST['answer'];
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
            $esql = "SELECT * FROM `store` WHERE `website_name` = '$wname' AND `username` = '$uname'";
            $result = mysqli_query($conn, $esql);
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Website ' . $wname . ' already exists! Please store another website name.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div>';
            } else {
                $sql = "INSERT INTO `store` (`username`, `website_name`, `sec_question`, `sec_answer`,`password`) VALUES ('$uname', '$wname', '$sec_q', '$sec_a', '$pass')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> data has been stored successfully!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Could not store the data. Please try again!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div>';
                }
            }
        }

    }


    ?>
    <div class="container">
        <form action="/Oracle-hacks/storepage.php" method="post">
            <div class="input-group">
                <label class="input-label" for="website-name">Website Name</label>
                <input class="form-input" type="text" id="website-name" name="website-name"
                    placeholder="Enter website name" required>
            </div>
            <div class="input-group">
                <label class="input-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password" placeholder="Enter password"
                    required>
            </div>
            <div class="input-group">
                <label class="input-label" for="your-question">Your Question</label>
                <input class="form-input" type="text" id="your-question" name="your-question"
                    placeholder="Enter your question" required>
            </div>
            <div class="input-group">
                <label class="input-label" for="answer">Answer</label>
                <input class="form-input" type="text" id="answer" name="answer" placeholder="Enter answer" required>
            </div>
            <button class="submit-button" type="submit">Submit</button>
        </form>
    </div>

    <footer class="footer">
        &copy; 2023 Secure Oracle. All rights reserved.
    </footer>

    <script>
        const userIcon = document.querySelector('.user-icon');
        const userInfo = document.querySelector('.user-info');
        const homeIcon = document.querySelector('.home-icon');

        userIcon.addEventListener('click', () => {
            userInfo.classList.toggle('clicked');
        });

        homeIcon.addEventListener('click', () => {
            window.location.href = 'homepage.html';
        });

        // Close the dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userInfo.contains(event.target)) {
                userInfo.classList.remove('clicked');
            }
        });
    </script>
    <script>
        function logout() {
            // Redirect to login.php
            window.location.href = "/Oracle-hacks/logout.php";
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