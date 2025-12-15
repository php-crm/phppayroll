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

	
class Payroll
{
    protected $conn;
    protected $table = 'phppayroll_payroll';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ALL PAYROLLS
    public function all()
    {
        $sql = "SELECT p.*,
                       e.first_name, e.last_name, e.employee_code
                FROM {$this->table} p
                LEFT JOIN phppayroll_employees e ON e.id = p.employee_id
                ORDER BY p.generated_at DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // FIND
    public function find($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // CREATE
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (employee_id, salary_month, basic_salary, allowances, deductions, net_salary)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'isdddd',
            $data['employee_id'],
            $data['salary_month'],
            $data['basic_salary'],
            $data['allowances'],
            $data['deductions'],
            $data['net_salary']
        );

        return $stmt->execute();
    }

    // UPDATE
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET employee_id=?, salary_month=?, basic_salary=?, allowances=?, deductions=?, net_salary=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'isddddi',
            $data['employee_id'],
            $data['salary_month'],
            $data['basic_salary'],
            $data['allowances'],
            $data['deductions'],
            $data['net_salary'],
            $id
        );

        return $stmt->execute();
    }

    // DELETE
    public function delete($id)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id=?"
        );
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
