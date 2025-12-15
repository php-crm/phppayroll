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
require_once __DIR__ . '/../models/Leave.php';

class LeaveController extends Controller
{
    protected $leave;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->leave = new LeaveModel($conn);

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    // =====================
    // LIST
    // =====================
    public function index()
    {
        $records = $this->leave->all();

        $successMsg = $_SESSION['leave_success'] ?? '';
        $errorMsg   = $_SESSION['leave_error'] ?? '';
        unset($_SESSION['leave_success'], $_SESSION['leave_error']);

        $this->view('leaves/index', [
            'records'    => $records,
            'successMsg' => $successMsg,
            'errorMsg'   => $errorMsg
        ]);
    }

    // =====================
    // CREATE FORM (EMP DROPDOWN)
    // =====================
    public function create()
    {
        $errorMsg = $_SESSION['add_leave_error'] ?? '';
        unset($_SESSION['add_leave_error']);

        // 🔥 employee dropdown data
        $employees = $this->leave->getActiveEmployees();

        $this->view('leaves/create', [
            'errorMsg'  => $errorMsg,
            'employees' => $employees
        ]);
    }

    // =====================
    // STORE
    // =====================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('leaves.php?a=create');
        }

        $data = [
            'employee_id' => (int)($_POST['employee_id'] ?? 0),
            'leave_type'  => $_POST['leave_type'] ?? '',
            'start_date'  => $_POST['start_date'] ?? '',
            'end_date'    => $_POST['end_date'] ?? '',
            'reason'      => $_POST['reason'] ?? '',
            'status'      => $_POST['status'] ?? 'pending'
        ];

        if (!$data['employee_id'] || !$data['start_date'] || !$data['end_date']) {
            $_SESSION['add_leave_error'] = 'Employee and dates are required.';
            return $this->redirect('leaves.php?a=create');
        }

        if ($this->leave->create($data)) {
            $_SESSION['leave_success'] = 'Leave applied successfully.';
            return $this->redirect('leaves.php?a=index');
        }

        $_SESSION['leave_error'] = 'Error applying leave.';
        return $this->redirect('leaves.php?a=index');
    }

    // =====================
    // EDIT FORM (EMP DROPDOWN)
    // =====================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) return $this->redirect('leaves.php?a=index');

        $leave = $this->leave->find($id);
        if (!$leave) return $this->redirect('leaves.php?a=index');

        // 🔥 employee dropdown data
        $employees = $this->leave->getActiveEmployees();

        $errorMsg   = $_SESSION['edit_leave_error'] ?? '';
        $successMsg = $_SESSION['edit_leave_success'] ?? '';
        unset($_SESSION['edit_leave_error'], $_SESSION['edit_leave_success']);

        $this->view('leaves/edit', [
            'leave'      => $leave,
            'employees'  => $employees,
            'errorMsg'   => $errorMsg,
            'successMsg' => $successMsg
        ]);
    }

    // =====================
    // UPDATE
    // =====================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('leaves.php?a=index');
        }

        $id = $_POST['id'] ?? 0;
        if (!$id) return $this->redirect('leaves.php?a=index');

        $data = [
            'employee_id' => (int)$_POST['employee_id'],
            'leave_type'  => $_POST['leave_type'],
            'start_date'  => $_POST['start_date'],
            'end_date'    => $_POST['end_date'],
            'reason'      => $_POST['reason'],
            'status'      => $_POST['status']
        ];

        if ($this->leave->update($id, $data)) {
            $_SESSION['edit_leave_success'] = 'Leave updated successfully.';
        } else {
            $_SESSION['edit_leave_error'] = 'Error updating leave.';
        }

        return $this->redirect('leaves.php?a=edit&id=' . $id);
    }

    // =====================
    // DELETE
    // =====================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if ($id && $this->leave->delete($id)) {
            $_SESSION['leave_success'] = 'Leave deleted successfully.';
        } else {
            $_SESSION['leave_error'] = 'Error deleting leave.';
        }

        return $this->redirect('leaves.php?a=index');
    }
}
