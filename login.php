<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ind.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSIPMT Login</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            /* margin: 0; */
            /* padding: 0; */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color:rgb(247, 247, 247);
            

        }

        header {
            background-color:rgb(255, 255, 255);
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .banner-img {
            width: auto;
            height: 110px;
            max-height: 120px;
            object-fit: contain;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 0px; 
            background: url('bann.jpg') center center ;
            background-size: cover; /* Ensures the image covers the container */
            background-position: center ; /* Focuses on the top part of the image (buildings) */
        }

        .login-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5a67d8;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input.form-control {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            background-color: #5a67d8;
            border: none;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #434190;
        }

        .alert {
            font-size: 14px;
            margin-bottom: 15px;
        }

        footer {
            background: #2d3748;
            color: #e2e8f0;
            text-align: center;
            padding: 15px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <img src="Untitled design.jpeg" alt="SSIPMT Banner" class="banner-img">
</header>

<div class="main-content">
    <div class="login-form">
        <h2>TPO Login</h2>

        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            require_once "database.php";

            if (!str_ends_with($email, '@ssipmt.com')) {
                echo "<div class='alert alert-danger'>Only @ssipmt.com emails are allowed</div>";
            } else {
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                if ($user) {
                    if ($user["approved"] == 0) {
                        echo "<div class='alert alert-danger'>Your account is not approved by the admin yet.</div>";
                    } elseif (password_verify($password, $user["password"])) {
                        
                        $_SESSION["user"] = "yes";
                        $_SESSION["email"] = $email;
                        $_SESSION["role"] = $user["role"];
                        header("Location: ind.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            }
        }
        ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
            </div>
            <div class="form-btn mt-3">
                <input type="submit" name="login" value="Login" class="btn btn-primary">
            </div>
        </form>
        <p class="text-center mt-3">Not registered yet? <a href="registration.php">Register Here</a></p>
    </div>
</div>

<footer>
    Old Dhamtari Road, P.O. Sejbahar, Mujgahan, Raipur, Chhattisgarh,<br>
    Pin Code - 492015<br>
    Reception: 0771-3501600 / 0771-3501601
</footer>

</body>
</html>