<?php
class OrderSelfTestKit {
    private $conn;
    private $table_name = "orderselftestkit";

    // Properties matching database columns
    public $kit_order_no;
    public $kit_type;
    public $profile_id;
    public $district;
    public $collection_point;
    public $address;
    public $date;
    public $time;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE order
    public function create() {
        $query = "INSERT INTO {$this->table_name}
                  (kit_order_no, kit_type, profile_id, district, collection_point, address, date, time)
                  VALUES
                  (:kit_order_no, :kit_type, :profile_id, :district, :collection_point, :address, :date, :time)";

        $stmt = $this->conn->prepare($query);

        // Bind values - using PDO style binding
        $stmt->bindParam(":kit_order_no", $this->kit_order_no);
        $stmt->bindParam(":kit_type", $this->kit_type);
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":collection_point", $this->collection_point);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return error as JSON instead of just returning false (following working pattern)
            http_response_code(500);
            echo json_encode(["message" => "Database error: " . $e->getMessage()]);
            error_log("Create Order Error: " . $e->getMessage());
            return false;
        }
    }

    // READ all orders
    public function read() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} ORDER BY date DESC, time DESC");
        $stmt->execute();
        return $stmt;
    }

    // READ single order by kit_order_no
    public function readOne() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE kit_order_no = :kit_order_no LIMIT 1");
        $stmt->bindParam(":kit_order_no", $this->kit_order_no);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->kit_order_no = $row['kit_order_no'];
                $this->kit_type = $row['kit_type'];
                $this->profile_id = $row['profile_id'];
                $this->district = $row['district'];
                $this->collection_point = $row['collection_point'];
                $this->address = $row['address'];
                $this->date = $row['date'];
                $this->time = $row['time'];
                return true;
            }
        } else {
            error_log("Database Error - Read One Order: " . $stmt->errorInfo());
        }
        return false;
    }

    // READ single order by profile_id (for backward compatibility)
    public function readOneByProfileId() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE profile_id = :profile_id LIMIT 1");
        $stmt->bindParam(":profile_id", $this->profile_id);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->kit_order_no = $row['kit_order_no'];
                $this->kit_type = $row['kit_type'];
                $this->profile_id = $row['profile_id'];
                $this->district = $row['district'];
                $this->collection_point = $row['collection_point'];
                $this->address = $row['address'];
                $this->date = $row['date'];
                $this->time = $row['time'];
                return true;
            }
        } else {
            error_log("Database Error - Read One Order: " . $stmt->errorInfo());
        }
        return false;
    }

    // READ orders by profile_id
    public function readByProfileId($profile_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE profile_id = :profile_id ORDER BY date DESC, time DESC");
        $stmt->bindParam(":profile_id", $profile_id);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Profile ID: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ orders by district
    public function readByDistrict($district) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE district = :district ORDER BY date DESC, time DESC");
        $stmt->bindParam(":district", $district);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By District: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ orders by collection_point
    public function readByCollectionPoint($collection_point) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE collection_point = :collection_point ORDER BY date DESC, time DESC");
        $stmt->bindParam(":collection_point", $collection_point);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Collection Point: " . $stmt->errorInfo());
            return false;
        }
    }

    // READ orders by date
    public function readByDate($date) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE date = :date ORDER BY time DESC");
        $stmt->bindParam(":date", $date);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            error_log("Database Error - Read By Date: " . $stmt->errorInfo());
            return false;
        }
    }

    // UPDATE order
    public function update() {
        $query = "UPDATE {$this->table_name}
                  SET kit_type = :kit_type, profile_id = :profile_id, district = :district, collection_point = :collection_point, address = :address, date = :date, time = :time
                  WHERE kit_order_no = :kit_order_no";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kit_order_no", $this->kit_order_no);
        $stmt->bindParam(":kit_type", $this->kit_type);
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":collection_point", $this->collection_point);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Order Error: " . $e->getMessage());
            return false;
        }
    }

    // DELETE order
    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE kit_order_no = :kit_order_no");
        $stmt->bindParam(":kit_order_no", $this->kit_order_no);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Delete Order Error: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if order exists for kit_order_no
    public function orderExists() {
        $stmt = $this->conn->prepare("SELECT kit_order_no FROM {$this->table_name} WHERE kit_order_no = :kit_order_no LIMIT 1");
        $stmt->bindParam(":kit_order_no", $this->kit_order_no);
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CHECK if order exists for profile_id (for backward compatibility)
    public function orderExistsByProfileId() {
        $stmt = $this->conn->prepare("SELECT profile_id FROM {$this->table_name} WHERE profile_id = :profile_id LIMIT 1");
        $stmt->bindParam(":profile_id", $this->profile_id);
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CHECK if collection point and time slot is available for date
    public function isCollectionSlotAvailable($collection_point, $date, $time) {
        try {
            $query = "SELECT kit_order_no FROM {$this->table_name} WHERE collection_point = :collection_point AND date = :date AND time = :time";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":collection_point", $collection_point);
            $stmt->bindParam(":date", $date);
            $stmt->bindParam(":time", $time);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // Return true if NO order found (slot is available)
                // Return false if order found (slot is taken)
                return $result === false;
            } else {
                error_log("Database Error - Check Collection Slot: " . $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            error_log("Exception - Check Collection Slot: " . $e->getMessage());
            return false;
        }
    }

    // GET available collection points for date
    public function getAvailableCollectionPoints($date) {
        // Define all possible collection points (example points)
        $all_points = [
            'Colombo General Hospital',
            'National Hospital Kandy',
            'Teaching Hospital Jaffna',
            'Gampaha District Hospital',
            'Galle Teaching Hospital'
        ];

        $stmt = $this->conn->prepare("SELECT collection_point FROM {$this->table_name} WHERE date = :date");
        $stmt->bindParam(":date", $date);

        $booked_points = [];

        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booked_points[] = $row['collection_point'];
            }
        } else {
            error_log("Database Error - Get Available Collection Points: " . $stmt->errorInfo());
        }

        return array_diff($all_points, $booked_points);
    }

    // COUNT total orders
    public function countAll() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table_name}");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // COUNT orders by district
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

    // COUNT orders by kit_type
    public function countByKitType($kit_type) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM {$this->table_name} WHERE kit_type = :kit_type");
        $stmt->bindParam(":kit_type", $kit_type);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } else {
            error_log("Database Error - Count By Kit Type: " . $stmt->errorInfo());
            return 0;
        }
    }
}
?>
