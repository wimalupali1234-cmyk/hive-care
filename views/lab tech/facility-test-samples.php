<?php
// Include required files
require_once 'models/connection.php';
require_once 'models/FacilityBasedTestSamplesModel.php';

// Initialize database and model
$database = new Database();

// Initialize database and create tables if they don't exist
try {
    $database->initializeDatabase();
} catch (Exception $e) {
    // Continue anyway - the model will handle table creation if needed
}

$model = new FacilityBasedTestSamplesModel($database->getConnection());

// Ensure the table exists
$model->createTable();

// Get statistics directly in PHP
$statsResult = $model->getSampleStats();
$stats = $statsResult['success'] ? $statsResult['data'] : [
    'total_samples' => 0,
    'pending_samples' => 0,
    'processing_samples' => 0,
    'completed_samples' => 0,
    'rejected_samples' => 0
];

// Handle form submission for adding samples
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add') {
    $result = $model->addSample($_POST);

    if ($result['success']) {
        header("Location: facility-test-samples.php?success=" . urlencode($result['message']));
        exit;
    } else {
        header("Location: facility-test-samples.php?error=" . urlencode($result['message']));
        exit;
    }
}

// Get samples for display
$filters = [];
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}
if (isset($_GET['sample_type']) && !empty($_GET['sample_type'])) {
    $filters['sample_type'] = $_GET['sample_type'];
}

