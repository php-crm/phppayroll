<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">

    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">

      <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="m-0">Dashboard</h2>
      </div>

      <!-- HR STATS -->
      <div class="row mb-4">

        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-muted">Total Employees</h6>
              <h3><?= (int)($totalEmployees ?? 0) ?></h3>
              <a href="employees.php" class="small">View employees</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-muted">Active Employees</h6>
              <h3><?= (int)($activeEmployees ?? 0) ?></h3>
              <a href="employees.php" class="small">View active</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-muted">Today's Attendance</h6>
              <h3><?= (int)($todayAttendance ?? 0) ?></h3>
              <a href="attendance.php" class="small">View attendance</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-muted">Pending Leave Requests</h6>
              <h3><?= (int)($pendingLeaves ?? 0) ?></h3>
              <a href="leaves.php" class="small">View leaves</a>
            </div>
          </div>
        </div>

      </div>

      <!-- QUICK LINKS -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              Quick Actions
            </div>
            <div class="card-body">
              <a href="employees.php?a=create" class="btn btn-primary me-2 mb-2">Add Employee</a>
              <a href="attendance.php?a=create" class="btn btn-success me-2 mb-2">Mark Attendance</a>
              <a href="leaves.php?a=create" class="btn btn-warning me-2 mb-2">Add Leave</a>
              <a href="payroll.php?a=create" class="btn btn-info mb-2">Generate Payroll</a>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
