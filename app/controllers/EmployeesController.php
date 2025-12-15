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
require_once __DIR__ . '/../models/Employee.php';

class EmployeesController extends Controller
{
    protected $employee;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->employee = new Employee($conn);

        // Simple auth check
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    // =========================
    // LIST EMPLOYEES
    // =========================
    public function index()
    {
        $employees = $this->employee->all();

        $successMsg = $_SESSION['employee_success'] ?? '';
        $errorMsg   = $_SESSION['employee_error'] ?? '';
        unset($_SESSION['employee_success'], $_SESSION['employee_error']);

        $this->view('employees/index', [
            'employees'  => $employees,
            'successMsg' => $successMsg,
            'errorMsg'   => $errorMsg
        ]);
    }

    // =========================
    // SHOW CREATE FORM
    // =========================
    public function create()
    {
        $errorMsg   = $_SESSION['add_employee_error'] ?? '';
        $successMsg = $_SESSION['add_employee_success'] ?? '';
        $old        = $_SESSION['add_employee_old'] ?? [];

        unset(
            $_SESSION['add_employee_error'],
            $_SESSION['add_employee_success'],
            $_SESSION['add_employee_old']
        );

        $this->view('employees/create', [
            'errorMsg'   => $errorMsg,
            'successMsg' => $successMsg,
            'old'        => $old
        ]);
    }

    // =========================
    // STORE EMPLOYEE
    // =========================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('employees.php?a=create');
        }

        $data = [
            'user_id'         => $_SESSION['user_id'],
            'employee_code'   => 'EMP-' . rand(1000, 9999),
            'first_name'      => trim($_POST['first_name'] ?? ''),
            'last_name'       => trim($_POST['last_name'] ?? ''),
            'phone'           => trim($_POST['phone'] ?? ''),
            'department'   => trim($_POST['department'] ?? ''),
            'designation'     => trim($_POST['designation'] ?? ''),
            'date_of_joining' => $_POST['date_of_joining'] ?? '',
            'salary'          => $_POST['salary'] ?? 0,
            'status'          => (int)($_POST['status'] ?? 1),
        ];

        $_SESSION['add_employee_old'] = $data;

        if (!$data['first_name'] || !$data['last_name']) {
            $_SESSION['add_employee_error'] = 'First & Last name are required.';
            return $this->redirect('employees.php?a=create');
        }

        if ($this->employee->create($data)) {
            $_SESSION['add_employee_success'] = 'Employee added successfully.';
            $_SESSION['add_employee_old'] = [];
            return $this->redirect('employees.php?a=create');
        }

        $_SESSION['add_employee_error'] = 'Error adding employee.';
        return $this->redirect('employees.php?a=create');
    }

    // =========================
    // SHOW EDIT FORM
    // =========================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) {
            return $this->redirect('employees.php?a=index');
        }

        $employee = $this->employee->find($id);
        if (!$employee) {
            return $this->redirect('employees.php?a=index');
        }

        $errorMsg   = $_SESSION['edit_employee_error'] ?? '';
        $successMsg = $_SESSION['edit_employee_success'] ?? '';
        unset($_SESSION['edit_employee_error'], $_SESSION['edit_employee_success']);

        $this->view('employees/edit', [
            'employee'   => $employee,
            'errorMsg'   => $errorMsg,
            'successMsg' => $successMsg
        ]);
    }

    // =========================
    // UPDATE EMPLOYEE
    // =========================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('employees.php?a=index');
        }

        $id = $_POST['id'] ?? 0;
        if (!$id) {
            return $this->redirect('employees.php?a=index');
        }

        $data = [
            'first_name'      => trim($_POST['first_name'] ?? ''),
            'last_name'       => trim($_POST['last_name'] ?? ''),
            'phone'           => trim($_POST['phone'] ?? ''),
            'department'   => trim($_POST['department'] ?? ''),
            'designation'     => trim($_POST['designation'] ?? ''),
            'date_of_joining' => $_POST['date_of_joining'] ?? '',
            'salary'          => $_POST['salary'] ?? 0,
            'status'          => (int)($_POST['status'] ?? 1),
        ];

        if (!$data['first_name'] || !$data['last_name']) {
            $_SESSION['edit_employee_error'] = 'First & Last name are required.';
            return $this->redirect('employees.php?a=edit&id=' . $id);
        }

        if ($this->employee->update($id, $data)) {
            $_SESSION['edit_employee_success'] = 'Employee updated successfully.';
        } else {
            $_SESSION['edit_employee_error'] = 'Error updating employee.';
        }

        return $this->redirect('employees.php?a=edit&id=' . $id);
    }

    // =========================
    // DELETE EMPLOYEE
    // =========================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if ($id && $this->employee->delete($id)) {
            $_SESSION['employee_success'] = 'Employee deleted successfully.';
        } else {
            $_SESSION['employee_error'] = 'Error deleting employee.';
        }

        return $this->redirect('employees.php?a=index');
    }
}
