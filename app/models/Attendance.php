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

	
class Attendance
{
    protected $conn;
    protected $table = 'phppayroll_attendance';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // =========================
    // GET ALL ATTENDANCE RECORDS
    // =========================
    public function all()
    {
        $sql = "SELECT a.*,
                       e.first_name,
                       e.last_name,
                       e.employee_code
                FROM {$this->table} a
                LEFT JOIN phppayroll_employees e ON e.id = a.employee_id
                ORDER BY a.attendance_date DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // =========================
    // FIND SINGLE RECORD
    // =========================
    public function find($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // =========================
    // CREATE ATTENDANCE
    // =========================
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (employee_id, attendance_date, check_in, check_out, status)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'issss',
            $data['employee_id'],
            $data['attendance_date'],
            $data['check_in'],
            $data['check_out'],
            $data['status']
        );

        return $stmt->execute();
    }

    // =========================
    // UPDATE ATTENDANCE
    // =========================
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET employee_id = ?, attendance_date = ?, check_in = ?, check_out = ?, status = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'issssi',
            $data['employee_id'],
            $data['attendance_date'],
            $data['check_in'],
            $data['check_out'],
            $data['status'],
            $id
        );

        return $stmt->execute();
    }

    // =========================
    // DELETE ATTENDANCE
    // =========================
    public function delete($id)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
