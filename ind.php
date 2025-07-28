<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company List</title>

    <!-- Google Fonts: Anton and IBM Plex Serif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=IBM+Plex+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
    background: url('5968949.jpg') repeat center center;
    background-size: cover;
    background-attachment: fixed;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}

        /* body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */

        /* Apply the Anton font to title, table headers, and buttons */
        .anton {
            font-family: "Anton", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        h1.anton {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        .table thead th {
            text-align: center;
            font-family:  sans-serif;
            font-size: 1.1rem;
            background-color: #343a40;
            color: white;
        }

        /* Apply the IBM Plex Serif font to table columns */
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 16px;
            font-family:  serif;
        }

        /* Styling for buttons */
        .btn {
            border-radius: 7px;
            font-family: "Anton", sans-serif;
            letter-spacing: 0.5px;
            padding: 6px 14px ;
            font-size: 0.9rem;
            transition: all 0.25s ease-in-out;
            color: white;
            border: none;
            
        }

        .btn-read {
            background-color: #487fa3;
            font-family:  sans-serif;
            font-weight : 50px;

        }

        .btn-read:hover {
            background-color:rgb(135, 173, 198);
        }

        .btn-edit {
            background-color:rgb(196, 207, 153);
            font-family:  sans-serif;
        }

        .btn-edit:hover {
            background-color: #d1c24a;
            
        }

        .btn-delete {
            background-color:rgb(231, 85, 72);
            
            font-family:  sans-serif;
        }

        .btn-delete:hover {
            background-color:rgb(244, 3, 3);
            color: black;
        }

        .btn-primary {
            background-color: #d8d1a7;
            color: black;
        }

        .btn-primary:hover {
            background-color: #c9bd8e;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
            text-align: center;
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .logout-btn a {
            font-weight: 500;
        }
        footer {
    background: #2d3748;
    color: #e2e8f0;
    text-align: center;
    padding: 15px 10px;
    font-size: 14px;
    margin-top: auto; /* Ensures footer stays at the bottom */
    position: sticky;
    bottom: 0;
    width: 100%;
}
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="logout-btn position-absolute top-0 start-0 m-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <header>
            <!-- <h1 class="anton">SSIPMT</h1> -->
            <h1 class="anton"> DEPARTMENT OF TRANING AND PLACEMENT</h1>
        </header>

        <div class="d-flex justify-content-end mb-3">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="create.php">Add New Company</a></li>
                    <li><a class="dropdown-item" href="export_excel.php?view=own">Download My Data</a></li>
                    <?php if ($_SESSION["role"] === "admin") { ?>
                        <li><a class="dropdown-item" href="export_excel.php?view=all">Download All Data</a></li>
                        <li><a class="dropdown-item" href="admin_approve.php">User Approval</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <?php if (isset($_SESSION["create"])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION["create"]; ?></div>
            <?php unset($_SESSION["create"]); } ?>

        <?php if (isset($_SESSION["update"])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION["update"]; ?></div>
            <?php unset($_SESSION["update"]); } ?>

        <?php if (isset($_SESSION["delete"])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION["delete"]; ?></div>
            <?php unset($_SESSION["delete"]); } ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name of Company</th>
                    <th>Type of Company</th>
                    <th>Hiring Type</th>
                     <th>Contact Person</th>
                    <th>Email</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                include('connect.php');
                $user_email = $_SESSION["email"];
                $user_role = $_SESSION["role"];

                $sqlSelect = $user_role === 'admin' 
                    ? "SELECT * FROM books" 
                    : "SELECT * FROM books WHERE TPO_email = '$user_email'";

                $result = mysqli_query($conn, $sqlSelect);
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $data['Name_of_Company']; ?></td>
                        <td><?php echo $data['Type_of_company']; ?></td>
                        <td><?php echo $data['Type_of_interaction']; ?></td>
                        <td><?php echo $data['Contact_person_name']; ?></td>
                        <td><?php echo $data['Contact_person_email']; ?></td>
                        <td>
                            <a href="view.php?id=<?php echo $data['id']; ?>" class="btn btn-read btn-sm">Read</a>
                            <?php if ($_SESSION["role"] === "admin") { ?>
                                <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-edit btn-sm">Edit</a>
                                <a href="delete.php?id=<?php echo $data['id']; ?>" 
           class="btn btn-delete btn-sm" 
           onclick="return confirm('Are you sure you want to delete this record?');">
           Delete
        </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<footer>
    Old Dhamtari Road, P.O. Sejbahar, Mujgahan, Raipur, Chhattisgarh,<br>
    Pin Code - 492015<br>
    Reception: 0771-3501600 / 0771-3501601
</footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>