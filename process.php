<?php
include('connect.php');

if (isset($_POST["create"])) {
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

    $sqlInsert = "INSERT INTO books (Name_of_Company, Contact_person_name, Contact_person_email, Contact_person_phone, Location_of_Company, Website_of_company, TPO_Email, TPO_coordinator_name, Type_of_company, Type_of_interaction,remark, last_visited) 
                  VALUES ('$name', '$contact_person', '$email', '$phone', '$location', '$website', '$TPO_Email', '$TPO_coordinator_name', '$Type_of_company', '$Type_of_interaction', '$remark', '$last_visited')";
    if (mysqli_query($conn, $sqlInsert)) {
        session_start();
        $_SESSION["create"] = "Company Added Successfully!";
        header("Location:ind.php");
    } else {
        die("Something went wrong");
    }
}