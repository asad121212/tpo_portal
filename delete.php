<?php
if (isset($_GET['id'])) {
include("connect.php");
$id = $_GET['id'];
$sql = "DELETE FROM books WHERE id='$id'";
if(mysqli_query($conn,$sql)){
    session_start();
    $_SESSION["delete"] = "Company Deleted Successfully!";
    header("Location:ind.php");
}else{
    die("Something went wrong");
}
}else{
    echo "Company does not exist";
}
?>