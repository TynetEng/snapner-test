<!DOCTYPE html>
<html>
<head>
    <title>Welcome Message</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #004aad;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 200px;
            height: 100px;
            object-fit: contain;
        }
        h1 {
            font-size: 24px;
            color: #fff;
            margin: 0;
            padding: 10px;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="https://invest.coremars.com/static/media/latestlogo.9a27561a418f87f4da0c.png" alt="Logo" class="logo">
    <div class="header">
        <h1>Welcome to COREMARS</h1>
    </div>

    <p>Dear {{ $employee->name}},</p>
    <p>We are excited to have you on board as a {{ $employee->position }} at {{ $employee->project->name }}.</p>
    <p>We are committed to providing you with top-notch services and solutions to help you achieve your goals. We believe that our partnership will be a valuable one, and we look forward to a long and successful relationship.</p>
    <p>If you have any questions or concerns, please do not hesitate to contact us. Our team is always ready and available to assist you.</p>
    <div>
        <p>Here are your login details:</p>
        <p>
            <b>Email/Username: </b> {{ $email }}
        </p>
        <p>
            <b>Password: </b> {{ $password }}
        </p>
        <p>
            <b>Login URL:</b> <a href="">Login</a>
        </p>
    </div>
    <p>Thank you for choosing COREMARS. We look forward to working with you.</p>
    <p>Best regards,</p>
    <p>COREMARS</p>
</div>
</body>
</html>





