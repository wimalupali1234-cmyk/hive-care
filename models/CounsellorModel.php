<?php
class CounsellorModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Get list of upcoming scheduled counselling sessions for this counsellor.
     * Returns an array of associative arrays.
     */
    public function getUpcomingSessions($counsellorId) {
        $sql = "
            SELECT id, session_code, `date`, `time`, mode, status
            FROM counselling_sessions
            WHERE counsellor_id = ?
              AND `date` >= CURDATE()
              AND status IN ('Scheduled', 'Rescheduled')
            ORDER BY `date` ASC, `time` ASC
        ";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $counsellorId);
            $stmt->execute();
            $res = $stmt->get_result();
            $rows = $res->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $rows;
        }
        return [];  // on error return empty array
    }

    /**
     * Update availability times/dates for this counsellor.
     * Expects $availabilityData as array of ['date'=>'YYYY-MM-DD','start_time'=>'HH:MM:SS','end_time'=>'HH:MM:SS']
     */
    public function updateAvailability($counsellorId, array $availabilityData) {
        // Delete existing availability
        $sqlDel = "DELETE FROM counsellor_availability WHERE counsellor_id = ?";
        if ($stmtDel = $this->conn->prepare($sqlDel)) {
            $stmtDel->bind_param("i", $counsellorId);
            $stmtDel->execute();
            $stmtDel->close();
        } else {
            return false;
        }

        // Insert new availability rows
        $sqlIns = "
            INSERT INTO counsellor_availability (counsellor_id, `date`, start_time, end_time)
            VALUES (?, ?, ?, ?)
        ";
        if ($stmtIns = $this->conn->prepare($sqlIns)) {
            foreach ($availabilityData as $row) {
                $stmtIns->bind_param(
                    "isss",
                    $counsellorId,
                    $row['date'],
                    $row['start_time'],
                    $row['end_time']
                );
                $stmtIns->execute();
            }
            $stmtIns->close();
            return true;
        }
        return false;
    }

    /**
     * Block off unavailable dates for consultation.
     * Expects $dates as array of strings 'YYYY-MM-DD'
     */
    public function blockDates($counsellorId, array $dates) {
        if (empty($dates)) {
            return true;
        }
        $sql = "INSERT INTO counsellor_unavailable (counsellor_id, `date`) VALUES (?, ?)";
        if ($stmt = $this->conn->prepare($sql)) {
            foreach ($dates as $d) {
                $stmt->bind_param("is", $counsellorId, $d);
                $stmt->execute();
            }
            $stmt->close();
            return true;
        }
        return false;
    }

    /**
     * Mark a consultation session status: e.g., Completed, Missed, Rescheduled.
     */
    public function updateSessionStatus($sessionId, $newStatus) {
        $sql = "UPDATE counselling_sessions SET status = ? WHERE id = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("si", $newStatus, $sessionId);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
        return false;
    }

    /**
     * Save or update counselling session notes.
     */
    public function saveSessionNotes($sessionId, $notes) {
        $sql = "UPDATE counselling_sessions SET notes = ? WHERE id = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("si", $notes, $sessionId);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
        return false;
    }

    /**
     * Get previous completed sessions for an anonymous user code.
     */
    public function getPreviousSessionsForUser($userCode) {
        $sql = "
            SELECT id, `date`, `time`, mode, status, notes
            FROM counselling_sessions
            WHERE user_code = ?
              AND status = 'Completed'
            ORDER BY `date` DESC, `time` DESC
        ";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("s", $userCode);
            $stmt->execute();
            $res = $stmt->get_result();
            $rows = $res->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $rows;
        }
        return [];
    }

    /**
     * Get anonymised user data (only code + basic demographics) given a user code.
     */
    public function getUserAnonymised($userCode) {
        $sql = "SELECT user_code, gender, age_group FROM users_anonymous WHERE user_code = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("s", $userCode);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $stmt->close();
            return $row;
        }
        return null;
    }
}
?>
