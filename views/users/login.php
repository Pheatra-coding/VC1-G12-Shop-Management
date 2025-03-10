<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$errors = $_SESSION['errors'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            height:66%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .form-container {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .image-container {
            width: 50%;
            background: url('https://img.freepik.com/free-psd/marketing-concept-with-device_23-2149835027.jpg?t=st=1740799634~exp=1740803234~hmac=63f9c69618d9dbffeffba1227e932decb43542c0c56650bd2c6edcae3e4dd879&w=1380') center/cover;
            background-size: cover;
            background-position: center;
            padding: 0;
            margin-left: -23px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            background: transparent;
            font-size: 1rem;
            color: #fff;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-bottom-color: #fff;
            outline: none;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Override browser autofill styles */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: #fff;
            transition: background-color 5000s ease-in-out 0s;
            box-shadow: inset 0 0 20px 20px transparent;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            background: #fff;
            color: #4e54c8;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #4e54c8;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Error message styling */
        .error {
            color: #ff4d4d;
            font-size: 0.875rem;
            margin-top: 5px;
            font-weight: bold;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #4e54c8;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .form-container, .image-container {
                width: 100%;
            }

            .image-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container"></div>
        <div class="form-container">
            <h2>Login</h2>
            
            <form action="/users/authenticate" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?= $_SESSION['old_email'] ?? '' ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn">Login</button>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
unset($_SESSION['errors']); 
unset($_SESSION['old_email']); 
?>