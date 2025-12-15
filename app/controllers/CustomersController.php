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

	
// app/controllers/CustomersController.php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Customer.php';

class CustomersController extends Controller
{
    protected $customer;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->customer = new Customer($conn);

        // Simple auth check
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    // List customers (GET)
    public function index()
    {
        $customers = $this->customer->all();
        // old view uses $users, so keep alias for backward compatibility
        $users = $customers;

        $successMsg = $_SESSION['customer_success'] ?? '';
        $errorMsg   = $_SESSION['customer_error'] ?? '';
        unset($_SESSION['customer_success'], $_SESSION['customer_error']);

        $this->view('customers/index', [
            'customers'  => $customers,
            'users'      => $users,
            'successMsg' => $successMsg,
            'errorMsg'   => $errorMsg,
        ]);
    }

    // Show add form (GET)
    public function create()
    {
        $errorMsg   = $_SESSION['add_customer_error']   ?? '';
        $successMsg = $_SESSION['add_customer_success'] ?? '';
        $old        = $_SESSION['add_customer_old']     ?? [];
        unset($_SESSION['add_customer_error'], $_SESSION['add_customer_success'], $_SESSION['add_customer_old']);

        $this->view('customers/create', [
            'errorMsg'   => $errorMsg,
            'successMsg' => $successMsg,
            'old'        => $old,
        ]);
    }

    // Handle form submit (POST)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customers.php?a=create');
        }

        $data = [
            'name'             => trim($_POST['name'] ?? ''),
            'email'            => trim($_POST['email'] ?? ''),
            'phone'            => trim($_POST['phone'] ?? ''),
            'company_name'     => trim($_POST['company_name'] ?? ''),
            'company_reg_no'   => trim($_POST['company_reg_no'] ?? ''),
            'company_address'  => trim($_POST['company_address'] ?? ''),
            'country'          => trim($_POST['country'] ?? ''),
            'role'             => trim($_POST['role'] ?? ''),
            'employees'        => trim($_POST['employees'] ?? ''),
            'user_status'      => trim($_POST['user_status'] ?? 'active'),
        ];

        $_SESSION['add_customer_old'] = $data;

        // Validation
        if (
            !$data['name'] || !$data['email'] ||
            !$data['phone'] || !$data['company_name'] ||
            !$data['company_reg_no'] || !$data['company_address'] || !$data['country'] ||
            !$data['role'] || !$data['employees']
        ) {
            $_SESSION['add_customer_error'] = 'Please fill in all required fields.';
            $this->redirect('customers.php?a=create');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['add_customer_error'] = 'Invalid email format.';
            $this->redirect('customers.php?a=create');
        }


        if ($this->customer->emailExists($data['email'])) {
            $_SESSION['add_customer_error'] = 'Email already exists.';
            $this->redirect('customers.php?a=create');
        }

        $insert = [
            'customer_code'  => 'CUST-' . str_pad((string)rand(1,9999), 4, '0', STR_PAD_LEFT),
            'name'           => $data['name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'company_name'   => $data['company_name'],
            'company_reg_no' => $data['company_reg_no'],
            'company_address'=> $data['company_address'],
            'country'        => $data['country'],
            'role'           => $data['role'],
            'employees'      => $data['employees'],
            'user_status'    => $data['user_status'],
        ];

        if ($this->customer->create($insert)) {
            $_SESSION['add_customer_success'] = 'Customer added successfully.';
            $_SESSION['add_customer_old'] = [];
            $this->redirect('customers.php?a=create');
        }

        $_SESSION['add_customer_error'] = 'Error inserting customer.';
        $this->redirect('customers.php?a=create');
    }
	
	
	
public function edit()
{
    $id = $_GET['id'] ?? 0;
    if (!$id) return $this->redirect('customers.php?a=index');

    $customer = $this->customer->find($id);
    if (!$customer) return $this->redirect('customers.php?a=index');

    $errorMsg   = $_SESSION['edit_customer_error'] ?? '';
    $successMsg = $_SESSION['edit_customer_success'] ?? '';
    unset($_SESSION['edit_customer_error'], $_SESSION['edit_customer_success']);

    $this->view('customers/edit', [
        'customer'   => $customer,
        'errorMsg'   => $errorMsg,
        'successMsg' => $successMsg
    ]);
}
	
public function update()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return $this->redirect('customers.php?a=index');
    }

    $id = $_POST['id'] ?? 0;
    if (!$id) return $this->redirect('customers.php?a=index');

    $data = [
        'name'            => trim($_POST['name']),
        'email'           => trim($_POST['email']),
        'phone'           => trim($_POST['phone']),
        'company_name'    => trim($_POST['company_name']),
        'company_reg_no'  => trim($_POST['company_reg_no']),
        'company_address' => trim($_POST['company_address']),
        'country'         => trim($_POST['country']),
        'role'            => trim($_POST['role']),
        'employees'       => trim($_POST['employees']),
        'user_status'          => trim($_POST['user_status']),
    ];

    if ($this->customer->update($id, $data)) {
        $_SESSION['edit_customer_success'] = 'Customer updated successfully.';
    } else {
        $_SESSION['edit_customer_error'] = 'Error updating customer.';
    }

    return $this->redirect('customers.php?a=edit&id=' . $id);
}


public function delete()
{
    $id = $_GET['id'] ?? 0;
    if ($id && $this->customer->delete($id)) {
        $_SESSION['customer_success'] = 'Customer deleted successfully.';
    } else {
        $_SESSION['customer_error'] = 'Error deleting customer.';
    }
    return $this->redirect('customers.php?a=index');
}

	
	
	
	
	
	
	
	
	
	
	
	
}
