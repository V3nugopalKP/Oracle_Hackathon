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
        .home-icon {
            width: 40px;
            height: 40px;
            
            margin-right: 10px;
            cursor: pointer;
           
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
        }

        .form-input::placeholder {
            color: #999;
        }

        .generate-button {
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

        .generate-button:hover {
            background-color: #7c0d36;
        }

        .generated-password {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
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
            <a href="/Oracle-hacks/homepage.php">
                <img class="home-icon" src="home_icon.png" alt="Home Icon">
            </a>
            <div class="user-name"><?php echo $_SESSION['username'] ?></div>
            <div class="user-icon"></div>
            <div class="user-name-dropdown">
                <div class="user-name"><?php echo $_SESSION['username'] ?></div>
                <button class="logout-button" onclick="logout()">Log Out</button>
            </div>
        </div>
    </div>

    <div class="container">
        <form>
            <div class="input-group">
                <label class="input-label" for="password-length">Password Length</label>
                <input class="form-input" type="number" id="password-length" name="password-length" placeholder="Enter password length" min="8" max="32" required>
            </div>
            <div class="input-group">
                <label class="input-label">Include Uppercase Letters</label>
                <input type="checkbox" id="include-uppercase">
            </div>
            <div class="input-group">
                <label class="input-label">Include Lowercase Letters</label>
                <input type="checkbox" id="include-lowercase">
            </div>
            <div class="input-group">
                <label class="input-label">Include Numbers</label>
                <input type="checkbox" id="include-numbers">
            </div>
            <div class="input-group">
                <label class="input-label">Include Special Characters</label>
                <input type="checkbox" id="include-special">
            </div>
            <button class="generate-button" type="button">Generate Password</button>
            <div class="generated-password" id="generated-password"></div>
        </form>
    </div>

    <footer class="footer">
        &copy; 2023 Secure Oracle. All rights reserved.
    </footer>

    <script>
        const userIcon = document.querySelector('.user-icon');
        const userInfo = document.querySelector('.user-info');
        const generateButton = document.querySelector('.generate-button');
        const homeIcon = document.getElementById('home-icon');

        

        userIcon.addEventListener('click', () => {
            userInfo.classList.toggle('clicked');
        });

        // Close the dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userInfo.contains(event.target)) {
                userInfo.classList.remove('clicked');
            }
        });

        generateButton.addEventListener('click', () => {
            generatePassword();
        });
        homeIcon.addEventListener('click', () => {
            window.location.href = 'homepage.html';
        });

        function generatePassword() {
    const length = parseInt(document.getElementById('password-length').value);
    const includeUppercase = document.getElementById('include-uppercase').checked;
    const includeLowercase = document.getElementById('include-lowercase').checked;
    const includeNumbers = document.getElementById('include-numbers').checked;
    const includeSpecial = document.getElementById('include-special').checked;
    let charset = '';
    let password = '';

    if (isNaN(length) || length <= 0) {
        alert('Please enter a valid password length.');
        return;
    }

    if (includeUppercase) {
        charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        password += charset[Math.floor(Math.random() * charset.length)];
    }
    if (includeLowercase) {
        charset += 'abcdefghijklmnopqrstuvwxyz';
        password += charset[Math.floor(Math.random() * charset.length)];
    }
    if (includeNumbers) {
        charset += '0123456789';
        password += charset[Math.floor(Math.random() * charset.length)];
    }
    if (includeSpecial) {
        charset += '!@#$%^&*()_-+=<>?';
        password += charset[Math.floor(Math.random() * charset.length)];
    }

    if (charset === '') {
        alert('Please select at least one character type.');
        return;
    }

    for (let i = password.length; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }

    document.getElementById('generated-password').innerText = password;
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
