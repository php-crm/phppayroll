<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">

    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">
      <h2 class="mb-4">Edit Attendance</h2>

      <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
      <?php endif; ?>

      <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
      <?php endif; ?>

      <form method="POST" action="attendance.php?a=update">
        <input type="hidden" name="id" value="<?= $attendance['id'] ?>">

        <div class="mb-3">
          <label class="form-label">Employee ID</label>
          <select name="employee_id" class="form-select" required>
  <?php foreach ($employees as $emp): ?>
    <option value="<?= $emp['id'] ?>"
      <?= $emp['id'] == $attendance['employee_id'] ? 'selected' : '' ?>>
      <?= $emp['employee_code'] ?> - <?= $emp['first_name'] ?> <?= $emp['last_name'] ?>
    </option>
  <?php endforeach; ?>
</select>

        </div>

        <div class="mb-3">
          <label class="form-label">Attendance Date</label>
          <input type="date" name="attendance_date" class="form-control" required
                 value="<?= htmlspecialchars($attendance['attendance_date']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Check In</label>
          <input type="time" name="check_in" class="form-control"
                 value="<?= htmlspecialchars($attendance['check_in']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Check Out</label>
          <input type="time" name="check_out" class="form-control"
                 value="<?= htmlspecialchars($attendance['check_out']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="present"  <?= $attendance['status']=='present'?'selected':'' ?>>Present</option>
            <option value="absent"   <?= $attendance['status']=='absent'?'selected':'' ?>>Absent</option>
            <option value="late"     <?= $attendance['status']=='late'?'selected':'' ?>>Late</option>
            <option value="half_day" <?= $attendance['status']=='half_day'?'selected':'' ?>>Half Day</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="attendance.php?a=index" class="btn btn-secondary ms-2">Cancel</a>
      </form>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
