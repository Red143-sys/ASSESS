<?php
require 'db.php';
require 'patial/head.php';

// Search & pagination
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Fetch students
$stmt = $pdo->prepare(
    "SELECT * FROM students 
     WHERE name LIKE ? OR idno LIKE ? 
     ORDER BY id DESC 
     LIMIT $limit OFFSET $offset"
);
$stmt->execute(["%$search%", "%$search%"]);
$students = $stmt->fetchAll();

// Total pages
$total = $pdo->prepare(
    "SELECT COUNT(*) FROM students WHERE name LIKE ? OR idno LIKE ?"
);
$total->execute(["%$search%", "%$search%"]);
$total_pages = ceil($total->fetchColumn() / $limit);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Students List</h2>
    <a href="create.php" class="btn btn-success">Add Student</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name or ID Number" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
</form>

<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>ID Number</th>
            <th>Name</th>
            <th>Date</th>
            <th>Year Level</th>
            <th>Section</th>
            <th>Sex</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($students): ?>
        <?php $counter = ($page - 1) * $limit; ?>
        <?php foreach ($students as $student): ?>
            <?php $counter++; $date = "{$student['month']}/{$student['day']}/{$student['year']}"; ?>
            <tr>
                <td><?= $counter ?></td>
                <td><?= htmlspecialchars($student['idno']) ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= $date ?></td>
                <td><?= htmlspecialchars($student['yearLevel']) ?></td>
                <td><?= htmlspecialchars($student['section']) ?></td>
                <td><?= htmlspecialchars($student['sex']) ?></td>
                <td>
                
                    <a href="update.php?id=<?= $student['id'] ?>" class="btn btn-warning btn-sm">Update</a>
                    <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" class="text-center">No students found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php require 'patial/foot.php'; ?>
