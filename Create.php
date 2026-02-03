<?php
require 'db.php';
require 'patial/head.php';

$error = "";

if (isset($_POST['save'])) {
    $idno = trim($_POST['idno']);
    $name = trim($_POST['name']);
    $month = trim($_POST['month']);
    $day = trim($_POST['day']);
    $year = trim($_POST['year']);
    $yearLevel = trim($_POST['yearLevel']);
    $section = trim($_POST['section']);
    $sex = trim($_POST['sex']);

    if (empty($idno) || empty($name) || empty($month) || empty($day) || empty($year) || empty($yearLevel) || empty($section) || empty($sex)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (idno, name, month, day, year, yearLevel, section, sex) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$idno, $name, $month, $day, $year, $yearLevel, $section, $sex]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Student ID already exists.";
        }
    }
}

// Empty student array for new record
$student = [];

?>

<h2 class="mb-4">Add Student</h2>
<a href="index.php" class="btn btn-primary mb-3">Back to List</a>

<div class="card">
    <div class="card-body">
        <?php
        $action = "Save";
        $submitName = "save";
        require 'patial/student_form.php';
        ?>
    </div>
</div>

<?php require 'patial/foot.php'; ?>
