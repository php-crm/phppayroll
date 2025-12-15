<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="m-0">Payroll</h2>
        <a href="payroll.php?a=create" class="btn btn-primary">Generate Payroll</a>
      </div>

      <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <table class="table table-bordered table-striped">
        <thead class="table-primary">
          <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Month</th>
            <th>Basic</th>
            <th>Allowances</th>
            <th>Deductions</th>
            <th>Net Salary</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($records as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['employee_code'].' - '.$row['first_name'] ?></td>
              <td><?= $row['salary_month'] ?></td>
              <td><?= number_format($row['basic_salary'],2) ?></td>
              <td><?= number_format($row['allowances'],2) ?></td>
              <td><?= number_format($row['deductions'],2) ?></td>
              <td><strong><?= number_format($row['net_salary'],2) ?></strong></td>
              <td>
                <a href="payroll.php?a=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="payroll.php?a=delete&id=<?= $row['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete payroll?')">
                  Delete
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
