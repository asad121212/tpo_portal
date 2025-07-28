<!-- filepath: d:\php\htdocs\Login-register\view.php -->
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

date_default_timezone_set("Asia/Kolkata"); // Set your desired timezone
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Company Details</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }

        header a.btn-primary {
            background-color: rgb(0, 0, 0);
            border: none;
            padding: 12px 25px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        header a.btn-primary:hover {
            background-color: rgb(0, 0, 0);
            text-decoration: none;
            transform: scale(1.05);
        }

        /* Company Details Section */
        .book-details {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 30px;
            line-height: 1.8;
            transition: all 0.3s ease;
        }

        .book-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .book-details h3 {
            font-size: 18px;
            color: rgb(4, 113, 238);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .book-details p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            padding: 12px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .book-details p:hover {
            background-color: #f1f1f1;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Back Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            text-decoration: none;
            transform: scale(1.05);
        }

        /* Container Styling */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        /* No Company Found Styling */
        .no-company {
            text-align: center;
            font-size: 18px;
            color: #dc3545;
            margin-top: 20px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Company Details</h1>
            <div>
                <a href="ind.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <div class="book-details p-5 my-4">
            <?php
            include("connect.php");
            $id = $_GET['id'];
            if ($id) {
                $sql = "SELECT * FROM books WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <h3>Name of Company:</h3>
                    <p><?php echo $row["Name_of_Company"]; ?></p>
                    <h3>Contact Person Name:</h3>
                    <p><?php echo $row["Contact_person_name"]; ?></p>
                    <h3>Contact Person E-Mail:</h3>
                    <p><?php echo $row["Contact_person_email"]; ?></p>
                    <h3>Contact Person Phone:</h3>
                    <p><?php echo $row["Contact_person_phone"]; ?></p>
                    <h3>Location Of Company:</h3>
                    <p><?php echo $row["Location_of_Company"]; ?></p>
                    <h3>Website of Company:</h3>
                    <p><?php echo $row["Website_of_company"]; ?></p>
                    <h3>TPO E-Mail:</h3>
                    <p><?php echo $row["TPO_Email"]; ?></p>
                    <h3>TPO Coordinator Name:</h3>
                    <p><?php echo $row["TPO_coordinator_name"]; ?></p>
                    <h3>Type Of Company:</h3>
                    <p><?php echo $row["Type_of_company"]; ?></p>
                    <h3>Type Of Interaction:</h3>
<p><?php echo $row["Type_of_interaction"]; ?></p>

<h3>Last Visited:</h3>
<p>
    <?php 
    echo $row["last_visited"] 
        ? date("Y-m-d", strtotime($row["last_visited"])) 
        : "Not yet visited"; 
    ?>
</p>

<h3>Remark:</h3>
<p><?php echo $row["remark"]; ?></p>
<h3>Last Modified:</h3>
<p>
    <?php 
    echo $row["last_modified"] 
        ? date("Y-m-d", strtotime($row["last_modified"])) 
        : "Not yet modified"; 
    ?>
</p>
    


                    <?php
                    // Show the "Edit Remark" button only for non-admin users
                    if (isset($_SESSION["role"]) && $_SESSION["role"] !== "admin") { ?>
                        <a href="edit_remark.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit Remark</a>
                    <?php } ?>
            <?php
                }
            } else {
                echo "<h3 class='no-company'>No Company found</h3>";
            }
            ?>
        </div>
    </div>
</body>
</html>