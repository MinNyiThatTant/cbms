<?php
$servername = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "cbms";

$database = new mysqli($servername, $username, $password, $dbname);

if ($database->connect_error) {
    die("If login fail  : " . $database->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $targetDir = "../uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowedTypes) && $_FILES["profile_image"]["size"] < 2 * 1024 * 1024) {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
            // Update DB with new image path
            $stmt = $database->prepare("UPDATE patient SET profile_img=? WHERE pemail=?");
            $stmt->bind_param("ss", $targetFile, $useremail);
            $stmt->execute();
            // Reload to show new image
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type or size.');</script>";
    }
}
