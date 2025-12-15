<?php
/* 
=======================================================================
 PHPPayroll — Open Source HR & Payroll Management Software
 Version: 3.0
 License: MIT Open Source License
 Developed & Maintained By: PHPPayroll (https://www.phppayroll.com)
 
 Description:
 PHPPayroll is a Payroll and Human Resource Management platform
 available in two deployment models: PHPPayroll Open-Source, a free,
 self-hosted edition for essential HR and payroll operations, and
 PHPPayroll Cloud, a fully managed, enterprise-grade payroll system.
 PHPPayroll is designed to help organizations manage Employees,
 Attendance, Leaves, Payroll, and core HR workflows with simplicity,
 security, and speed.

 Core Modules Included (Open-Source Edition):
 - Employee Management
 - Attendance Tracking
 - Leave Management
 - Payroll Management
 - HR Dashboard
 - Secure Login

 This software is open for modification and extension.
 You are free to customize, improve, and commercially use the
 Open-Source edition without licensing fees, provided this
 copyright notice remains preserved.

 Website:
 https://www.phppayroll.com

 Live Demo:
 https://www.phppayroll.com/demo/

 Download:
 https://www.phppayroll.com/download/

 Community Contribution:
 Developers are welcome to contribute improvements, bug fixes,
 and enhancements to the Open-Source edition. Please visit our
 website for documentation, updates, and community support.

 Last Update: 14-12-2025
=======================================================================
*/

	
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Employee.php';

class AttendanceController extends Controller
{
    protected $attendance;
    protected $employee;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->attendance = new Attendance($conn);
        $this->employee   = new Employee($conn);

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    // =========================
    // LIST
    // =========================
    public function index()
    {
        $records = $this->attendance->all();

        $successMsg = $_SESSION['attendance_success'] ?? '';
        $errorMsg   = $_SESSION['attendance_error'] ?? '';
        unset($_SESSION['attendance_success'], $_SESSION['attendance_error']);

        $this->view('attendance/index', [
            'records'    => $records,
            'successMsg' => $successMsg,
            'errorMsg'   => $errorMsg
        ]);
    }

    // =========================
    // CREATE FORM (EMP DROPDOWN)
    // =========================
    public function create()
    {
        $errorMsg = $_SESSION['add_attendance_error'] ?? '';
        unset($_SESSION['add_attendance_error']);

        // 🔥 active employees for dropdown
        $employees = $this->employee->allActive();

        $this->view('attendance/create', [
            'errorMsg'  => $errorMsg,
            'employees' => $employees
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('attendance.php?a=create');
        }

        $data = [
            'employee_id'     => (int)($_POST['employee_id'] ?? 0),
            'attendance_date' => $_POST['attendance_date'] ?? '',
            'check_in'        => $_POST['check_in'] ?: null,
            'check_out'       => $_POST['check_out'] ?: null,
            'status'          => $_POST['status'] ?? 'present'
        ];

        if (!$data['employee_id'] || !$data['attendance_date']) {
            $_SESSION['add_attendance_error'] = 'Employee and Date are required.';
            return $this->redirect('attendance.php?a=create');
        }

        if ($this->attendance->create($data)) {
            $_SESSION['attendance_success'] = 'Attendance added successfully.';
            return $this->redirect('attendance.php?a=index');
        }

        $_SESSION['attendance_error'] = 'Error adding attendance.';
        return $this->redirect('attendance.php?a=index');
    }

    // =========================
    // EDIT FORM (EMP DROPDOWN)
    // =========================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) return $this->redirect('attendance.php?a=index');

        $attendance = $this->attendance->find($id);
        if (!$attendance) return $this->redirect('attendance.php?a=index');

        // 🔥 active employees for dropdown
        $employees = $this->employee->allActive();

        $errorMsg   = $_SESSION['edit_attendance_error'] ?? '';
        $successMsg = $_SESSION['edit_attendance_success'] ?? '';
        unset($_SESSION['edit_attendance_error'], $_SESSION['edit_attendance_success']);

        $this->view('attendance/edit', [
            'attendance' => $attendance,
            'employees'  => $employees,
            'errorMsg'   => $errorMsg,
            'successMsg' => $successMsg
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('attendance.php?a=index');
        }

        $id = $_POST['id'] ?? 0;
        if (!$id) return $this->redirect('attendance.php?a=index');

        $data = [
            'employee_id'     => (int)$_POST['employee_id'],
            'attendance_date' => $_POST['attendance_date'],
            'check_in'        => $_POST['check_in'] ?: null,
            'check_out'       => $_POST['check_out'] ?: null,
            'status'          => $_POST['status']
        ];

        if ($this->attendance->update($id, $data)) {
            $_SESSION['edit_attendance_success'] = 'Attendance updated successfully.';
        } else {
            $_SESSION['edit_attendance_error'] = 'Error updating attendance.';
        }

        return $this->redirect('attendance.php?a=edit&id=' . $id);
    }

    // =========================
    // DELETE
    // =========================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if ($id && $this->attendance->delete($id)) {
            $_SESSION['attendance_success'] = 'Attendance deleted successfully.';
        } else {
            $_SESSION['attendance_error'] = 'Error deleting attendance.';
        }

        return $this->redirect('attendance.php?a=index');
    }
}
