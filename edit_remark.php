<!-- filepath: d:\php\htdocs\Login-register\edit_remark.php -->
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Fetch the existing remark and last_modified
    $sql = "SELECT remark, last_modified FROM books WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Record not found.";
        exit();
    }

    if (isset($_POST["update_remark"])) {
        $remark = mysqli_real_escape_string($conn, $_POST["remark"]);
        $last_modified = date("Y-m-d H:i:s");

        // Update the remark and last_modified columns
        $sqlUpdate = "UPDATE books SET remark = ?, last_modified = ? WHERE id = ?";
        $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ssi", $remark, $last_modified, $id);
        if (mysqli_stmt_execute($stmtUpdate)) {
            header("Location: view.php?id=$id");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Failed to update remark.</div>";
        }
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Remark</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Remark</h2>
        <form action="" method="post">
            <div class="form-group">
                <textarea name="remark" class="form-control" rows="4" required><?php echo htmlspecialchars($row["remark"]); ?></textarea>
            </div>
            <div class="form-btn mt-3">
                <input type="submit" name="update_remark" value="Update Remark" class="btn btn-primary">
            </div>
        </form>
        <div class="mt-3">
            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-secondary">&larr; Back</a>
        </div>
    </div>
</body>
</html>