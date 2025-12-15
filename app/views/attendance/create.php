<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Add Attendance</h2>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
      <?php endif; ?>

      <form method="POST" action="attendance.php?a=store">

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
          <label class="form-label">Date</label>
          <input type="date" name="attendance_date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Check In</label>
          <input type="time" name="check_in" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Check Out</label>
          <input type="time" name="check_out" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="present">Present</option>
            <option value="absent">Absent</option>
            <option value="late">Late</option>
            <option value="half_day">Half Day</option>
          </select>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="attendance.php?a=index" class="btn btn-secondary ms-2">Cancel</a>

      </form>
    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
