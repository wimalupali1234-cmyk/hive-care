<?php
class Database {
    public $host = "localhost";
    public $db_name = "hiv";
    public $username = "root";
    public $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(3, 2); // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            $this->conn->setAttribute(19, 2); // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            $this->conn->exec("SET NAMES utf8");
        } catch(PDOException $exception) {
            // Log the error and throw exception instead of outputting HTML - let handler deal with it
            error_log("Database connection error: " . $exception->getMessage());
            throw new Exception("Database connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }



    // Method to check if database exists, create if not
    public function initializeDatabase() {
        try {
            // First check if we can connect to MySQL server without specifying database
            $temp_conn = new PDO(
                "mysql:host=" . $this->host,
                $this->username,
                $this->password
            );
            $temp_conn->setAttribute(3, 2); // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

            // Create database if it doesn't exist
            $temp_conn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "`");

            // Use the database
            $temp_conn->exec("USE `" . $this->db_name . "`");

            // Check if patientcreateaccount table exists
            $result = $temp_conn->query("SHOW TABLES LIKE 'patientcreateaccount'");
            if ($result->rowCount() == 0) {
                // Table doesn't exist, create it
                $temp_conn->exec("CREATE TABLE patientcreateaccount (
                    profile_id VARCHAR(50) PRIMARY KEY,
                    first_name_letter VARCHAR(1) NOT NULL,
                    last_name_letter VARCHAR(1) NOT NULL,
                    primary_phone VARCHAR(15) NOT NULL,
                    secondary_phone VARCHAR(15),
                    district VARCHAR(100) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    account_created_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_district (district),
                    INDEX idx_phone (primary_phone),
                    INDEX idx_created_datetime (account_created_datetime)
                )");
            }

            // Check if facilitybasedtestappointment table exists
            $result = $temp_conn->query("SHOW TABLES LIKE 'facilitybasedtestappointment'");
            if ($result->rowCount() == 0) {
                // Table doesn't exist, create it with appointment_code as primary key
                $temp_conn->exec("CREATE TABLE facilitybasedtestappointment (
                    appointment_code VARCHAR(255) PRIMARY KEY,
                    test_type VARCHAR(255) NOT NULL,
                    profile_id VARCHAR(255) NOT NULL,
                    district VARCHAR(50) NOT NULL,
                    hospital VARCHAR(255) NOT NULL,
                    date DATE NOT NULL,
                    time_slot TIME NOT NULL,
                    account_created_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    UNIQUE KEY unique_appointment (appointment_code),
                    INDEX idx_district (district),
                    INDEX idx_hospital (hospital),
                    INDEX idx_date (date),
                    INDEX idx_profile_id (profile_id)
                )");
            }

            // Check if orderselftestkit table exists
            $result = $temp_conn->query("SHOW TABLES LIKE 'orderselftestkit'");
            if ($result->rowCount() == 0) {
                // Table doesn't exist, create it with the updated structure
                $temp_conn->exec("CREATE TABLE orderselftestkit (
                    kit_order_no VARCHAR(255) PRIMARY KEY,
                    kit_type VARCHAR(255) NOT NULL,
                    profile_id VARCHAR(255) NOT NULL,
                    district TEXT NOT NULL,
                    collection_point VARCHAR(255) NOT NULL,
                    address VARCHAR(255) NOT NULL,
                    date DATE NOT NULL,
                    time TIME NOT NULL,
                    INDEX idx_district (district),
                    INDEX idx_collection_point (collection_point),
                    INDEX idx_date (date),
                    INDEX idx_profile_id (profile_id),
                    INDEX idx_kit_type (kit_type)
                )");
                error_log("DEBUG - Created orderselftestkit table");
            } else {
                error_log("DEBUG - orderselftestkit table already exists");
            }

            // Check if labtechaccountregister table exists
            $result = $temp_conn->query("SHOW TABLES LIKE 'labtechaccountregister'");
            if ($result->rowCount() == 0) {
                // Table doesn't exist, create it with the specified structure
                $temp_conn->exec("CREATE TABLE labtechaccountregister (
                    full_name VARCHAR(255) NOT NULL,
                    gender TEXT NOT NULL,
                    dob DATE NOT NULL,
                    nic INT(11) NOT NULL,
                    first_contact_no INT(11) NOT NULL,
                    second_phone_no INT(11),
                    email VARCHAR(255) NOT NULL,
                    address VARCHAR(255) NOT NULL,
                    organization VARCHAR(255) NOT NULL,
                    org_address VARCHAR(255) NOT NULL,
                    department VARCHAR(50) NOT NULL,
                    designation TEXT NOT NULL,
                    employee_id VARCHAR(50) NOT NULL,
                    years_experience INT(11) NOT NULL,
                    reference VARCHAR(255),
                    qualification VARCHAR(255) NOT NULL,
                    institute VARCHAR(255) NOT NULL,
                    licenseNo VARCHAR(50) NOT NULL,
                    license_expiry DATE,
                    degree_certificate VARCHAR(255),
                    professional_license VARCHAR(255),
                    employee_letter VARCHAR(255),
                    password VARCHAR(255) NOT NULL,
                    labtech_id VARCHAR(50) PRIMARY KEY,
                    status VARCHAR(50) DEFAULT 'Pending',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_employee_id (employee_id),
                    INDEX idx_organization (organization),
                    INDEX idx_department (department),
                    INDEX idx_status (status),
                    INDEX idx_license_expiry (license_expiry)
                )");
                error_log("DEBUG - Created labtechaccountregister table");
            } else {
                // Table exists, check if it needs updating
                $columns_result = $temp_conn->query("DESCRIBE labtechaccountregister");
                $columns = $columns_result->fetchAll(PDO::FETCH_ASSOC);

                $column_names = array_column($columns, 'Field');
                $needs_update = false;

                // Check for missing columns
                $required_columns = [
                    'qualification', 'password', 'status', 'created_at',
                    'degree_certificate', 'professional_license', 'employee_letter'
                ];

                foreach ($required_columns as $required_col) {
                    if (!in_array($required_col, $column_names)) {
                        $needs_update = true;
                        break;
                    }
                }

                // Check for typo in qualification column
                if (in_array('qualfication', $column_names) && !in_array('qualification', $column_names)) {
                    $needs_update = true;
                }

                if ($needs_update) {
                    error_log("DEBUG - Updating existing labtechaccountregister table");

                    // Drop the existing table and recreate it
                    $temp_conn->exec("DROP TABLE IF EXISTS labtechaccountregister");

                    // Create the table with correct structure
                    $temp_conn->exec("CREATE TABLE labtechaccountregister (
                        full_name VARCHAR(255) NOT NULL,
                        gender TEXT NOT NULL,
                        dob DATE NOT NULL,
                        nic INT(11) NOT NULL,
                        first_contact_no INT(11) NOT NULL,
                        second_phone_no INT(11),
                        email VARCHAR(255) NOT NULL,
                        address VARCHAR(255) NOT NULL,
                        organization VARCHAR(255) NOT NULL,
                        org_address VARCHAR(255) NOT NULL,
                        department VARCHAR(50) NOT NULL,
                        designation TEXT NOT NULL,
                        employee_id VARCHAR(50) NOT NULL,
                        years_experience INT(11) NOT NULL,
                        reference VARCHAR(255),
                        qualification VARCHAR(255) NOT NULL,
                        institute VARCHAR(255) NOT NULL,
                        licenseNo VARCHAR(50) NOT NULL,
                        license_expiry DATE,
                        degree_certificate VARCHAR(255),
                        professional_license VARCHAR(255),
                        employee_letter VARCHAR(255),
                        password VARCHAR(255) NOT NULL,
                        labtech_id VARCHAR(50) PRIMARY KEY,
                        status VARCHAR(50) DEFAULT 'Pending',
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        INDEX idx_employee_id (employee_id),
                        INDEX idx_organization (organization),
                        INDEX idx_department (department),
                        INDEX idx_status (status),
                        INDEX idx_license_expiry (license_expiry)
                    )");
                    error_log("DEBUG - Recreated labtechaccountregister table with correct structure");
                } else {
                    error_log("DEBUG - labtechaccountregister table already exists with correct structure");
                }
            }

            // Check if facilitybasedtestsamples table exists
            $result = $temp_conn->query("SHOW TABLES LIKE 'facilitybasedtestsamples'");
            if ($result->rowCount() == 0) {
                // Table doesn't exist, create it
                $temp_conn->exec("CREATE TABLE facilitybasedtestsamples (
                    sample_id VARCHAR(50) PRIMARY KEY,
                    sample_type TEXT NOT NULL,
                    patient_id VARCHAR(50) NOT NULL,
                    collect_date DATE NOT NULL,
                    collect_time TIME NOT NULL,
                    collected_by TEXT NOT NULL,
                    status TEXT NOT NULL DEFAULT 'pending',
                    notes TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                    INDEX idx_patient_id (patient_id),
                    INDEX idx_collect_date (collect_date),
                    INDEX idx_status (status),
                    INDEX idx_sample_type (sample_type)
                )");
                error_log("DEBUG - Created facilitybasedtestsamples table");
            } else {
                error_log("DEBUG - facilitybasedtestsamples table already exists");
            }

            $temp_conn = null;
            return true;
        } catch(PDOException $exception) {
            // Log the error and throw exception instead of outputting HTML - let handler deal with it
            error_log("Database initialization error: " . $exception->getMessage());
            throw new Exception("Error initializing database: " . $exception->getMessage());
        }
    }
}
?>
