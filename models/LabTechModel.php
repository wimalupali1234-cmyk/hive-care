<?php
class LabTechModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    /**
     * Register a new lab technician
     */
    public function registerLabTech($data) {
        try {
            $sql = "INSERT INTO labtechaccountregister (
                full_name, gender, dob, nic, first_contact_no, second_phone_no,
                email, address, organization, org_address, department,
                designation, employee_id, years_experience, reference,
                qualification, institute, licenseNo, license_expiry,
                degree_certificate, professional_license, employee_letter,
                password, labtech_id, status
            ) VALUES (
                :full_name, :gender, :dob, :nic, :first_contact_no, :second_phone_no,
                :email, :address, :organization, :org_address, :department,
                :designation, :employee_id, :years_experience, :reference,
                :qualification, :institute, :licenseNo, :license_expiry,
                :degree_certificate, :professional_license, :employee_letter,
                :password, :labtech_id, 'pending'
            )";

            $stmt = $this->conn->prepare($sql);

            // Generate unique labtech_id
            $labtechId = 'LT' . date('YmdHis') . rand(100, 999);

            // Bind parameters (mapping to existing table structure)
            $stmt->bindParam(':full_name', $data['fullName']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':dob', $data['dob']);
            $stmt->bindParam(':nic', $data['nic']);
            $stmt->bindParam(':first_contact_no', $data['primaryContact']);
            $stmt->bindParam(':second_phone_no', $data['secondaryContact']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':organization', $data['currentHospital']);
            $stmt->bindParam(':org_address', $data['hospitalAddress']);
            $stmt->bindParam(':department', $data['department']);
            $stmt->bindParam(':designation', $data['designation']);
            $stmt->bindParam(':employee_id', $data['employeeId']);
            $stmt->bindParam(':years_experience', $data['yearsExperience']);
            $stmt->bindParam(':reference', $data['reference']);
            $stmt->bindParam(':qualification', $data['qualification']);
            $stmt->bindParam(':institute', $data['university']);
            $stmt->bindParam(':licenseNo', $data['licenseNumber']);
            $stmt->bindParam(':license_expiry', $data['licenseExpiry']);
            $stmt->bindParam(':degree_certificate', $data['degreeCertificate']);
            $stmt->bindParam(':professional_license', $data['professionalLicense']);
            $stmt->bindParam(':employee_letter', $data['employmentLetter']);
            $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $stmt->bindParam(':labtech_id', $labtechId);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'tech_id' => $this->conn->lastInsertId(),
                    'message' => 'Registration submitted successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Registration failed'
                ];
            }

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Authenticate lab technician login
     */
    public function authenticateLabTech($techId, $password) {
        try {
            // Find by employee_id
            $sql = "SELECT * FROM labtechaccountregister WHERE employee_id = :tech_id AND status = 'approved'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tech_id', $techId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    return [
                        'success' => true,
                        'data' => [
                            'tech_id' => $user['employee_id'],
                            'full_name' => $user['full_name'],
                            'organization' => $user['organization'],
                            'department' => $user['department'],
                            'email' => $user['email'],
                            'phone' => $user['first_contact_no'],
                            'location' => $user['org_address'],
                            'qualification' => $user['qualification']
                        ]
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Invalid Employee ID or password, or account not approved'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get lab technician by database ID
     */
    public function getLabTechById($techId) {
        try {
            $sql = "SELECT * FROM labtechaccountregister WHERE id = :tech_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':tech_id', $techId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'data' => $stmt->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lab technician not found'
                ];
            }

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get lab technician by employee ID
     */
    public function getLabTechByEmployeeId($employeeId) {
        try {
            $sql = "SELECT * FROM labtechaccountregister WHERE employee_id = :employee_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':employee_id', $employeeId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'data' => $stmt->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lab technician not found'
                ];
            }

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update lab technician status
     */
    public function updateStatus($techId, $status) {
        try {
            $sql = "UPDATE labtechaccountregister SET status = :status WHERE id = :tech_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':tech_id', $techId);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Status updated successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update status'
                ];
            }

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}
?>
