<?php

session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
        exit(); // It's a good practice to call exit after a header redirect
    }
} else {
    header("location: ../login.php");
    exit(); // It's a good practice to call exit after a header redirect
}

if ($_POST) {
    // Import database
    include("../connection.php");

    // Escape the input values to prevent SQL injection
    $title = mysqli_real_escape_string($database, $_POST["title"]);
    $docid = mysqli_real_escape_string($database, $_POST["docid"]);
    $nop = mysqli_real_escape_string($database, $_POST["nop"]);
    $date = mysqli_real_escape_string($database, $_POST["date"]);
    $time = mysqli_real_escape_string($database, $_POST["time"]);

    // Construct the SQL query
    $sql = "INSERT INTO schedule (docid, title, scheduledate, scheduletime, nop) VALUES ('$docid', '$title', '$date', '$time', '$nop')";

    // Execute the query
    if ($database->query($sql) === TRUE) {
        header("location: schedule.php?action=session-added&title=$title");
        exit(); // It's a good practice to call exit after a header redirect
    } else {
        echo "Error: " . $sql . "<br>" . $database->error; // Display error if query fails
    }
}

?>
