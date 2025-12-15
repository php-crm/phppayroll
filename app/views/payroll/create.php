<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Generate Payroll</h2>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <form method="POST" action="payroll.php?a=store">

<div class="mb-3">
  <label class="form-label">Employee</label>
  <select name="employee_id" class="form-select" required>
    <option value="">Select Employee</option>
    <?php foreach ($employees as $emp): ?>
      <option value="<?= $emp['id'] ?>">
        <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?> <?= $emp['last_name'] ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>


        <div class="mb-3">
          <label class="form-label">Salary Month</label>
          <input type="month" name="salary_month" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Basic Salary</label>
          <input type="number" step="0.01" name="basic_salary" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Allowances</label>
          <input type="number" step="0.01" name="allowances" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Deductions</label>
          <input type="number" step="0.01" name="deductions" class="form-control">
        </div>

        <button class="btn btn-primary">Generate</button>
        <a href="payroll.php?a=index" class="btn btn-secondary ms-2">Cancel</a>

      </form>
    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
