<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Edit Leave</h2>

      <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <form method="POST" action="leaves.php?a=update">
        <input type="hidden" name="id" value="<?= $leave['id'] ?>">

<div class="mb-3">
  <label class="form-label">Employee</label>
  <select name="employee_id" class="form-select" required>
    <?php foreach ($employees as $emp): ?>
      <option value="<?= $emp['id'] ?>"
        <?= $emp['id'] == $leave['employee_id'] ? 'selected' : '' ?>>
        <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?> <?= $emp['last_name'] ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>


        <div class="mb-3">
          <label class="form-label">Leave Type</label>
          <select name="leave_type" class="form-select">
            <option value="casual" <?= $leave['leave_type']=='casual'?'selected':'' ?>>Casual</option>
            <option value="sick" <?= $leave['leave_type']=='sick'?'selected':'' ?>>Sick</option>
            <option value="paid" <?= $leave['leave_type']=='paid'?'selected':'' ?>>Paid</option>
            <option value="unpaid" <?= $leave['leave_type']=='unpaid'?'selected':'' ?>>Unpaid</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Start Date</label>
          <input type="date" name="start_date" class="form-control"
                 value="<?= $leave['start_date'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">End Date</label>
          <input type="date" name="end_date" class="form-control"
                 value="<?= $leave['end_date'] ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Reason</label>
          <textarea name="reason" class="form-control"><?= $leave['reason'] ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="pending" <?= $leave['status']=='pending'?'selected':'' ?>>Pending</option>
            <option value="approved" <?= $leave['status']=='approved'?'selected':'' ?>>Approved</option>
            <option value="rejected" <?= $leave['status']=='rejected'?'selected':'' ?>>Rejected</option>
          </select>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="leaves.php?a=index" class="btn btn-secondary ms-2">Cancel</a>
      </form>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
