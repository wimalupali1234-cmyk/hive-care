<?php
require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../models/OrderSelfTestKit.php';

class OrderSelfTestKitController {
    private $conn;
    private $order;

    public function __construct($db) {
        $this->conn = $db;
        $this->order = new OrderSelfTestKit($db);
    }

    // CREATE order
    public function create($data) {
        // Handle both array and object data formats for compatibility
        if (is_array($data)) {
            $kit_type = $data['kit_type'] ?? null;
            $profile_id = $data['profile_id'] ?? null;
            $district = $data['district'] ?? null;
            $collection_point = $data['collection_point'] ?? null;
            $address = $data['address'] ?? null;
            $date = $data['date'] ?? null;
            $time = $data['time'] ?? null;
        } elseif (is_object($data)) {
            $kit_type = $data->kit_type ?? null;
            $profile_id = $data->profile_id ?? null;
            $district = $data->district ?? null;
            $collection_point = $data->collection_point ?? null;
            $address = $data->address ?? null;
            $date = $data->date ?? null;
            $time = $data->time ?? null;
        } else {
            error_log("Controller Error - Invalid data format. Expected array or object.");
            return false;
        }

        // Validate required fields
        if (!$kit_type || !$profile_id || !$district || !$collection_point || !$address || !$date || !$time) {
            error_log("Controller Error - Incomplete data. Required: kit_type, profile_id, district, collection_point, address, date, time");
            return false;
        }

        // Validate date format (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            error_log("Controller Error - Invalid date format. Use YYYY-MM-DD.");
            return false;
        }

