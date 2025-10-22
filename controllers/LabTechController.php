<?php
require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../models/LabTechModel.php';

class LabTechController {
    private $conn;
    private $model;

    public function __construct($db) {
        $this->conn = $db;
        $this->model = new LabTechModel($db);
    }

    // ---------------------- MAIN HANDLER ----------------------
    public function handleRequest() {
        // --- Create lab tech account ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
            $result = $this->model->createLabTech($_POST);
            if ($result) {
                header("Location: lab-tech-pending-verification.html?success=1");
                exit;
            } else {
                header("Location: lab-tech-step4.html?error=1&message=" . urlencode("Failed to create account. Please try again."));
                exit;
            }
        }

        // --- Edit lab tech (redirect to edit form) ---
        if (isset($_GET['edit'])) {
            $this->edit();
            return;
        }

        // --- Delete / Approve / Reject / Deactivate / Activate ---
        $actions = ['delete', 'approve', 'reject', 'deactivate', 'activate'];
        foreach ($actions as $act) {
            if (isset($_GET[$act])) {
                $id = $_GET[$act];
                $statusMap = [
                    'approve' => 'Active',
                    'reject' => 'Rejected',
                    'deactivate' => 'Inactive',
                    'activate' => 'Active'
                ];
                if ($act === 'delete') {
                    $this->model->deleteLabTech($id);
                } else {
                    $this->model->updateLabTechStatus($id, $statusMap[$act]);
                }
                header("Location: index.php?action=manageLabTechs");
                exit;
            }
        }

        // --- Load lab tech list ---
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $counts = $this->model->getCounts();
        $labTechs = $this->model->getAllLabTechs($filter, $search);

