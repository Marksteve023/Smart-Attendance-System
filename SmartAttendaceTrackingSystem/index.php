<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #66a6ff, #89f7fe);
            overflow: hidden;
            flex-direction: column;
            color: #fff; 
        }

        .title {
            text-align: center;
            font-weight: bold;
            opacity: 0;
            animation: fadeInUp 2s forwards;
        }

        .title h1 {
            margin: 0.5rem 0;
            font-size: 3rem; 
            font-weight: bold;
            background: linear-gradient(135deg, #ff7f50, #ff6347, #1e90ff);
            -webkit-background-clip: text; 
            color: transparent; 
            text-align: center;
            animation: fadeInUp 2s forwards;
        }
        .login-btn {
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 3s 0.5s forwards;
        }

        .login-btn a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background: transparent;
            color: white; 
            text-decoration: none;
            border: 2px solid white; 
            border-radius: 5px;
            transition: transform 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
        }

        .login-btn a:hover {
            transform: scale(1.1);
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #ff6347; 
            color: black;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <title>
        Smart Attendance Tracking System
    </title>
</head>
<body>

    <header class="title">
        <h1>Smart Attendance Tracking System</h1>
    </header>

    <div class="login-btn">
        <!-- Use PHP to dynamically set the link if needed -->
        <a href="login.php">Login</a>
    </div>

</body>
</html>
