<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Edit Payroll</h2>

      <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <form method="POST" action="payroll.php?a=update">
        <input type="hidden" name="id" value="<?= $payroll['id'] ?>">

        <div class="mb-3">
          <label class="form-label">Employee ID</label>
          <select name="employee_id" class="form-select" required>
  <?php foreach ($employees as $emp): ?>
    <option value="<?= $emp['id'] ?>"
      <?= $emp['id'] == $payroll['employee_id'] ? 'selected' : '' ?>>
      <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?> <?= $emp['last_name'] ?>
    </option>
  <?php endforeach; ?>
</select>

        </div>

        <div class="mb-3">
          <label class="form-label">Salary Month</label>
          <input type="month" name="salary_month" class="form-control"
                 value="<?= $payroll['salary_month'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Basic Salary</label>
          <input type="number" step="0.01" name="basic_salary" class="form-control"
                 value="<?= $payroll['basic_salary'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Allowances</label>
          <input type="number" step="0.01" name="allowances" class="form-control"
                 value="<?= $payroll['allowances'] ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Deductions</label>
          <input type="number" step="0.01" name="deductions" class="form-control"
                 value="<?= $payroll['deductions'] ?>">
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="payroll.php?a=index" class="btn btn-secondary ms-2">Cancel</a>
      </form>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