        include __DIR__ . '/../views/system_admin/manageLabTechs.php';
    }

    // ---------------------- EDIT LAB TECH ----------------------
    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: No lab tech ID provided.");
        }

        $labtech_id = $_GET['id'];
        $labTech = $this->model->getLabTechById($labtech_id);

        if (!$labTech) {
            die("Error: Lab technician not found.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $updatedData = [
                'full_name' => $_POST['full_name'],
                'gender' => $_POST['gender'],
                'dob' => $_POST['dob'],
                'nic' => $_POST['nic'],
                'first_contact_no' => $_POST['first_contact_no'],
                'second_phone_no' => $_POST['second_phone_no'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'organization' => $_POST['organization'],
                'org_address' => $_POST['org_address'],
                'department' => $_POST['department'],
                'designation' => $_POST['designation'],
                'employee_id' => $_POST['employee_id'],
                'years_experience' => $_POST['years_experience'],
                'reference' => $_POST['reference'],
                'qualification' => $_POST['qualification'],
                'institute' => $_POST['institute'],
                'licenseNo' => $_POST['licenseNo'],
                'license_expiry' => $_POST['license_expiry'],
                'degree_certificate' => $_POST['degree_certificate'],
                'professional_license' => $_POST['professional_license'],
                'employee_letter' => $_POST['employee_letter']
            ];

            if ($this->model->updateLabTech($labtech_id, $updatedData)) {
                header("Location: index.php?action=manageLabTechs&updated=true");
                exit;
            } else {
                echo "Error updating lab technician.";
            }
        }

        include '../views/system_admin/editLabTechView.php';
    }

    // ---------------------- VALIDATE REGISTRATION DATA ----------------------
    public function validateRegistrationData($data) {
        $errors = [];

        // Required field validation
        $required_fields = [
            'full_name', 'gender', 'dob', 'nic', 'first_contact_no',
            'email', 'address', 'organization', 'org_address', 'department',
            'designation', 'employee_id', 'years_experience', 'qualification',
            'institute', 'licenseNo', 'license_expiry'
        ];

        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
            }
        }

        // Email validation
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email address is required.';
        }

        // NIC validation (assuming 12 digits for Sri Lankan NIC)
        if (!empty($data['nic']) && !preg_match('/^\d{12}$/', $data['nic'])) {
            $errors[] = 'NIC must be 12 digits.';
        }

        // Phone number validation
        if (!empty($data['first_contact_no']) && !preg_match('/^\d{10}$/', $data['first_contact_no'])) {
            $errors[] = 'Primary contact number must be 10 digits.';
        }

        if (!empty($data['second_phone_no']) && !preg_match('/^\d{10}$/', $data['second_phone_no'])) {
            $errors[] = 'Secondary contact number must be 10 digits.';
        }

        // Date validation
        if (!empty($data['dob']) && !strtotime($data['dob'])) {
            $errors[] = 'Valid date of birth is required.';
        }

        if (!empty($data['license_expiry']) && !strtotime($data['license_expiry'])) {
            $errors[] = 'Valid license expiry date is required.';
        }

        // Experience validation
        if (!empty($data['years_experience']) && (!is_numeric($data['years_experience']) || $data['years_experience'] < 0)) {
            $errors[] = 'Years of experience must be a valid number.';
        }

        return $errors;
    }

    // ---------------------- GENERATE UNIQUE LABTECH ID ----------------------
    public function generateLabTechId() {
        $prefix = 'LT';
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        $labtech_id = $prefix . $timestamp . $random;

        // Ensure uniqueness
        $max_attempts = 10;
        $attempts = 0;

        while ($this->model->labTechExists($labtech_id) && $attempts < $max_attempts) {
            $random = mt_rand(1000, 9999);
            $labtech_id = $prefix . $timestamp . $random;
            $attempts++;
        }

        if ($attempts >= $max_attempts) {
            // Fallback: use microtime for more uniqueness
            $labtech_id = $prefix . str_replace('.', '', microtime(true)) . mt_rand(100, 999);
        }

        return $labtech_id;
    }

    // ---------------------- CHECK EMPLOYEE ID UNIQUENESS ----------------------
    public function isEmployeeIdUnique($employee_id, $exclude_labtech_id = null) {
        if ($exclude_labtech_id) {
            // For updates, exclude current record
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM labtechaccountregister WHERE employee_id = ? AND labtech_id != ?");
            $stmt->bind_param("ss", $employee_id, $exclude_labtech_id);
        } else {
            // For new registrations
            return !$this->model->employeeIdExists($employee_id);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] == 0;
    }

    // ---------------------- GET LAB TECHS BY FILTERS ----------------------
    public function getFilteredLabTechs($filters = []) {
        $query = "SELECT * FROM labtechaccountregister WHERE 1";

        if (!empty($filters['organization'])) {
            $org = $this->conn->real_escape_string($filters['organization']);
            $query .= " AND organization = '$org'";
        }

        if (!empty($filters['department'])) {
            $dept = $this->conn->real_escape_string($filters['department']);
            $query .= " AND department = '$dept'";
        }

        if (!empty($filters['min_experience'])) {
            $min_exp = intval($filters['min_experience']);
            $query .= " AND years_experience >= $min_exp";
        }

        if (!empty($filters['max_experience'])) {
            $max_exp = intval($filters['max_experience']);
            $query .= " AND years_experience <= $max_exp";
        }

        if (!empty($filters['license_expiry_soon'])) {
            $days = intval($filters['license_expiry_soon']);
            $query .= " AND license_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL $days DAY)";
        }

        $query .= " ORDER BY full_name ASC";

        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ---------------------- BULK OPERATIONS ----------------------
    public function bulkUpdateStatus($labtech_ids, $status) {
        if (empty($labtech_ids)) {
            return false;
        }

        $ids_str = implode("','", array_map([$this->conn, 'real_escape_string'], $labtech_ids));
        $status_esc = $this->conn->real_escape_string($status);

        $query = "UPDATE labtechaccountregister SET status = '$status_esc' WHERE labtech_id IN ('$ids_str')";
        return $this->conn->query($query);
    }

    // ---------------------- GET STATISTICS ----------------------
    public function getStatistics() {
        $stats = [];

        // Total lab techs
        $stats['total'] = $this->model->getCounts()['total'];

        // By organization
        $org_query = "SELECT organization, COUNT(*) as count FROM labtechaccountregister GROUP BY organization ORDER BY count DESC LIMIT 10";
        $result = $this->conn->query($org_query);
        $stats['by_organization'] = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        // By department
        $dept_query = "SELECT department, COUNT(*) as count FROM labtechaccountregister GROUP BY department ORDER BY count DESC";
        $result = $this->conn->query($dept_query);
        $stats['by_department'] = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        // Experience distribution
        $exp_query = "SELECT
            CASE
                WHEN years_experience < 2 THEN '0-2 years'
                WHEN years_experience < 5 THEN '2-5 years'
                WHEN years_experience < 10 THEN '5-10 years'
                ELSE '10+ years'
            END as exp_range,
            COUNT(*) as count
            FROM labtechaccountregister
            GROUP BY exp_range
            ORDER BY exp_range";
        $result = $this->conn->query($exp_query);
        $stats['experience_distribution'] = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        return $stats;
    }
}
?>
