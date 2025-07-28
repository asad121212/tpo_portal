<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

include('connect.php');

// Determine the view type
$view = isset($_GET['view']) ? $_GET['view'] : 'own';
$user_email = $_SESSION["email"];
$user_role = $_SESSION["role"];

// Fetch data based on the view
if ($view === 'all' && $user_role === 'admin') {
    $sqlSelect = "SELECT * FROM books"; // Admin can download all records
} else {
    $sqlSelect = "SELECT * FROM books WHERE TPO_email = '$user_email'"; // Regular user downloads their records
}

$result = mysqli_query($conn, $sqlSelect);

// Set headers for Excel file
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=data_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Output headers for the Excel file
echo "ID\tName of Company\tContact Person Name\tContact Person E-mail\tContact Person Phone\tLocation of Company\tWebsite of Company\tTPO E-mail\tTPO Coordinator Name\tType of Company\tType of Interaction\tLast Visited\tRemark\tLast Modified\n";

// Output data
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['id'] . "\t" .
         $row['Name_of_Company'] . "\t" .
         $row['Contact_person_name'] . "\t" .
         $row['Contact_person_email'] . "\t" .
         $row['Contact_person_phone'] . "\t" .
         $row['Location_of_Company'] . "\t" .
         $row['Website_of_company'] . "\t" .
         $row['TPO_Email'] . "\t" .
         $row['TPO_coordinator_name'] . "\t" .
         $row['Type_of_company'] . "\t" .
         $row['Type_of_interaction'] . "\t" .
         ($row['last_visited'] ? $row['last_visited'] : "Not yet visited") . "\t" .
         ($row['remark'] ? $row['remark'] : "No remark") . "\t" .
         ($row['last_modified'] ? $row['last_modified'] : "Not yet modified") . "\n";
}
exit;
?>