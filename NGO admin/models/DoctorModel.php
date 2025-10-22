<?php

class DoctorModel {
    public $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM admin_doctors ORDER BY doctor_id DESC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    private function generateDoctorId(): string {
        // Get the last doctor_id from database
        $result = $this->conn->query("SELECT doctor_id FROM admin_doctors WHERE doctor_id LIKE 'D%' ORDER BY doctor_id DESC LIMIT 1");
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = $row['doctor_id'];
            // Extract the number part (e.g., "D005" -> 5)
            $number = (int)substr($lastId, 1);
            $newNumber = $number + 1;
        } else {
            // First doctor, start from 1
            $newNumber = 1;
        }
        
        // Format as D001, D002, etc.
        return 'D' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function create(array $data): bool {
        // Auto-generate doctor_id
        $doctor_id = $this->generateDoctorId();
        
        $sql = "INSERT INTO admin_doctors
            (doctor_id, full_name, gender, nic, primary_contact, secondary_contact, email, address,
             last_hospital, hospital_address, department, experience, qualification,
             university, license_no, license_expiry)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Doctor Model Prepare Error: " . $this->conn->error);
            return false;
        }
        
        // Use null for empty strings in optional fields
        $license_expiry = !empty($data['license_expiry']) ? $data['license_expiry'] : null;
        
        $stmt->bind_param(
            'sssssssssssissss',
            $doctor_id,
            $data['full_name'],
            $data['gender'],
            $data['nic'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['email'],
            $data['address'],
            $data['last_hospital'],
            $data['hospital_address'],
            $data['department'],
            $data['experience'],
            $data['qualification'],
            $data['university'],
            $data['license_no'],
            $license_expiry
        );
        $ok = $stmt->execute();
        if (!$ok) {
            error_log("Doctor Model Execute Error: " . $stmt->error);
        } else {
            error_log("Doctor created successfully with ID: " . $doctor_id);
        }
        $stmt->close();
        return $ok;
    }

    public function update(array $data): bool {
        $sql = "UPDATE admin_doctors SET
            full_name=?, gender=?, nic=?, primary_contact=?, secondary_contact=?, email=?, address=?,
            last_hospital=?, hospital_address=?, department=?, experience=?, qualification=?,
            university=?, license_no=?, license_expiry=?
            WHERE doctor_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        
        // Use null for empty strings in optional fields
        $license_expiry = !empty($data['license_expiry']) ? $data['license_expiry'] : null;
        
        $stmt->bind_param(
            'sssssssssssissss',
            $data['full_name'],
            $data['gender'],
            $data['nic'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['email'],
            $data['address'],
            $data['last_hospital'],
            $data['hospital_address'],
            $data['department'],
            $data['experience'],
            $data['qualification'],
            $data['university'],
            $data['license_no'],
            $license_expiry,
            $data['doctor_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete($doctor_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM admin_doctors WHERE doctor_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param('s', $doctor_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>