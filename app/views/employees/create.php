<?php include __DIR__ . '/../../includes/header.php'; ?>
<div class="container-fluid">
  <div class="row">

    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Add New Employee</h2>

      <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <form method="POST" action="employees.php?a=store">

        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="first_name" required
                 value="<?= htmlspecialchars($old['first_name'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="last_name" required
                 value="<?= htmlspecialchars($old['last_name'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" class="form-control" name="phone" required
                 value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Department</label>
          <input type="text" class="form-control" name="department" required
                 value="<?= htmlspecialchars($old['department'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Designation</label>
          <input type="text" class="form-control" name="designation" required
                 value="<?= htmlspecialchars($old['designation'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Joining</label>
          <input type="date" class="form-control" name="date_of_joining" required
                 value="<?= htmlspecialchars($old['date_of_joining'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Salary</label>
          <input type="number" step="0.01" class="form-control" name="salary" required
                 value="<?= htmlspecialchars($old['salary'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="1" <?= ($old['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= ($old['status'] ?? '') === '0' ? 'selected' : '' ?>>Inactive</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a href="employees.php?a=index" class="btn btn-secondary ms-2">Cancel</a>

      </form>
    </main>
  </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
