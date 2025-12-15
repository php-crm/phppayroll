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


// app/controllers/DashboardController.php

class DashboardController
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }

    protected function getSingleInt(string $sql): int
    {
        $result = $this->conn->query($sql);
        if (!$result) return 0;

        $row = $result->fetch_row();
        return isset($row[0]) ? (int)$row[0] : 0;
    }

    public function index()
    {
        // =====================
        // HR DASHBOARD STATS
        // =====================

        // Employees
        $totalEmployees  = $this->getSingleInt(
            "SELECT COUNT(*) FROM phppayroll_employees"
        );

        $activeEmployees = $this->getSingleInt(
            "SELECT COUNT(*) FROM phppayroll_employees WHERE status = 1"
        );

        // Today's attendance
        $todayAttendance = $this->getSingleInt(
            "SELECT COUNT(*) FROM phppayroll_attendance WHERE attendance_date = CURDATE()"
        );

        // Pending leave requests
        $pendingLeaves = $this->getSingleInt(
            "SELECT COUNT(*) FROM phppayroll_leaves WHERE status = 'pending'"
        );

        // =====================
        // LOAD VIEW
        // =====================
        include __DIR__ . '/../views/dashboard/index.php';
    }
}
