<?php
class FacilityBasedTestAppointment {
    private $conn;
    private $table_name = "facilitybasedtestappointment";

    // Properties matching database columns
    public $appointment_code;
    public $test_type;
    public $profile_id;
    public $district;
    public $hospital;
    public $date;
    public $time_slot;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE appointment
    public function create() {
        $query = "INSERT INTO {$this->table_name}
                  (appointment_code, test_type, profile_id, district, hospital, date, time_slot)
                  VALUES
                  (:appointment_code, :test_type, :profile_id, :district, :hospital, :date, :time_slot)";

        $stmt = $this->conn->prepare($query);

        // Bind values - using PDO style binding
        $stmt->bindParam(":appointment_code", $this->appointment_code);
        $stmt->bindParam(":test_type", $this->test_type);
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":hospital", $this->hospital);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time_slot", $this->time_slot);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return error as JSON instead of just returning false (following working pattern)
            http_response_code(500);
            echo json_encode(["message" => "Database error: " . $e->getMessage()]);
            error_log("Create Appointment Error: " . $e->getMessage());
            return false;
        }
    }

    // READ all appointments
    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} ORDER BY date DESC, time_slot DESC");
        $stmt->execute();
        return $stmt;
    }

    // READ single appointment by appointment_code
    public function readOne() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE appointment_code = :appointment_code LIMIT 1");
        $stmt->bindParam(":appointment_code", $this->appointment_code);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->appointment_code = $row['appointment_code'];
                $this->test_type = $row['test_type'];
                $this->profile_id = $row['profile_id'];
                $this->district = $row['district'];
                $this->hospital = $row['hospital'];
                $this->date = $row['date'];
                $this->time_slot = $row['time_slot'];
                return true;
            }
        } else {
            error_log("Database Error - Read One Appointment: " . $stmt->errorInfo());
        }
        return false;
    }

    // READ single appointment by profile_id (for backward compatibility)
    public function readOneByProfileId() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE profile_id = :profile_id LIMIT 1");
        $stmt->bindParam(":profile_id", $this->profile_id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->appointment_code = $row['appointment_code'];
                $this->test_type = $row['test_type'];
                $this->profile_id = $row['profile_id'];
                $this->district = $row['district'];
                $this->hospital = $row['hospital'];
                $this->date = $row['date'];
                $this->time_slot = $row['time_slot'];
                return true;
            }
        } else {
            error_log("Database Error - Read One Appointment: " . $stmt->errorInfo());
        }
        return false;
    }

    // READ appointments by profile_id
    public function readByProfileId($profile_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE profile_id = :profile_id ORDER BY date DESC, time_slot DESC");
        $stmt->bindParam(":profile_id", $profile_id);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Profile ID: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ appointments by district
    public function readByDistrict($district) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE district = :district ORDER BY date DESC, time_slot DESC");
        $stmt->bindParam(":district", $district);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By District: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ appointments by hospital
    public function readByHospital($hospital) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE hospital = :hospital ORDER BY date DESC, time_slot DESC");
        $stmt->bindParam(":hospital", $hospital);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Hospital: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ appointments by date
    public function readByDate($date) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE date = :date ORDER BY time_slot DESC");
        $stmt->bindParam(":date", $date);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Date: " . $stmt->errorInfo());
            return false;
        }
    }

    // UPDATE appointment
    public function update() {
        $query = "UPDATE {$this->table_name}
                  SET test_type = :test_type, profile_id = :profile_id, district = :district, hospital = :hospital, date = :date, time_slot = :time_slot
                  WHERE appointment_code = :appointment_code";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":appointment_code", $this->appointment_code);
        $stmt->bindParam(":test_type", $this->test_type);
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":hospital", $this->hospital);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time_slot", $this->time_slot);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Appointment Error: " . $e->getMessage());
            return false;
        }
    }

    // DELETE appointment
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE appointment_code = :appointment_code");
        $stmt->bindParam(":appointment_code", $this->appointment_code);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Delete Appointment Error: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if appointment exists for appointment_code
    public function appointmentExists() {
        $stmt = $this->conn->prepare("SELECT appointment_code FROM {$this->table_name} WHERE appointment_code = :appointment_code LIMIT 1");
        $stmt->bindParam(":appointment_code", $this->appointment_code);
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CHECK if appointment exists for profile_id (for backward compatibility)
    public function appointmentExistsByProfileId() {
        $stmt = $this->conn->prepare("SELECT profile_id FROM {$this->table_name} WHERE profile_id = :profile_id LIMIT 1");
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CHECK if time slot is available for hospital and date
    public function isTimeSlotAvailable($hospital, $date, $time_slot, $exclude_profile_id = null) {
        try {
            $query = "SELECT profile_id FROM {$this->table_name} WHERE hospital = :hospital AND date = :date AND time_slot = :time_slot";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":hospital", $hospital);
            $stmt->bindParam(":date", $date);
            $stmt->bindParam(":time_slot", $time_slot);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // Return true if NO appointment found (slot is available)
                // Return false if appointment found (slot is taken)
                return $result === false;
            } else {
                error_log("Database Error - Check Time Slot: " . $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            error_log("Exception - Check Time Slot: " . $e->getMessage());
            return false;
        }
    }

    // GET available time slots for hospital and date
    public function getAvailableTimeSlots($hospital, $date) {
        // Define all possible time slots (example slots)
        $all_slots = [
            '09:00:00', '10:00:00', '11:00:00', '14:00:00', '15:00:00', '16:00:00'
        ];

        $stmt = $this->conn->prepare("SELECT time_slot FROM {$this->table_name} WHERE hospital = :hospital AND date = :date");
        $stmt->bindParam(":hospital", $hospital);
        $stmt->bindParam(":date", $date);

        $booked_slots = [];

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booked_slots[] = $row['time_slot'];
            }
        } else {
            error_log("Database Error - Get Available Time Slots: " . $stmt->errorInfo());
        }

        return array_diff($all_slots, $booked_slots);
    }

    // COUNT total appointments
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table_name}");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // COUNT appointments by district
    public function countByDistrict($district) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table_name} WHERE district = :district");
        $stmt->bindParam(":district", $district);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } else {
            error_log("Database Error - Count By District: " . $stmt->errorInfo());
            return 0;
        }
    }
}
?>
