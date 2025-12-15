<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="m-0">Leave Requests</h2>
        <a href="leaves.php?a=create" class="btn btn-primary">Add Leave</a>
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
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($records as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['employee_code'].' - '.$row['first_name'] ?></td>
              <td><?= ucfirst($row['leave_type']) ?></td>
              <td><?= $row['start_date'] ?></td>
              <td><?= $row['end_date'] ?></td>
              <td>
                <span class="badge bg-info"><?= ucfirst($row['status']) ?></span>
              </td>
              <td>
                <a href="leaves.php?a=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="leaves.php?a=delete&id=<?= $row['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete leave request?')">
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
