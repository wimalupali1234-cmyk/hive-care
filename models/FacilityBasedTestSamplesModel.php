<?php
class FacilityBasedTestSamplesModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    /**
     * Create facilitybasedtestsamples table if it doesn't exist
     */
    public function createTable() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS facilitybasedtestsamples (
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
            )";

            $this->conn->exec($sql);
            return ['success' => true, 'message' => 'Table created successfully'];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Table creation failed: ' . $e->getMessage()];
        }
    }

    /**
     * Add new test sample
     */
    public function addSample($data) {
        try {
            // Generate unique sample_id
            $sampleId = 'FS' . date('YmdHis') . rand(100, 999);

            $sql = "INSERT INTO facilitybasedtestsamples (
                sample_id, sample_type, patient_id, collect_date, collect_time,
                collected_by, status, notes
            ) VALUES (
                :sample_id, :sample_type, :patient_id, :collect_date, :collect_time,
                :collected_by, :status, :notes
            )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':sample_id', $sampleId);
            $stmt->bindParam(':sample_type', $data['sampleType']);
            $stmt->bindParam(':patient_id', $data['patientId']);
            $stmt->bindParam(':collect_date', $data['collectDate']);
            $stmt->bindParam(':collect_time', $data['collectTime']);
            $stmt->bindParam(':collected_by', $data['collectedBy']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':notes', $data['notes']);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'sample_id' => $sampleId,
                    'message' => 'Sample added successfully'
                ];
            } else {
                return ['success' => false, 'message' => 'Failed to add sample'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get all samples with optional filters
     */
    public function getAllSamples($filters = []) {
        try {
            $sql = "SELECT * FROM facilitybasedtestsamples";
            $conditions = [];
            $params = [];

            if (!empty($filters['status'])) {
                $conditions[] = "status = :status";
                $params[':status'] = $filters['status'];
            }

            if (!empty($filters['patient_id'])) {
                $conditions[] = "patient_id = :patient_id";
                $params[':patient_id'] = $filters['patient_id'];
            }

            if (!empty($filters['sample_type'])) {
                $conditions[] = "sample_type = :sample_type";
                $params[':sample_type'] = $filters['sample_type'];
            }

            if (!empty($filters['collect_date'])) {
                $conditions[] = "collect_date = :collect_date";
                $params[':collect_date'] = $filters['collect_date'];
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            return [
                'success' => true,
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get sample by ID
     */
    public function getSampleById($sampleId) {
        try {
            $sql = "SELECT * FROM facilitybasedtestsamples WHERE sample_id = :sample_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':sample_id', $sampleId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'data' => $stmt->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                return ['success' => false, 'message' => 'Sample not found'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Update sample
     */
    public function updateSample($sampleId, $data) {
        try {
            $sql = "UPDATE facilitybasedtestsamples SET
                sample_type = :sample_type,
                patient_id = :patient_id,
                collect_date = :collect_date,
                collect_time = :collect_time,
                collected_by = :collected_by,
                status = :status,
                notes = :notes,
                updated_at = NOW()
            WHERE sample_id = :sample_id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':sample_id', $sampleId);
            $stmt->bindParam(':sample_type', $data['sampleType']);
            $stmt->bindParam(':patient_id', $data['patientId']);
            $stmt->bindParam(':collect_date', $data['collectDate']);
            $stmt->bindParam(':collect_time', $data['collectTime']);
            $stmt->bindParam(':collected_by', $data['collectedBy']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':notes', $data['notes']);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Sample updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update sample'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Delete sample
     */
    public function deleteSample($sampleId) {
        try {
            $sql = "DELETE FROM facilitybasedtestsamples WHERE sample_id = :sample_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':sample_id', $sampleId);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Sample deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete sample'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get sample statistics
     */
    public function getSampleStats() {
        try {
            $sql = "SELECT
                COUNT(*) as total_samples,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_samples,
                COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_samples,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_samples,
                COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected_samples
            FROM facilitybasedtestsamples";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return [
                'success' => true,
                'data' => $stmt->fetch(PDO::FETCH_ASSOC)
            ];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get samples by patient ID
     */
    public function getSamplesByPatient($patientId) {
        try {
            $sql = "SELECT * FROM facilitybasedtestsamples WHERE patient_id = :patient_id ORDER BY collect_date DESC, collect_time DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':patient_id', $patientId);
            $stmt->execute();

            return [
                'success' => true,
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Update sample status
     */
    public function updateSampleStatus($sampleId, $status) {
        try {
            $sql = "UPDATE facilitybasedtestsamples SET status = :status, updated_at = NOW() WHERE sample_id = :sample_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':sample_id', $sampleId);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Status updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update status'];
            }

        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>
