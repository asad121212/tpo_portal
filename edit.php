<!-- filepath: d:\php\htdocs\Login-register\edit.php -->
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include("connect.php");

// Check if the record exists
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (!$row) {
        echo "<h3>Record Does Not Exist</h3>";
        exit();
    }
} else {
    echo "<h3>Invalid Request</h3>";
    exit();
}

// Check if the form is submitted
if (isset($_POST["edit"])) {
    $role = $_SESSION["role"];
    $id = $_POST["id"];

    if ($role === "admin") {
        // Admin can edit all fields
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $contact_person = mysqli_real_escape_string($conn, $_POST["contact_person"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
        $location = mysqli_real_escape_string($conn, $_POST["location"]);
        $website = mysqli_real_escape_string($conn, $_POST["website"]);
        $TPO_Email = mysqli_real_escape_string($conn, $_POST["TPO_Email"]);
        $TPO_coordinator_name = mysqli_real_escape_string($conn, $_POST["TPO_coordinator_name"]);
        $Type_of_company = mysqli_real_escape_string($conn, $_POST["Type_of_company"]);
        $Type_of_interaction = mysqli_real_escape_string($conn, $_POST["Type_of_interaction"]);
        $last_visited = mysqli_real_escape_string($conn, $_POST["last_visited"]);
        $remark = mysqli_real_escape_string($conn, $_POST["remark"]);

        $sqlUpdate = "UPDATE books SET 
            Name_of_Company = '$name',
            Contact_person_name = '$contact_person',
            Contact_person_email = '$email',
            Contact_person_phone = '$phone',
            Location_of_Company = '$location',
            Website_of_company = '$website',
            TPO_Email = '$TPO_Email',
            TPO_coordinator_name = '$TPO_coordinator_name',
            Type_of_company = '$Type_of_company',
            Type_of_interaction = '$Type_of_interaction',
            last_visited = '$last_visited',
            remark = '$remark',
            last_modified = NOW()
            WHERE id = $id";
    } else {
        // Users can only edit the "Remark" field
        $remark = mysqli_real_escape_string($conn, $_POST["remark"]);

        $sqlUpdate = "UPDATE books SET 
            remark = '$remark',
            last_modified = NOW()
            WHERE id = $id";
    }

    if (mysqli_query($conn, $sqlUpdate)) {
        header("Location: view.php?id=$id");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to update record: " . mysqli_error($conn) . "</div>";
    }
}
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
        <h2>Edit Company</h2>
        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <?php if ($_SESSION["role"] === "admin") { ?>
                <!-- Admin can edit all fields -->
                <div class="form-element">
                    <input type="text" class="form-control" name="name" placeholder="Name of Company:" value="<?php echo $row["Name_of_Company"]; ?>" required>
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="contact_person" placeholder="Contact Person:" value="<?php echo $row["Contact_person_name"]; ?>" required>
                </div>
                <div class="form-element">
                    <input type="email" class="form-control" name="email" placeholder="Email:" value="<?php echo $row["Contact_person_email"]; ?>" required>
                </div>
                <div class="form-element">
                    <input type="number" class="form-control" name="phone" placeholder="Phone:" value="<?php echo $row["Contact_person_phone"]; ?>" required>
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="location" placeholder="Location:" value="<?php echo $row["Location_of_Company"]; ?>" required>
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="website" placeholder="Website of Company:" value="<?php echo $row["Website_of_company"]; ?>">
                </div>
                <div class="form-element">
                    <input type="email" class="form-control" name="TPO_Email" placeholder="TPO Email:" value="<?php echo $row["TPO_Email"]; ?>" readonly>
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="TPO_coordinator_name" placeholder="TPO Coordinator Name:" value="<?php echo $row["TPO_coordinator_name"]; ?>" required>
                </div>
                <div class="form-element">
                    <select name="Type_of_company" class="form-control" required>
                        <option value="">Select Type of Company</option>
                        <option value="IT" <?php if ($row["Type_of_company"] == "IT") echo "selected"; ?>>IT</option>
                        <option value="Core Engineering" <?php if ($row["Type_of_company"] == "Core Engineering") echo "selected"; ?>>Core Engineering</option>
                        <option value="Finance" <?php if ($row["Type_of_company"] == "Finance") echo "selected"; ?>>Finance</option>
                    </select>
                </div>
                <div class="form-element">
                    <select name="Type_of_interaction" class="form-control" required>
                        <option value="">Select Hiring Type</option>
                        <option value="Campus Drive" <?php if ($row["Type_of_interaction"] == "Campus Drive") echo "selected"; ?>>Campus Drive</option>
                        <option value="Virtual Drive" <?php if ($row["Type_of_interaction"] == "Virtual Drive") echo "selected"; ?>>Virtual Drive</option>
                        <option value="Internship" <?php if ($row["Type_of_interaction"] == "Internship") echo "selected"; ?>>Internship</option>
                    </select>
                </div>
                <div class="form-element">
        <label for="last_visited">Last Visited:</label>
        <input type="date" class="form-control" name="last_visited" id="last_visited" value="<?php echo $row["last_visited"]; ?>">
    </div>
            <?php } ?>
            <!-- Remark field for both admin and user -->
            <div class="form-element">
                <textarea class="form-control" name="remark" placeholder="Remark" rows="4" required><?php echo $row["remark"]; ?></textarea>
            </div>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <div class="form-element mt-3">
                <input type="submit" name="edit" value="Edit Company" class="btn btn-primary">
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