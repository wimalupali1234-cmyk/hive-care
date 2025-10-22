<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sample - HIVeCare</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .view-container {
            max-width: 900px;
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

        .sample-details-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .sample-header {
            background: linear-gradient(135deg, #031e46 0%, #6b8cae 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .sample-id {
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .sample-body {
            padding: 30px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #031e46;
        }

        .detail-section h3 {
            color: #031e46;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
        }

        .detail-value {
            color: #031e46;
            font-weight: 500;
        }

        .status-section {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cce7ff;
            color: #0066cc;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .notes-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .notes-section h3 {
            color: #031e46;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .notes-content {
            color: #666;
            line-height: 1.6;
            font-style: italic;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 12px 25px;
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

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
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

        .sample-meta {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }

        .sample-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .view-container {
                padding: 15px;
            }

            .details-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .sample-meta-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .sample-header {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>

    <div class="view-container">
        <div class="page-header">
            <h1><i class="fas fa-eye"></i> Sample Details</h1>
            <p>View detailed information about the test sample</p>
        </div>

        <div class="breadcrumb">
            <a href="lab-tech-dashboard.html">Dashboard</a> >
            <a href="lab-tech-samples.html">Samples</a> >
            <a href="facility-test-samples.php">Facility Based Testing</a> >
            <strong>View Sample</strong>
        </div>

        <button class="back-button" onclick="window.location.href='facility-test-samples.php'">
            <i class="fas fa-arrow-left"></i> Back to Samples
        </button>

        <div class="sample-details-card">
            <div class="sample-header">
                <h2><i class="fas fa-vial"></i> Test Sample Information</h2>
                <div class="sample-id"><?php echo htmlspecialchars($sample['sample_id']); ?></div>
            </div>

            <div class="sample-body">
                <div class="sample-meta">
                    <div class="sample-meta-grid">
                        <div class="meta-item">
                            <span>Created:</span>
                            <span><?php echo date('Y-m-d H:i:s', strtotime($sample['created_at'])); ?></span>
                        </div>
                        <div class="meta-item">
                            <span>Last Updated:</span>
                            <span><?php echo date('Y-m-d H:i:s', strtotime($sample['updated_at'])); ?></span>
                        </div>
                    </div>
                </div>

                <div class="details-grid">
                    <div class="detail-section">
                        <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
                        <div class="detail-item">
                            <span class="detail-label">Sample Type:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($sample['sample_type']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Patient ID:</span>
                            <span class="detail-value" style="font-family: monospace;"><?php echo htmlspecialchars($sample['patient_id']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Collection Date:</span>
                            <span class="detail-value"><?php echo date('F j, Y', strtotime($sample['collect_date'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Collection Time:</span>
                            <span class="detail-value"><?php echo date('g:i A', strtotime($sample['collect_time'])); ?></span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3><i class="fas fa-user-md"></i> Collection Information</h3>
                        <div class="detail-item">
                            <span class="detail-label">Collected By:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($sample['collected_by']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="status-badge status-<?php echo strtolower($sample['status']); ?>">
                                    <i class="fas fa-circle"></i>
                                    <?php echo htmlspecialchars($sample['status']); ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <?php if (!empty($sample['notes'])): ?>
                    <div class="notes-section">
                        <h3><i class="fas fa-sticky-note"></i> Notes</h3>
                        <div class="notes-content">
                            <?php echo nl2br(htmlspecialchars($sample['notes'])); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="status-section">
                    <h3>Current Status</h3>
                    <div class="status-badge status-<?php echo strtolower($sample['status']); ?>">
                        <i class="fas fa-circle"></i>
                        <?php echo htmlspecialchars($sample['status']); ?>
                    </div>
                    <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
                        Sample is currently <?php echo strtolower($sample['status']); ?> for processing
                    </p>
                </div>

                <div class="action-buttons">
                    <a href="facility-test-samples.php?action=edit&id=<?php echo urlencode($sample['sample_id']); ?>"
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Sample
                    </a>

                    <button class="btn btn-primary" onclick="updateStatus('processing')">
                        <i class="fas fa-play"></i> Start Processing
                    </button>

                    <button class="btn btn-success" onclick="updateStatus('completed')">
                        <i class="fas fa-check"></i> Mark Complete
                    </button>

                    <a href="facility-test-samples.php?action=delete&id=<?php echo urlencode($sample['sample_id']); ?>&confirm=yes"
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this sample? This action cannot be undone.')">
                        <i class="fas fa-trash"></i> Delete Sample
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.html'; ?>

    <script>
        function updateStatus(newStatus) {
            if (confirm(`Are you sure you want to mark this sample as ${newStatus}?`)) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'facility-test-samples.php?action=update_status';

                const sampleIdInput = document.createElement('input');
                sampleIdInput.type = 'hidden';
                sampleIdInput.name = 'sample_id';
                sampleIdInput.value = '<?php echo $sample['sample_id']; ?>';

                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = newStatus;

                form.appendChild(sampleIdInput);
                form.appendChild(statusInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(function() {
            // Optionally refresh the page to show updated status
            // window.location.reload();
        }, 30000);
    </script>
</body>
</html>
