<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSIPMT Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f7f7f7;
        }

        header {
            text-align: center;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        header img {
            width: 100%;
            height: auto;
            max-height: 120px;
            object-fit: contain;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            background: url('bann.jpg') center center;
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
        }

        .registration-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5a67d8;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input.form-control, select.form-control {
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
    <img src="Untitled design.jpeg" alt="SSIPMT Banner">
</header>

<div class="main-content">
    <div class="registration-form">
        <h2>TPO Registration</h2>

        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           $role = $_POST["role"];

           $passwordHash = password_hash($password, PASSWORD_DEFAULT);
           $errors = array();

           if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
           }
           if (strlen($password) < 8) {
                array_push($errors,"Password must be at least 8 characters long");
           }
           if ($password !== $passwordRepeat) {
                array_push($errors,"Passwords do not match");
           }

           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);

           if ($rowCount > 0) {
                array_push($errors,"Email already exists!");
           }

           if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
           } else {
                $approved = ($role === "admin") ? 1 : 0;
                $sql = "INSERT INTO users (full_name, email, password, role, approved) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"ssssi", $fullName, $email, $passwordHash, $role, $approved);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully. Please wait for admin approval.</div>";
                } else {
                    die("Something went wrong");
                }
           }
        }
        ?>

        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:" required>
            </div>
            <div class="form-group">
                <select name="role" class="form-control" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-btn mt-3">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <p class="text-center mt-3">Already registered? <a href="login.php">Login Here</a></p>
    </div>
</div>

<footer>
    Old Dhamtari Road, P.O. Sejbahar, Mujgahan, Raipur, Chhattisgarh,<br>
    Pin Code - 492015<br>
    Reception: 0771-3501600 / 0771-3501601
</footer>

</body>
</html>
