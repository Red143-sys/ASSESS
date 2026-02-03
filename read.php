<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare(
    "SELECT * FROM users 
     WHERE name LIKE ? OR email LIKE ?
     ORDER BY id DESC
     LIMIT $limit OFFSET $offset"
);
$stmt->execute(["%$search%", "%$search%"]);
$users = $stmt->fetchAll();

$total = $pdo->prepare(
    "SELECT COUNT(*) FROM users WHERE name LIKE ? OR email LIKE ?"
);
$total->execute(["%$search%", "%$search%"]);
$total_pages = ceil($total->fetchColumn() / $limit);
?>
<form method="GET">
    <input type="text" name="search" placeholder="Search..." value="<?= $search ?>">
    <button>Search</button>
</form>

<table border="1">
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Action</th>
</tr>

<?php foreach ($users as $user): ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td><?= htmlspecialchars($user['name']) ?></td>
    <td><?= htmlspecialchars($user['email']) ?></td>
    <td>
        <a href="edit.php?id=<?= $user['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
<?php endfor; ?>

