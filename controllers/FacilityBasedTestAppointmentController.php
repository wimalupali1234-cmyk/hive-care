<?php
require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../models/FacilityBasedTestAppointment.php';

class FacilityBasedTestAppointmentController {
    private $conn;
    private $appointment;

    public function __construct($db) {
        $this->conn = $db;
        $this->appointment = new FacilityBasedTestAppointment($db);
    }

    // CREATE appointment
    public function create($data) {
        // Handle both array and object data formats for compatibility
        if (is_array($data)) {
            $test_type = $data['test_type'] ?? null;
            $profile_id = $data['profile_id'] ?? null;
            $district = $data['district'] ?? null;
            $hospital = $data['hospital'] ?? null;
            $date = $data['date'] ?? null;
            $time_slot = $data['time_slot'] ?? null;
        } elseif (is_object($data)) {
            $test_type = $data->test_type ?? null;
            $profile_id = $data->profile_id ?? null;
            $district = $data->district ?? null;
            $hospital = $data->hospital ?? null;
            $date = $data->date ?? null;
            $time_slot = $data->time_slot ?? null;
        } else {
            error_log("Controller Error - Invalid data format. Expected array or object.");
            return false;
        }

        // Validate required fields
        if (!$test_type || !$profile_id || !$district || !$hospital || !$date || !$time_slot) {
            error_log("Controller Error - Incomplete data. Required: test_type, profile_id, district, hospital, date, time_slot");
            return false;
        }

        // Validate date format (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            error_log("Controller Error - Invalid date format. Use YYYY-MM-DD.");
            return false;
        }

