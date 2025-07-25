<?php
session_start();
require_once 'db_connect.php';
// Check if patient is logged in
if (!isset($_SESSION['patient_loggedin']) || $_SESSION['patient_loggedin'] !== true) {
    header("Location: patient_login.php");
    exit;
}
$pid = $_SESSION['pid'];
$error = '';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feeling = trim($_POST['feeling']);
    $headache = trim($_POST['headache']);
    $fever = trim($_POST['fever']);
    $other_symptoms = trim($_POST['other_symptoms']);
    
    if (empty($feeling) || empty($headache) || empty($fever)) {
        $error = 'Please answer all required questions';
    } else {
        // Update patient record with questionnaire answers
        $stmt = $conn->prepare("UPDATE patient SET feeling=?, headache=?, fever=?, other_symptoms=? WHERE pid=?");
        $stmt->bind_param("ssssi", $feeling, $headache, $fever, $other_symptoms, $pid);
        
        if ($stmt->execute()) {
            header("Location: patient_dashboard.php?questionnaire=success");
            exit;
        } else {
            $error = 'Error saving your answers. Please try again.';
        }
    }
}
// Get patient info
$stmt = $conn->prepare("SELECT pname FROM patient WHERE pid = ?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Questionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .questionnaire-container {
            max-width: 800px;
            margin: 50px auto;
padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .question-box {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f0f8ff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container questionnaire-container">
        <h2 class="text-center mb-4">Medical Questionnaire</h2>
        <p class="text-center">Welcome, <?php echo htmlspecialchars($patient['pname']); ?></p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
<form action="medical_questionnaire.php" method="post">
            <div class="question-box">
                <div class="mb-3">
                    <label class="form-label"><strong>1. How are you feeling today?</strong></label>
                    <textarea class="form-control" name="feeling" rows="3" required placeholder="Describe how you feel today..."></textarea>
                </div>
            </div>
            
            <div class="question-box">
                <label class="form-label"><strong>2. Do you have a headache?</strong></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="headache" id="headache_yes" value="yes" required>
                    <label class="form-check-label" for="headache_yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="headache" id="headache_no" value="no">
                    <label class="form-check-label" for="headache_no">No</label>
                </div>
            </div>
<div class="question-box">
                <label class="form-label"><strong>3. Do you have a fever?</strong></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fever" id="fever_yes" value="yes" required>
                    <label class="form-check-label" for="fever_yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fever" id="fever_no" value="no">
                    <label class="form-check-label" for="fever_no">No</label>
                </div>
            </div>
            
            <div class="question-box">
                <div class="mb-3">
                    <label class="form-label"><strong>4. Other symptoms you're experiencing?</strong> (optional)</label>
                    <textarea class="form-control" name="other_symptoms" rows="3" placeholder="List any other symptoms..."></textarea>
                </div>
            </div>
<div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Submit Answers</button>
                <a href="patient_dashboard.php" class="btn btn-secondary btn-lg ms-3">Skip</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>            