<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$faculty_email = $_SESSION["email"];
$user_role = $_SESSION["role"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Company</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
         body {
            background: url('60240.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        header.top-header {
            text-align: center;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header.top-header img {
            height: 80px;
            margin-bottom: 10px;
        }
        header.top-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #333;
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .company-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
        }
        .company-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5a67d8;
        }
        .form-element {
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
        footer {
            background: #2d3748;
            color: #e2e8f0;
            text-align: center;
            padding: 15px 10px;
            font-size: 14px;
        }
        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header class="top-header">
    <img src="logo2.jpg" alt="SSIPMT Logo">
    <h1>Shri Shankaracharya Institute of Professional Management & Technology, Raipur</h1>
</header>

<div class="container">
    <div class="company-form">
        <div class="back-btn">
            <a href="ind.php" class="btn btn-secondary">← Back</a>
        </div>
        <h2>Add New Company</h2>

        <?php if ($user_role !== "admin") { ?>
        <div class="alert alert-danger text-center" role="alert" style="font-weight: bold;">
            YOU CANNOT EDIT DATA SO PLEASE ENTER CAREFULLY
        </div>
        <?php } ?>

        <form action="process.php" method="post">
            <div class="form-element">
                <input type="text" class="form-control" name="name" placeholder="Name of Company:" required>
            </div>
            <div class="form-element">
                <input type="text" class="form-control" name="contact_person" placeholder="Contact Person Name:" required>
            </div>
            <div class="form-element">
                <input type="email" class="form-control" name="email" placeholder="Contact Person E-mail:" required>
            </div>
            <div class="form-element">
                <input type="number" class="form-control" name="phone" placeholder="Contact Person Phone:" required>
            </div>
            <div class="form-element">
                <input type="text" class="form-control" name="location" placeholder="Location of Company:" required>
            </div>
            <div class="form-element">
                <input type="text" class="form-control" name="website" placeholder="Website of Company:" required>
            </div>
            <div class="form-element">
                <input type="email" class="form-control" name="TPO_Email" placeholder="TPO Coordinator's E-mail ID:" value="<?php echo $faculty_email; ?>" readonly>
            </div>
            <div class="form-element">
                <input type="text" class="form-control" name="TPO_coordinator_name" placeholder="TPO Coordinator's Name:">
            </div>
            <div class="form-element">
                <select name="Type_of_company" class="form-control" required>
                    <option value="">Select Type of Company</option>
                    <option value="IT">IT</option>
                    <option value="Core Engineering">Core Engineering</option>
                    <option value="Finance">Finance</option>
                </select>
            </div>    
            <div class="form-element">
                <select name="Type_of_interaction" class="form-control" required>
                    <option value="">Type of interaction</option>
                    <option value="Campus Drive">Campus Drive</option>
                    <option value="Virtual Drive">Virtual Drive</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>
            <div class="form-element">
                <label for="last_visited">Last Visited on Campus:</label>
                <input type="date" class="form-control" name="last_visited" id="last_visited">
            </div>
            <div class="form-element">
            <textarea class="form-control" name="remark" placeholder="Enter meeting discussion or remarks" rows="4"></textarea>
        </div>
            <div class="form-element mt-3">
                <input type="submit" name="create" value="Add Company" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<footer>
    Old Dhamtari Road, P.O. Sejbahar, Mujgahan, Raipur, Chhattisgarh,<br>
    Pin Code - 492015<br>
    Reception: 0771-3501600 / 0771-3501601
</footer>

</body>
</html>