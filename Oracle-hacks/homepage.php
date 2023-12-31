<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "accounts";
$conn = mysqli_connect($servername, $username, $password, $database);
$sql = "SELECT * FROM `store` WHERE `username` = '".$_SESSION['username']."'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
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
            margin-right: 20px;
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
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th.sl-number {
            width: 500px;
            background-color: #9a1445;
            color: #fff;
            font-size: 14px;
        }

        th {
            background-color: #9a1445;
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #fff;
            color: #555;
        }

        a {
            color: #9a1445;
            text-decoration: none;
            transition: color 0.2s;
        }

        a:hover {
            color: #7c0d36;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-button {
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

        .action-button:hover {
            background-color: #7c0d36;
        }

        .footer {
            background-color: #9a1445;
            padding: 10px;
            color: #fff;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
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

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th class="sl-number">Website Name</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while($row= mysqli_fetch_assoc($result)){
                    ?>
                    <td><?php echo $row['website_name']; ?></td>
                    <td>........</td>
                </tr>
                <?php
                    }
                ?>
                
                <!-- Add more table rows with data as needed -->
            </tbody>
        </table>

        <div class="action-buttons">
            <button class="action-button" onclick="goToGeneratePage()">Generate</button>
            <button class="action-button" onclick="goToStorePage()">Store</button>
        </div>
    </div>

    <footer class="footer">
        &copy; 2023 Secure Oracle. All rights reserved.
    </footer>

    <script>
        const userIcon = document.querySelector('.user-icon');
        const userInfo = document.querySelector('.user-info');

        userIcon.addEventListener('click', () => {
            userInfo.classList.toggle('clicked');
        });

        // Close the dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userInfo.contains(event.target)) {
                userInfo.classList.remove('clicked');
            }
        });
        function goToStorePage() {
            window.location.href = 'storepage.php';
        }
        function goToGeneratePage() {
            window.location.href = 'generatepage.php';
        }
    </script>

    <script>
        function logout() {
            // Redirect to login.php
            window.location.href = "/Oracle-hacks/logout.php";
        }
    </script>

</body>

</html>