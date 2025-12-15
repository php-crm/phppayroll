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
require_once __DIR__ . '/../models/Payroll.php';
require_once __DIR__ . '/../models/Employee.php';

class PayrollController extends Controller
{
    protected $payroll;
    protected $employee;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->payroll  = new Payroll($conn);
        $this->employee = new Employee($conn);

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
        $records = $this->payroll->all();

        $successMsg = $_SESSION['payroll_success'] ?? '';
        $errorMsg   = $_SESSION['payroll_error'] ?? '';
        unset($_SESSION['payroll_success'], $_SESSION['payroll_error']);

        $this->view('payroll/index', [
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
        $errorMsg = $_SESSION['add_payroll_error'] ?? '';
        unset($_SESSION['add_payroll_error']);

        // fetch active employees
        $employees = $this->employee->allActive();

        $this->view('payroll/create', [
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
            return $this->redirect('payroll.php?a=create');
        }

        $basic      = (float)$_POST['basic_salary'];
        $allowances = (float)($_POST['allowances'] ?? 0);
        $deductions = (float)($_POST['deductions'] ?? 0);

        $data = [
            'employee_id'  => (int)$_POST['employee_id'],
            'salary_month' => $_POST['salary_month'],
            'basic_salary' => $basic,
            'allowances'   => $allowances,
            'deductions'   => $deductions,
            'net_salary'   => $basic + $allowances - $deductions
        ];

        if (!$data['employee_id'] || !$data['salary_month']) {
            $_SESSION['add_payroll_error'] = 'Employee and Salary Month required.';
            return $this->redirect('payroll.php?a=create');
        }

        if ($this->payroll->create($data)) {
            $_SESSION['payroll_success'] = 'Payroll generated successfully.';
            return $this->redirect('payroll.php?a=index');
        }

        $_SESSION['payroll_error'] = 'Error generating payroll.';
        return $this->redirect('payroll.php?a=index');
    }

    // =====================
    // EDIT FORM (EMP DROPDOWN)
    // =====================
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id) return $this->redirect('payroll.php?a=index');

        $payroll = $this->payroll->find($id);
        if (!$payroll) return $this->redirect('payroll.php?a=index');

        $employees = $this->employee->allActive();

        $errorMsg   = $_SESSION['edit_payroll_error'] ?? '';
        $successMsg = $_SESSION['edit_payroll_success'] ?? '';
        unset($_SESSION['edit_payroll_error'], $_SESSION['edit_payroll_success']);

        $this->view('payroll/edit', [
            'payroll'    => $payroll,
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
            return $this->redirect('payroll.php?a=index');
        }

        $id = $_POST['id'] ?? 0;
        if (!$id) return $this->redirect('payroll.php?a=index');

        $basic      = (float)$_POST['basic_salary'];
        $allowances = (float)($_POST['allowances'] ?? 0);
        $deductions = (float)($_POST['deductions'] ?? 0);

        $data = [
            'employee_id'  => (int)$_POST['employee_id'],
            'salary_month' => $_POST['salary_month'],
            'basic_salary' => $basic,
            'allowances'   => $allowances,
            'deductions'   => $deductions,
            'net_salary'   => $basic + $allowances - $deductions
        ];

        if ($this->payroll->update($id, $data)) {
            $_SESSION['edit_payroll_success'] = 'Payroll updated successfully.';
        } else {
            $_SESSION['edit_payroll_error'] = 'Error updating payroll.';
        }

        return $this->redirect('payroll.php?a=edit&id=' . $id);
    }

    // =====================
    // DELETE
    // =====================
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        if ($id && $this->payroll->delete($id)) {
            $_SESSION['payroll_success'] = 'Payroll deleted successfully.';
        } else {
            $_SESSION['payroll_error'] = 'Error deleting payroll.';
        }

        return $this->redirect('payroll.php?a=index');
    }
}
