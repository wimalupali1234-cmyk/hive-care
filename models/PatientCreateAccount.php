<?php
class PatientCreateAccount {
    private $conn;
    private $table_name = "patientcreateaccount";

    public $profile_id;
    public $first_name_letter;
    public $last_name_letter;
    public $primary_phone;
    public $secondary_phone;
    public $district;
    public $password;
    public $account_created_datetime;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE patient
    public function create() {
        $query = "INSERT INTO {$this->table_name}
                  (profile_id, first_name_letter, last_name_letter, primary_phone, secondary_phone, district, password, account_created_datetime)
                  VALUES
                  (:profile_id, :first_name_letter, :last_name_letter, :primary_phone, :secondary_phone, :district, :password, :account_created_datetime)";

        $stmt = $this->conn->prepare($query);

        // Allow null secondary phone
        $secondary_phone = $this->secondary_phone ?: null;

        // Bind values
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->bindParam(":first_name_letter", $this->first_name_letter);
        $stmt->bindParam(":last_name_letter", $this->last_name_letter);
        $stmt->bindParam(":primary_phone", $this->primary_phone);
        $stmt->bindParam(":secondary_phone", $secondary_phone);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":account_created_datetime", $this->account_created_datetime);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return error as JSON instead of just returning false
            http_response_code(500);
            echo json_encode(["message" => "Database error: " . $e->getMessage()]);
            error_log("Create Patient Error: " . $e->getMessage());
            return false;
        }
    }

    // READ all
    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} ORDER BY account_created_datetime DESC");
        $stmt->execute();
        return $stmt;
    }

    // READ single
    public function readOne() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE profile_id = ? LIMIT 1");
        $stmt->bindParam(1, $this->profile_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            foreach($row as $key => $value) $this->$key = $value;
            return true;
        }
        return false;
    }

    // UPDATE
    public function update() {
        $query = "UPDATE {$this->table_name} 
                  SET first_name_letter=:first_name_letter, last_name_letter=:last_name_letter,
                      primary_phone=:primary_phone, secondary_phone=:secondary_phone, district=:district,
                      account_created_datetime=:account_created_datetime
                  WHERE profile_id=:profile_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":first_name_letter", $this->first_name_letter);
        $stmt->bindParam(":last_name_letter", $this->last_name_letter);
        $stmt->bindParam(":primary_phone", $this->primary_phone);
        $stmt->bindParam(":secondary_phone", $this->secondary_phone);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":account_created_datetime", $this->account_created_datetime);
        $stmt->bindParam(":profile_id", $this->profile_id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Patient Error: " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE profile_id = ?");
        $stmt->bindParam(1, $this->profile_id);
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Delete Patient Error: " . $e->getMessage());
            return false;
        }
    }

    // SEARCH by district
    public function searchByDistrict($district) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE district LIKE ? ORDER BY account_created_datetime DESC");
        $search_term = "%{$district}%";
        $stmt->bindParam(1, $search_term);
        $stmt->execute();
        return $stmt;
    }

    // SEARCH by phone
    public function searchByPhone($phone) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} 
                                      WHERE primary_phone LIKE ? OR secondary_phone LIKE ? 
                                      ORDER BY account_created_datetime DESC");
        $search_term = "%{$phone}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->execute();
        return $stmt;
    }

    // DATE RANGE
    public function getByDateRange($start, $end) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} 
                                      WHERE account_created_datetime BETWEEN ? AND ? 
                                      ORDER BY account_created_datetime DESC");
        $stmt->bindParam(1, $start);
        $stmt->bindParam(2, $end);
        $stmt->execute();
        return $stmt;
    }

    // COUNT
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table_name}");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // CHECK profile exists
    public function profileExists() {
        $stmt = $this->conn->prepare("SELECT profile_id FROM {$this->table_name} WHERE profile_id = ? LIMIT 1");
        $stmt->bindParam(1, $this->profile_id);
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