        // Validate time format (HH:MM:SS)
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            error_log("Controller Error - Invalid time format. Use HH:MM:SS.");
            return false;
        }

        // Generate unique kit order number
        $kit_order_no = $this->generateKitOrderNo();
        error_log("Controller Debug - Generated kit order number: " . $kit_order_no);

        // Check if collection slot is available (returns false if slot is taken)
        error_log("Controller Debug - Checking collection slot availability for: collection_point={$collection_point}, date={$date}, time={$time}");
        $slot_available = $this->order->isCollectionSlotAvailable($collection_point, $date, $time);
        error_log("Controller Debug - Collection slot available: " . ($slot_available ? 'true' : 'false'));

        if (!$slot_available) {
            error_log("Controller Debug - Collection slot not available, returning false");
            return false; // Let handler deal with the error response
        }

        // Set order properties
        $this->order->kit_order_no = $kit_order_no;
        $this->order->kit_type = $kit_type;
        $this->order->profile_id = $profile_id;
        $this->order->district = $district;
        $this->order->collection_point = $collection_point;
        $this->order->address = $address;
        $this->order->date = $date;
        $this->order->time = $time;

        try {
            error_log("Controller Debug - About to call order->create()");
            error_log("Controller Debug - Data being passed: kit_type={$kit_type}, profile_id={$profile_id}, district={$district}, collection_point={$collection_point}, address={$address}, date={$date}, time={$time}");

            $result = $this->order->create();
            error_log("Controller Debug - Order creation result: " . ($result ? 'true' : 'false'));

            if ($result) {
                error_log("Controller Debug - Order creation successful");
                return true; // Success
            } else {
                // Log that creation failed
                error_log("Controller Debug - Order creation returned false - database error occurred");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Debug - Exception during order creation: " . $e->getMessage());
            return false;
        }
    }

    // READ all orders
    public function read() {
        $stmt = $this->order->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $orders_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($orders_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found."]);
        }
    }

    // READ single order by kit_order_no
    public function readOne($kit_order_no) {
        $this->order->kit_order_no = $kit_order_no;

        if($this->order->readOne()) {
            $order_arr = [
                "kit_order_no" => $this->order->kit_order_no,
                "kit_type" => $this->order->kit_type,
                "profile_id" => $this->order->profile_id,
                "district" => $this->order->district,
                "collection_point" => $this->order->collection_point,
                "address" => $this->order->address,
                "date" => $this->order->date,
                "time" => $this->order->time
            ];
            http_response_code(200);
            echo json_encode($order_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Order not found."]);
        }
    }

    // READ orders by profile_id
    public function readByProfileId($profile_id) {
        $stmt = $this->order->readByProfileId($profile_id);
        $num = $stmt->rowCount();

        if($num > 0) {
            $orders_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($orders_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found for this profile."]);
        }
    }

    // READ orders by district
    public function readByDistrict($district) {
        $stmt = $this->order->readByDistrict($district);
        $num = $stmt->rowCount();

        if($num > 0) {
            $orders_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($orders_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found for this district."]);
        }
    }

    // READ orders by collection_point
    public function readByCollectionPoint($collection_point) {
        $stmt = $this->order->readByCollectionPoint($collection_point);
        $num = $stmt->rowCount();

        if($num > 0) {
            $orders_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($orders_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found for this collection point."]);
        }
    }

    // READ orders by date
    public function readByDate($date) {
        $stmt = $this->order->readByDate($date);
        $num = $stmt->rowCount();

        if($num > 0) {
            $orders_arr = ["records" => []];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders_arr["records"][] = $row;
            }
            http_response_code(200);
            echo json_encode($orders_arr);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found for this date."]);
        }
    }

    // UPDATE order
    public function update($data) {
        if (!isset($data['kit_order_no'])) {
            error_log("Controller Error - Kit Order Number is required for update.");
            return false;
        }

        $this->order->kit_order_no = $data['kit_order_no'];
        $this->order->kit_type = $data['kit_type'] ?? null;
        $this->order->profile_id = $data['profile_id'] ?? null;
        $this->order->district = $data['district'] ?? null;
        $this->order->collection_point = $data['collection_point'] ?? null;
        $this->order->address = $data['address'] ?? null;
        $this->order->date = $data['date'] ?? null;
        $this->order->time = $data['time'] ?? null;

        try {
            if ($this->order->update()) {
                error_log("Controller Debug - Order updated successfully");
                return true;
            } else {
                error_log("Controller Debug - Failed to update order");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Error - Update order: " . $e->getMessage());
            return false;
        }
    }

    // DELETE order
    public function delete($kit_order_no) {
        try {
            $this->order->kit_order_no = $kit_order_no;
            if ($this->order->delete()) {
                error_log("Controller Debug - Order deleted successfully");
                return true;
            } else {
                error_log("Controller Debug - Failed to delete order");
                return false;
            }
        } catch (Exception $e) {
            error_log("Controller Error - Delete order: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if order exists
    public function orderExists($kit_order_no) {
        try {
            $this->order->kit_order_no = $kit_order_no;
            return $this->order->orderExists();
        } catch (Exception $e) {
            error_log("Controller Error - Check order exists: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if profile_id already has an order (alias for orderExistsByProfileId)
    public function profileHasOrder($profile_id) {
        try {
            $this->order->profile_id = $profile_id;
            return $this->order->orderExistsByProfileId();
        } catch (Exception $e) {
            error_log("Controller Error - Check profile has order: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if collection slot is available
    public function isCollectionSlotAvailable($collection_point, $date, $time) {
        try {
            return $this->order->isCollectionSlotAvailable($collection_point, $date, $time);
        } catch (Exception $e) {
            error_log("Controller Error - Check collection slot availability: " . $e->getMessage());
            return false;
        }
    }

    // GET available collection points for date
    public function getAvailableCollectionPoints($date) {
        try {
            return $this->order->getAvailableCollectionPoints($date);
        } catch (Exception $e) {
            error_log("Controller Error - Get available collection points: " . $e->getMessage());
            return [];
        }
    }

    // COUNT orders
    public function countAll() {
        try {
            return $this->order->countAll();
        } catch (Exception $e) {
            error_log("Controller Error - Count all orders: " . $e->getMessage());
            return 0;
        }
    }

    // COUNT orders by district
    public function countByDistrict($district) {
        try {
            return $this->order->countByDistrict($district);
        } catch (Exception $e) {
            error_log("Controller Error - Count by district: " . $e->getMessage());
            return 0;
        }
    }

    // COUNT orders by kit_type
    public function countByKitType($kit_type) {
        try {
            return $this->order->countByKitType($kit_type);
        } catch (Exception $e) {
            error_log("Controller Error - Count by kit type: " . $e->getMessage());
            return 0;
        }
    }

    // Generate unique kit order number
    private function generateKitOrderNo() {
        try {
            $prefix = 'KIT';
            $timestamp = time();
            $random = mt_rand(1000, 9999);
            $kit_order_no = $prefix . $timestamp . $random;

            // Ensure uniqueness by checking if it already exists
            $max_attempts = 10;
            $attempts = 0;

            while ($this->kitOrderNoExists($kit_order_no) && $attempts < $max_attempts) {
                $random = mt_rand(1000, 9999);
                $kit_order_no = $prefix . $timestamp . $random;
                $attempts++;
            }

            if ($attempts >= $max_attempts) {
                // Fallback: use microtime for more uniqueness
                $kit_order_no = $prefix . str_replace('.', '', microtime(true)) . mt_rand(100, 999);
            }

            return $kit_order_no;
        } catch (Exception $e) {
            error_log("Controller Error - Generate kit order number: " . $e->getMessage());
            // Fallback kit order number
            return 'KIT' . time() . mt_rand(1000, 9999);
        }
    }

    // Check if kit order number already exists
    private function kitOrderNoExists($kit_order_no) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM orderselftestkit WHERE kit_order_no = :kit_order_no");
            $stmt->bindParam(":kit_order_no", $kit_order_no);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0;
        } catch (Exception $e) {
            error_log("Controller Error - Check kit order number exists: " . $e->getMessage());
            return false;
        }
    }
}
?>
