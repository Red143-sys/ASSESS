<?php
// $student = array with existing data or empty array
// $action = "Save" or "Update"
// $submitName = name of the submit button
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">ID Number</label>
            <input type="text" name="idno" class="form-control" required
                   value="<?= htmlspecialchars($student['idno'] ?? '') ?>">
        </div>
        <div class="col">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required
                   value="<?= htmlspecialchars($student['name'] ?? '') ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Date - birthdate</label>
            <input type="date" name="birthdte" class="form-control" min="1" max="12" required
                   value="<?= htmlspecialchars($student['birthdate'] ?? '') ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Year Level</label>
            <input type="text" name="yearLevel" class="form-control" required
                   value="<?= htmlspecialchars($student['yearLevel'] ?? '') ?>">
        </div>
        <div class="col">
            <label class="form-label">Section</label>
            <input type="text" name="section" class="form-control" required
                   value="<?= htmlspecialchars($student['section'] ?? '') ?>">
        </div>
        <div class="col">
            <label class="form-label">Sex</label>
            <select name="sex" class="form-select" required>
                <option value="" disabled <?= empty($student['sex']) ? 'selected' : '' ?>>Select</option>
                <option value="Male" <?= (($student['sex'] ?? '') === 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= (($student['sex'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
            </select>
        </div>
    </div>

    <button type="submit" name="<?= $submitName ?>" class="btn btn-<?= $action === 'Save' ? 'success' : 'warning' ?>">
        <?= $action ?> Student
    </button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
