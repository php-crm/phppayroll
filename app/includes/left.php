<nav class="col-md-2 sidebar">
  <ul class="nav flex-column">

    <li class="nav-item mb-2">
      <a href="dashboard.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
         Dashboard
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="employees.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'employees.php' ? 'active' : '' ?>">
         Employees
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="attendance.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'attendance.php' ? 'active' : '' ?>">
         Attendance
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="leaves.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'leaves.php' ? 'active' : '' ?>">
         Leave Management
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="payroll.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'payroll.php' ? 'active' : '' ?>">
         Payroll
      </a>
    </li>






    <li class="nav-item mb-2">
      <a href="change_password.php"
         class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'change_password.php' ? 'active' : '' ?>">
         Change Password
      </a>
    </li>

    <li class="nav-item mb-2">
      <a href="index.php?a=logout" class="nav-link text-danger">
         Logout
      </a>
    </li>

  </ul>
</nav>
