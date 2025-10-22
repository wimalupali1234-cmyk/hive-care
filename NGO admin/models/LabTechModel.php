<?php

class LabTechModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM admin_lab_tech ORDER BY tech_id DESC");
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
            $res->free();
        }
        return $rows;
    }

    private function generateTechId(): string {
        // Get the last tech_id from database
        $result = $this->conn->query("SELECT tech_id FROM admin_lab_tech WHERE tech_id LIKE 'T%' ORDER BY tech_id DESC LIMIT 1");
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = $row['tech_id'];
            // Extract the number part (e.g., "T005" -> 5)
            $number = (int)substr($lastId, 1);
            $newNumber = $number + 1;
        } else {
            // First tech, start from 1
            $newNumber = 1;
        }
        
        // Format as T001, T002, etc.
        return 'T' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function create(array $data): bool {
        // Auto-generate tech_id
        $tech_id = $this->generateTechId();
        $sql = "INSERT INTO admin_lab_tech
            (tech_id, full_name, gender, nic, primary_contact, secondary_contact, email, address,
             last_hospital, hospital_address, department, experience,
             qualification, university, license_no, license_expiry,
             degree_certificate, professional_license, employment_letter)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("LabTech Model Prepare Error: " . $this->conn->error);
            return false;
        }

        // Convert experience string to int for database
        $experience_val = 0;
        if (!empty($data['experience'])) {
            // Extract first number from "0-2", "3-5", "20+" etc.
            preg_match('/^(\d+)/', $data['experience'], $matches);
            $experience_val = isset($matches[1]) ? (int)$matches[1] : 0;
        }
        
        $stmt->bind_param(
            'sssssssssssisssssss',
            $tech_id,
            $data['full_name'],
            $data['gender'],
            $data['nic_number'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['email_address'],
            $data['address'],
            $data['last_hospital_name'],
            $data['hospital_address'],
            $data['department'],
            $experience_val,
            $data['highest_qualification'],
            $data['university_name'],
            $data['license_number'],
            $data['license_expiry'],
            $data['degree_certificate'],
            $data['professional_license'],
            $data['employment_letter']
        );

        $ok = $stmt->execute();
        if (!$ok) {
            error_log("LabTech Model Execute Error: " . $stmt->error);
        } else {
            error_log("Lab Tech created successfully with ID: " . $tech_id);
        }
        $stmt->close();
        return $ok;
    }

    public function update(array $data): bool {
        $sql = "UPDATE admin_lab_tech SET
            full_name=?, gender=?, nic=?, primary_contact=?, secondary_contact=?, email=?, address=?,
            last_hospital=?, hospital_address=?, department=?, experience=?, qualification=?,
            university=?, license_no=?, license_expiry=?
            WHERE tech_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        // Convert experience string to int for database
        $experience_val = 0;
        if (!empty($data['experience'])) {
            // Extract first number from "0-2", "3-5", etc.
            preg_match('/^(\d+)/', $data['experience'], $matches);
            $experience_val = isset($matches[1]) ? (int)$matches[1] : 0;
        }
        
        $stmt->bind_param(
            'ssssssssssisssss',
            $data['full_name'],
            $data['gender'],
            $data['nic_number'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['email_address'],
            $data['address'],
            $data['last_hospital_name'],
            $data['hospital_address'],
            $data['department'],
            $experience_val,
            $data['highest_qualification'],
            $data['university_name'],
            $data['license_number'],
            $data['license_expiry'],
            $data['tech_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete($tech_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM admin_lab_tech WHERE tech_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param('s', $tech_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>