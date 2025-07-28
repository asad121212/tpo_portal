<?php
session_start();
if ($_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

require_once "database.php";

// Approve user
if (isset($_GET["approve"])) {
    $user_id = $_GET["approve"];
    $sqlApprove = "UPDATE users SET approved = 1 WHERE id = $user_id";
    mysqli_query($conn, $sqlApprove);
    header("Location: admin_approve.php");
    exit();
}

// Fetch unapproved users
$sql = "SELECT * FROM users WHERE approved = 0";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Approval</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=IBM+Plex+Serif:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'IBM Plex Serif', serif;
        }

        h2 {
            font-family: "Anton", sans-serif;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }

        .btn-back {
            margin-bottom: 20px;
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            font-weight: 600;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            font-weight: 400;
            padding: 14px;
        }

        .approve-icon {
            font-size: 1.2rem;
            padding: 6px 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .approve-icon:hover {
            background-color: #eaf5e6;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="btn-back">
            <a href="ind.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
        </div>

        <h2>Pending User Approvals</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $user["id"]; ?></td>
                        <td><?php echo $user["email"]; ?></td>
                        <td><?php echo ucfirst($user["role"]); ?></td>
                        <td>
                            <a href="admin_approve.php?approve=<?php echo $user["id"]; ?>" class="approve-icon" title="Approve">
                                <i class="fas fa-check" style="color: #51b22e;"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
