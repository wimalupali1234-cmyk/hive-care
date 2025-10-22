<?php
// Use absolute path to avoid conflicts with duplicate files
require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../models/PatientCreateAccount.php';

class PatientCreateAccountController {
    private $conn;
    private $patient;

    public function __construct($db) {
        $this->conn = $db;
        $this->patient = new PatientCreateAccount($db);
    }

    // CREATE patient account
    public function create($data) {
        // Handle both array and object data formats for compatibility
        if (is_array($data)) {
            $profile_id = $data['profile_id'] ?? null;
            $first_name_letter = $data['first_name_letter'] ?? null;
            $last_name_letter = $data['last_name_letter'] ?? null;
            $primary_phone = $data['primary_phone'] ?? null;
            $secondary_phone = $data['secondary_phone'] ?? null;
            $district = $data['district'] ?? null;
            $password = $data['password'] ?? null;
        } elseif (is_object($data)) {
            $profile_id = $data->profile_id ?? null;
            $first_name_letter = $data->first_name_letter ?? null;
            $last_name_letter = $data->last_name_letter ?? null;
            $primary_phone = $data->primary_phone ?? null;
            $secondary_phone = $data->secondary_phone ?? null;
            $district = $data->district ?? null;
            $password = $data->password ?? null;
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid data format. Expected array or object."]);
            return false;
        }

        if(!$profile_id || !$first_name_letter || !$last_name_letter || !$primary_phone || !$district || !$password) {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data. Required: profile_id, first_name_letter, last_name_letter, primary_phone, district, password"]);
            return false;
        }

        $this->patient->profile_id = $profile_id;
        $this->patient->first_name_letter = $first_name_letter;
        $this->patient->last_name_letter = $last_name_letter;
        $this->patient->primary_phone = $primary_phone;
        $this->patient->secondary_phone = $secondary_phone;
        $this->patient->district = $district;
        $this->patient->password = $password;
        $this->patient->account_created_datetime = date('Y-m-d H:i:s');

        if($this->patient->create()) {
            return true; // Success
        } else {
            // Error already handled by model, just return false
            return false;
        }
    }

    // READ all patients
    public function read() {
        $stmt = $this->patient->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $patients_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $patients_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($patients_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No patient accounts found."]);
        }
    }

    // READ single patient by profile_id
    public function readOne($profile_id) {
        $this->patient->profile_id = $profile_id;

        if($this->patient->readOne()) {
            $patient_arr = [
                "profile_id" => $this->patient->profile_id,
                "first_name_letter" => $this->patient->first_name_letter,
                "last_name_letter" => $this->patient->last_name_letter,
                "primary_phone" => $this->patient->primary_phone,
                "secondary_phone" => $this->patient->secondary_phone,
                "district" => $this->patient->district,
                "account_created_datetime" => $this->patient->account_created_datetime
            ];
            http_response_code(200);
            echo json_encode($patient_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Patient account not found."]);
        }
    }

    // UPDATE patient account
    public function update($data) {
        if(!isset($data->profile_id)) {
            http_response_code(400);
            echo json_encode(["message" => "Profile ID is required."]);
            return;
        }

        $this->patient->profile_id = $data->profile_id;
        $this->patient->first_name_letter = $data->first_name_letter ?? null;
        $this->patient->last_name_letter = $data->last_name_letter ?? null;
        $this->patient->primary_phone = $data->primary_phone ?? null;
        $this->patient->secondary_phone = $data->secondary_phone ?? null;
        $this->patient->district = $data->district ?? null;
        $this->patient->account_created_datetime = $data->account_created_datetime ?? date('Y-m-d H:i:s');

        if($this->patient->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Patient account updated successfully."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update patient account."]);
        }
    }

    // DELETE patient account
    public function delete($profile_id) {
        $this->patient->profile_id = $profile_id;

        if($this->patient->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Patient account deleted successfully."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete patient account."]);
        }
    }
}
?>
