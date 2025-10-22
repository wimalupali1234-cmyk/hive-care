<?php

class CounsellorModel {
    private $conn;
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $rows = [];
        $res = $this->conn->query("SELECT * FROM admin_counsellors ORDER BY counselor_id DESC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r;
            }
            $res->free();
        }
        return $rows;
    }

    private function generateCounsellorId(): string {
        // Get the last counselor_id from database (note: DB uses American spelling)
        $result = $this->conn->query("SELECT counselor_id FROM admin_counsellors WHERE counselor_id LIKE 'C%' ORDER BY counselor_id DESC LIMIT 1");
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = $row['counselor_id'];
            // Extract the number part (e.g., "C005" -> 5)
            $number = (int)substr($lastId, 1);
            $newNumber = $number + 1;
        } else {
            // First counsellor, start from 1
            $newNumber = 1;
        }
        
        // Format as C001, C002, etc.
        return 'C' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function insert(array $data): bool {
        // Auto-generate counsellor_id
        $counsellor_id = $this->generateCounsellorId();
        $sql = "INSERT INTO admin_counsellors
            (counselor_id, full_name, gender, email, nic, primary_contact, secondary_contact, address,
             last_hospital, hospital_address, department, experience,
             qualification, university, license_no, license_expiry)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            error_log("Counsellor Model Prepare Error: " . $this->conn->error);
            return false;
        }

        // Use null for empty strings in optional fields
        $license_expiry = !empty($data['license_expiry']) ? $data['license_expiry'] : null;
        $experience = !empty($data['experience']) ? (int)$data['experience'] : null;

        $stmt->bind_param(
            'sssssssssssissss',
            $counsellor_id,
            $data['full_name'],
            $data['gender'],
            $data['email'],
            $data['nic'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['address'],
            $data['last_hospital'],
            $data['hospital_address'],
            $data['department'],
            $experience,
            $data['qualification'],
            $data['university'],
            $data['license_no'],
            $license_expiry
        );

        $ok = $stmt->execute();
        if (!$ok) {
            error_log("Counsellor Model Execute Error: " . $stmt->error);
        } else {
            error_log("Counsellor created successfully with ID: " . $counsellor_id);
        }
        $stmt->close();
        return $ok;
    }

    public function update(array $data): bool {
        $sql = "UPDATE admin_counsellors SET
            full_name=?, gender=?, email=?, nic=?, primary_contact=?, secondary_contact=?, address=?,
            last_hospital=?, hospital_address=?, department=?, experience=?, qualification=?,
            university=?, license_no=?, license_expiry=?
            WHERE counselor_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        
        // Use null for empty strings in optional fields
        $license_expiry = !empty($data['license_expiry']) ? $data['license_expiry'] : null;
        $experience = !empty($data['experience']) ? (int)$data['experience'] : null;
        
        $stmt->bind_param(
            'ssssssssssisssss',
            $data['full_name'],
            $data['gender'],
            $data['email'],
            $data['nic'],
            $data['primary_contact'],
            $data['secondary_contact'],
            $data['address'],
            $data['last_hospital'],
            $data['hospital_address'],
            $data['department'],
            $experience,
            $data['qualification'],
            $data['university'],
            $data['license_no'],
            $license_expiry,
            $data['counsellor_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete($counsellor_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM admin_counsellors WHERE counselor_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param('s', $counsellor_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>