$samplesResult = $model->getAllSamples($filters);
$samples = $samplesResult['success'] ? $samplesResult['data'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility Based Test Samples - HIVeCare</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .samples-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .samples-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .samples-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(3, 30, 70, 0.3);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .samples-filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b8cae;
            text-transform: uppercase;
        }

        .filter-select {
            padding: 8px 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: #031e46;
        }

        .samples-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 5px solid #031e46;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #031e46;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }

        .recent-samples-container {
            margin-top: 30px;
        }

        .samples-table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .samples-table {
            width: 100%;
            border-collapse: collapse;
        }

        .samples-table th,
        .samples-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .samples-table th {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        .samples-table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-collected {
            background: #cce7ff;
            color: #0066cc;
        }

        .status-testing {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .breadcrumb {
            margin-bottom: 20px;
            font-size: 16px;
            color: #666;
        }

        .breadcrumb a {
            color: #031e46;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .back-button {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background: #5a6268;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .loading i {
            font-size: 32px;
            margin-bottom: 15px;
            color: #031e46;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #031e46;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #ffcdd2;
        }

        .modal-body {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row.full-width {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #031e46;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .required {
            color: #e74c3c;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-modal-primary {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
        }

        .btn-modal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(3, 30, 70, 0.3);
        }

        .btn-modal-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-modal-secondary:hover {
            background: #5a6268;
        }

        /* Submit button specific styling */
        .submit-btn {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%) !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
            font-size: 16px !important;
            border: none !important;
            border-radius: 8px !important;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #28a745 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4) !important;
        }

        /* Card-based Display Styles */
        .samples-container-cards {
            margin-top: 30px;
        }

        .samples-header {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .samples-header h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .samples-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .samples-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .sample-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sample-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .sample-card-header {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sample-id {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .id-value {
            font-family: monospace;
            font-weight: bold;
            font-size: 16px;
        }

        .sample-status {
            display: flex;
            align-items: center;
        }

        .sample-card-body {
            padding: 20px;
        }

        .sample-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row strong {
            color: #031e46;
            font-weight: 600;
            min-width: 140px;
        }

        .info-row span {
            color: #666;
            text-align: right;
            flex: 1;
        }

        .sample-card-footer {
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #031e46;
        }

        .empty-state p {
            font-size: 16px;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .samples-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .samples-actions {
                justify-content: center;
            }

            .samples-filters {
                justify-content: center;
            }

            .samples-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .samples-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .sample-card {
                margin: 0;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .info-row strong {
                min-width: auto;
            }

            .info-row span {
                text-align: left;
            }
        }

        @media (max-width: 576px) {
            .samples-stats {
                grid-template-columns: 1fr;
            }

            .samples-header h2 {
                font-size: 20px;
            }

            .samples-header p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>

    <div class="samples-container">
        <div class="page-header">
            <h1><i class="fas fa-vial"></i> Facility Based Test Samples</h1>
            <p>Manage and track HIV test samples from facility-based testing</p>
        </div>

        <div class="breadcrumb">
            <a href="lab-tech-dashboard.html">Dashboard</a> >
            <a href="lab-tech-samples.html">Samples</a> >
            <strong>Facility Based Testing</strong>
        </div>

        <button class="back-button" onclick="window.location.href='lab-tech-samples.html'">
            <i class="fas fa-arrow-left"></i> Back to Samples
        </button>



        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="samples-controls">
            <div class="samples-actions">
                <button class="btn btn-primary" onclick="showAddSampleModal()">
                    <i class="fas fa-plus"></i> Add New Sample
                </button>
                <button class="btn btn-success" onclick="refreshStats()">
                    <i class="fas fa-sync"></i> Refresh Stats
                </button>
            </div>

            <div class="samples-filters">
                <div class="filter-group">
                    <div class="filter-label">Filter by Status</div>
                    <select class="filter-select" onchange="filterByStatus(this.value)">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo (isset($_GET['status']) && $_GET['status'] === 'processing') ? 'selected' : ''; ?>>Processing</option>
                        <option value="completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="rejected" <?php echo (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>

                <div class="filter-group">
                    <div class="filter-label">Filter by Type</div>
                    <select class="filter-select" onchange="filterByType(this.value)">
                        <option value="">All Types</option>
                        <option value="Blood Sample" <?php echo (isset($_GET['sample_type']) && $_GET['sample_type'] === 'Blood Sample') ? 'selected' : ''; ?>>Blood Sample</option>
                        <option value="Oral Fluid" <?php echo (isset($_GET['sample_type']) && $_GET['sample_type'] === 'Oral Fluid') ? 'selected' : ''; ?>>Oral Fluid</option>
                        <option value="Urine Sample" <?php echo (isset($_GET['sample_type']) && $_GET['sample_type'] === 'Urine Sample') ? 'selected' : ''; ?>>Urine Sample</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="samples-stats" id="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_samples']; ?></div>
                <div class="stat-label">Total Samples</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending_samples']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['processing_samples']; ?></div>
                <div class="stat-label">Processing</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['completed_samples']; ?></div>
                <div class="stat-label">Completed</div>
            </div>
        </div>

        <!-- Samples Display Cards -->
        <div class="samples-container-cards">
            <div class="samples-header">
                <h2><i class="fas fa-vial"></i> Facility Based Test Samples</h2>
                <p>Manage and track HIV test samples from facility-based testing</p>
            </div>

            <?php if (!empty($samples)): ?>
                <div class="samples-grid">
                    <?php foreach ($samples as $sample): ?>
                        <div class="sample-card">
                            <div class="sample-card-header">
                                <div class="sample-id">
                                    <strong>Sample ID:</strong>
                                    <span class="id-value"><?php echo htmlspecialchars($sample['sample_id']); ?></span>
                                </div>
                                <div class="sample-status">
                                    <span class="status-badge status-<?php echo strtolower($sample['status']); ?>">
                                        <?php echo htmlspecialchars($sample['status']); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="sample-card-body">
                                <div class="sample-info">
                                    <div class="info-row">
                                        <strong>Sample Type:</strong>
                                        <span><?php echo htmlspecialchars($sample['sample_type']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <strong>Patient ID:</strong>
                                        <span><?php echo htmlspecialchars($sample['patient_id']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <strong>Collection Date:</strong>
                                        <span><?php echo date('M d, Y', strtotime($sample['collect_date'])); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <strong>Collection Time:</strong>
                                        <span><?php echo date('h:i A', strtotime($sample['collect_time'])); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <strong>Collected By:</strong>
                                        <span><?php echo htmlspecialchars($sample['collected_by']); ?></span>
                                    </div>
                                    <?php if (!empty($sample['notes'])): ?>
                                        <div class="info-row">
                                            <strong>Notes:</strong>
                                            <span><?php echo htmlspecialchars($sample['notes']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="sample-card-footer">
                                <button class="btn btn-warning btn-sm" onclick="editSample('<?php echo $sample['sample_id']; ?>')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteSample('<?php echo $sample['sample_id']; ?>')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <h3>No samples found</h3>
                    <p>Add your first sample using the "Add New Sample" button above.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Add Sample Modal -->
    <div id="addSampleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-plus"></i> Add New Sample</h2>
                <span class="close" onclick="hideAddSampleModal()">&times;</span>
            </div>
            <form id="addSampleForm" action="facility-test-samples.php?action=add" method="POST">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sampleType">Sample Type <span class="required">*</span></label>
                            <select id="sampleType" name="sampleType" required>
                                <option value="">Select sample type</option>
                                <option value="Viral Load Testing">Viral Load Testing</option>
                                <option value="STI Testing">STI Testing</option>
                                <option value="Hep C Testing">Hep C Testing</option>
                                <option value="Hep B Testing">Hep B Testing</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="patientId">Patient ID <span class="required">*</span></label>
                            <input type="text" id="patientId" name="patientId" required
                                   placeholder="Enter patient ID (e.g., P2025001)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="collectDate">Collection Date <span class="required">*</span></label>
                            <input type="date" id="collectDate" name="collectDate" required
                                   max="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="collectTime">Collection Time <span class="required">*</span></label>
                            <input type="time" id="collectTime" name="collectTime" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="collectedBy">Collected By <span class="required">*</span></label>
                            <input type="text" id="collectedBy" name="collectedBy" required
                                   placeholder="Enter your name or ID">
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="required">*</span></label>
                            <select id="status" name="status" required>
                                <option value="">Select status</option>
                                <option value="collected">Collected</option>
                                <option value="testing">Testing</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row full-width">
                        <div class="form-group">
                            <label for="notes">Notes (Optional)</label>
                            <textarea id="notes" name="notes"
                                      placeholder="Enter any additional notes or observations about the sample"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-modal-secondary" onclick="hideAddSampleModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-modal submit-btn">
                        <i class="fas fa-check"></i> Submit Sample
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.html'; ?>

    <script>
        // Filter functions
        function filterByStatus(status) {
            const url = new URL(window.location);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            url.searchParams.delete('sample_type');
            window.location.href = url.toString();
        }

        function filterByType(sampleType) {
            const url = new URL(window.location);
            if (sampleType) {
                url.searchParams.set('sample_type', sampleType);
            } else {
                url.searchParams.delete('sample_type');
            }
            url.searchParams.delete('status');
            window.location.href = url.toString();
        }

        function refreshStats() {
            // Simply reload the page to refresh statistics
            window.location.reload();
        }

        // Modal functions
        function showAddSampleModal() {
            const modal = document.getElementById('addSampleModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling

            // Reset form
            document.getElementById('addSampleForm').reset();

            // Set default values
            setDefaultFormValues();
        }

        function hideAddSampleModal() {
            const modal = document.getElementById('addSampleModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        function setDefaultFormValues() {
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('collectDate').value = today;

            // Set default time to current time
            const now = new Date();
            const timeString = now.toTimeString().slice(0, 5);
            document.getElementById('collectTime').value = timeString;

            // Set default status to "collected"
            document.getElementById('status').value = 'collected';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('addSampleModal');
            if (event.target == modal) {
                hideAddSampleModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideAddSampleModal();
            }
        });

        // Removed AJAX submission to avoid JSON usage - form will submit normally

        // Function to view sample details
        function viewSample(sampleId) {
            window.location.href = `facility-test-samples-view.php?id=${encodeURIComponent(sampleId)}`;
        }

        // Function to edit sample
        function editSample(sampleId) {
            window.location.href = `facility-test-samples-edit.php?id=${encodeURIComponent(sampleId)}`;
        }

        // Function to delete sample
        function deleteSample(sampleId) {
            if (confirm('Are you sure you want to delete this sample? This action cannot be undone.')) {
                window.location.href = `controllers/FacilityBasedTestSamplesController.php?action=delete&id=${encodeURIComponent(sampleId)}&confirm=yes`;
            }
        }

        // Function to show success alert
        function showSuccessAlert(message) {
            // Remove any existing alerts
            const existingAlerts = document.querySelectorAll('.alert-success');
            existingAlerts.forEach(alert => alert.remove());

            // Create success alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle"></i> ${message}
            `;

            // Insert after the back button
            const backButton = document.querySelector('.back-button');
            backButton.insertAdjacentElement('afterend', alertDiv);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>
