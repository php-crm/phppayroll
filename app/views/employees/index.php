<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">

    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="m-0">Employees List</h2>
        <a href="employees.php?a=create" class="btn btn-primary">Add New Employee</a>
      </div>

      <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Employee Code</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Department</th>
              <th>Designation</th>
              <th>Salary</th>
              <th>Status</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($employees) > 0): ?>
              <?php foreach ($employees as $emp): ?>
                <tr>
                  <td><?= $emp['id'] ?></td>
                  <td><?= htmlspecialchars($emp['employee_code']) ?></td>
                  <td><?= htmlspecialchars($emp['first_name'].' '.$emp['last_name']) ?></td>
                  <td><?= htmlspecialchars($emp['phone']) ?></td>
                  <td><?= htmlspecialchars($emp['department'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($emp['designation']) ?></td>
                  <td><?= number_format($emp['salary'], 2) ?></td>
                  <td>
                    <span class="badge bg-<?= $emp['status'] ? 'success' : 'danger' ?>">
                      <?= $emp['status'] ? 'Active' : 'Inactive' ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($emp['date_of_joining']) ?></td>
                  <td>
                    <a href="employees.php?a=edit&id=<?= $emp['id'] ?>"
                       class="btn btn-sm btn-primary">Edit</a>
                    <a href="employees.php?a=delete&id=<?= $emp['id'] ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this employee?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center">No employees found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