        // Validate time format (HH:MM:SS)
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $time_slot)) {
            error_log("Controller Error - Invalid time format. Use HH:MM:SS.");
            return false;
        }

        // Generate unique appointment code
        $appointment_code = $this->generateAppointmentCode();
        error_log("Controller Debug - Generated appointment code: " . $appointment_code);

        // Check if time slot is available (returns false if slot is taken)
        error_log("Controller Debug - Checking time slot availability for: hospital={$hospital}, date={$date}, time_slot={$time_slot}");
        $slot_available = $this->appointment->isTimeSlotAvailable($hospital, $date, $time_slot);
        error_log("Controller Debug - Time slot available: " . ($slot_available ? 'true' : 'false'));

        if (!$slot_available) {
            error_log("Controller Debug - Time slot not available, returning false");
            return false; // Let handler deal with the error response
        }

        // Set appointment properties
        $this->appointment->appointment_code = $appointment_code;
        $this->appointment->test_type = $test_type;
        $this->appointment->profile_id = $profile_id;
        $this->appointment->district = $district;
        $this->appointment->hospital = $hospital;
        $this->appointment->date = $date;
        $this->appointment->time_slot = $time_slot;

        try {
            error_log("Controller Debug - About to call appointment->create()");
            error_log("Controller Debug - Data being passed: test_type={$test_type}, profile_id={$profile_id}, district={$district}, hospital={$hospital}, date={$date}, time_slot={$time_slot}");

            $result = $this->appointment->create();
            error_log("Controller Debug - Appointment creation result: " . ($result ? 'true' : 'false'));

            if ($result) {
                error_log("Controller Debug - Appointment creation successful");
                return true; // Success
            } else {
                // Log that creation failed
                error_log("Controller Debug - Appointment creation returned false - database error occurred");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Debug - Exception during appointment creation: " . $e->getMessage());
            return false;
        }
    }

    // READ all appointments
    public function read() {
        $stmt = $this->appointment->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $appointments_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appointments_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($appointments_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No appointments found."]);
        }
    }

    // READ single appointment by profile_id
    public function readOne($profile_id) {
        $this->appointment->profile_id = $profile_id;

        if($this->appointment->readOne()) {
            $appointment_arr = [
                "test_type" => $this->appointment->test_type,
                "profile_id" => $this->appointment->profile_id,
                "district" => $this->appointment->district,
                "hospital" => $this->appointment->hospital,
                "date" => $this->appointment->date,
                "time_slot" => $this->appointment->time_slot
            ];
            http_response_code(200);
            echo json_encode($appointment_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Appointment not found."]);
        }
    }

    // READ appointments by profile_id
    public function readByProfileId($profile_id) {
        $stmt = $this->appointment->readByProfileId($profile_id);
        $num = $stmt->rowCount();

        if($num > 0) {
            $appointments_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appointments_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($appointments_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No appointments found for this profile."]);
        }
    }

    // READ appointments by district
    public function readByDistrict($district) {
        $stmt = $this->appointment->readByDistrict($district);
        $num = $stmt->rowCount();

        if($num > 0) {
            $appointments_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appointments_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($appointments_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No appointments found for this district."]);
        }
    }

    // READ appointments by hospital
    public function readByHospital($hospital) {
        $stmt = $this->appointment->readByHospital($hospital);
        $num = $stmt->rowCount();

        if($num > 0) {
            $appointments_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appointments_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($appointments_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No appointments found for this hospital."]);
        }
    }

    // READ appointments by date
    public function readByDate($date) {
        $stmt = $this->appointment->readByDate($date);
        $num = $stmt->rowCount();

        if($num > 0) {
            $appointments_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $appointments_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($appointments_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No appointments found for this date."]);
        }
    }

    // UPDATE appointment
    public function update($data) {
        if (!isset($data['profile_id'])) {
            error_log("Controller Error - Profile ID is required for update.");
            return false;
        }

        $this->appointment->profile_id = $data['profile_id'];
        $this->appointment->test_type = $data['test_type'] ?? null;
        $this->appointment->district = $data['district'] ?? null;
        $this->appointment->hospital = $data['hospital'] ?? null;
        $this->appointment->date = $data['date'] ?? null;
        $this->appointment->time_slot = $data['time_slot'] ?? null;

        try {
            if ($this->appointment->update()) {
                error_log("Controller Debug - Appointment updated successfully");
                return true;
            } else {
                error_log("Controller Debug - Failed to update appointment");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Error - Update appointment: " . $e->getMessage());
            return false;
        }
    }

    // DELETE appointment
    public function delete($profile_id) {
        try {
            $this->appointment->profile_id = $profile_id;
            if ($this->appointment->delete()) {
                error_log("Controller Debug - Appointment deleted successfully");
                return true;
            } else {
                error_log("Controller Debug - Failed to delete appointment");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Error - Delete appointment: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if appointment exists
    public function appointmentExists($profile_id) {
        try {
            $this->appointment->profile_id = $profile_id;
            return $this->appointment->appointmentExists();
        } catch (Exception $e) {
            error_log("Controller Error - Check appointment exists: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if profile_id already has an appointment (alias for appointmentExists)
    public function profileHasAppointment($profile_id) {
        return $this->appointmentExists($profile_id);
    }

    // CHECK if time slot is available
    public function isTimeSlotAvailable($hospital, $date, $time_slot) {
        try {
            return $this->appointment->isTimeSlotAvailable($hospital, $date, $time_slot);
        } catch (Exception $e) {
            error_log("Controller Error - Check time slot availability: " . $e->getMessage());
            return false;
        }
    }

    // GET available time slots for hospital and date
    public function getAvailableTimeSlots($hospital, $date) {
        try {
            return $this->appointment->getAvailableTimeSlots($hospital, $date);
        } catch (Exception $e) {
            error_log("Controller Error - Get available time slots: " . $e->getMessage());
            return [];
        }
    }

    // COUNT appointments
    public function countAll() {
        try {
            return $this->appointment->countAll();
        } catch (Exception $e) {
            error_log("Controller Error - Count all appointments: " . $e->getMessage());
            return 0;
        }
    }

    // COUNT appointments by district
    public function countByDistrict($district) {
        try {
            return $this->appointment->countByDistrict($district);
        } catch (Exception $e) {
            error_log("Controller Error - Count by district: " . $e->getMessage());
            return 0;
        }
    }

    // Generate unique appointment code
    private function generateAppointmentCode() {
        try {
            $prefix = 'APT';
            $timestamp = time();
            $random = mt_rand(1000, 9999);
            $appointment_code = $prefix . $timestamp . $random;

            // Ensure uniqueness by checking if it already exists
            $max_attempts = 10;
            $attempts = 0;

            while ($this->appointmentCodeExists($appointment_code) && $attempts < $max_attempts) {
                $random = mt_rand(1000, 9999);
                $appointment_code = $prefix . $timestamp . $random;
                $attempts++;
            }

            if ($attempts >= $max_attempts) {
                // Fallback: use microtime for more uniqueness
                $appointment_code = $prefix . str_replace('.', '', microtime(true)) . mt_rand(100, 999);
            }

            return $appointment_code;
        } catch (Exception $e) {
            error_log("Controller Error - Generate appointment code: " . $e->getMessage());
            // Fallback appointment code
            return 'APT' . time() . mt_rand(1000, 9999);
        }
    }

    // Check if appointment code already exists
    private function appointmentCodeExists($appointment_code) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM facilitybasedtestappointment WHERE appointment_code = :appointment_code");
            $stmt->bindParam(":appointment_code", $appointment_code);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0;
        } catch (Exception $e) {
            error_log("Controller Error - Check appointment code exists: " . $e->getMessage());
            return false;
        }
    }
}
?>
