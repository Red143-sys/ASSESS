<?php
require 'db.php';
require 'patial/head.php';

$id = $_GET['id'] ?? 0;

// Fetch student
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) die("Student not found");

$error = "";

if (isset($_POST['update'])) {
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
        $stmt = $pdo->prepare("UPDATE students SET idno=?, name=?, month=?, day=?, year=?, yearLevel=?, section=?, sex=? WHERE id=?");
        $stmt->execute([$idno, $name, $month, $day, $year, $yearLevel, $section, $sex, $id]);
        header("Location: index.php");
        exit;
    }
}

?>

<h2 class="mb-4">Update Student</h2>
<a href="index.php" class="btn btn-primary mb-3">Back to List</a>

<div class="card">
    <div class="card-body">
        <?php
        $action = "Update";
        $submitName = "update";
        require 'patial/student_form.php';
        ?>
    </div>
</div>

<?php require 'patial/foot.php'; ?>
