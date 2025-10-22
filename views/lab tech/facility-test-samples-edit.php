<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sample - HIVeCare</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            max-width: 800px;
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

        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 40px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            color: #031e46;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .form-header p {
            color: #666;
            font-size: 16px;
        }

        .sample-info {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .sample-info h3 {
            color: #031e46;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .sample-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .sample-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sample-info-label {
            font-weight: 600;
            color: #666;
        }

        .sample-info-value {
            color: #031e46;
            font-weight: 500;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
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

        .form-group input[readonly] {
            background-color: #f8f9fa;
            color: #666;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .required {
            color: #e74c3c;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
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

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
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

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            .form-card {
                padding: 25px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .sample-info-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>

    <div class="form-container">
        <div class="page-header">
            <h1><i class="fas fa-edit"></i> Edit Test Sample</h1>
            <p>Update the details of an existing test sample</p>
        </div>

        <div class="breadcrumb">
            <a href="lab-tech-dashboard.html">Dashboard</a> >
            <a href="lab-tech-samples.html">Samples</a> >
            <a href="facility-test-samples.php">Facility Based Testing</a> >
            <strong>Edit Sample</strong>
        </div>

        <button class="back-button" onclick="window.location.href='facility-test-samples.php'">
            <i class="fas fa-arrow-left"></i> Back to Samples
        </button>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="facility-test-samples.php?action=update" method="POST" class="form-card">
            <input type="hidden" name="sample_id" value="<?php echo htmlspecialchars($sample['sample_id']); ?>">

            <div class="form-header">
                <h1>Edit Sample: <?php echo htmlspecialchars($sample['sample_id']); ?></h1>
                <p>Update the sample information below</p>
            </div>

            <div class="sample-info">
                <h3><i class="fas fa-info-circle"></i> Current Sample Information</h3>
                <div class="sample-info-grid">
                    <div class="sample-info-item">
                        <span class="sample-info-label">Sample ID:</span>
                        <span class="sample-info-value" style="font-family: monospace;"><?php echo htmlspecialchars($sample['sample_id']); ?></span>
                    </div>
                    <div class="sample-info-item">
                        <span class="sample-info-label">Created:</span>
                        <span class="sample-info-value"><?php echo date('Y-m-d H:i', strtotime($sample['created_at'])); ?></span>
                    </div>
                    <div class="sample-info-item">
                        <span class="sample-info-label">Last Updated:</span>
                        <span class="sample-info-value"><?php echo date('Y-m-d H:i', strtotime($sample['updated_at'])); ?></span>
                    </div>
                    <div class="sample-info-item">
                        <span class="sample-info-label">Current Status:</span>
                        <span class="sample-info-value">
                            <span style="background: <?php
                                echo match(strtolower($sample['status'])) {
                                    'pending' => '#fff3cd',
                                    'processing' => '#cce7ff',
                                    'completed' => '#d4edda',
                                    'rejected' => '#f8d7da',
                                    default => '#e9ecef'
                                };
                            ?>; color: <?php
                                echo match(strtolower($sample['status'])) {
                                    'pending' => '#856404',
                                    'processing' => '#0066cc',
                                    'completed' => '#155724',
                                    'rejected' => '#721c24',
                                    default => '#495057'
                                };
                            ?>; padding: 4px 8px; border-radius: 12px; font-size: 12px; text-transform: uppercase;">
                                <?php echo htmlspecialchars($sample['status']); ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="sample-type">Sample Type <span class="required">*</span></label>
                    <select id="sample-type" name="sampleType" required>
                        <option value="">Select sample type</option>
                        <option value="Blood Sample" <?php echo ($sample['sample_type'] === 'Blood Sample') ? 'selected' : ''; ?>>Blood Sample</option>
                        <option value="Oral Fluid" <?php echo ($sample['sample_type'] === 'Oral Fluid') ? 'selected' : ''; ?>>Oral Fluid</option>
                        <option value="Urine Sample" <?php echo ($sample['sample_type'] === 'Urine Sample') ? 'selected' : ''; ?>>Urine Sample</option>
                        <option value="Dried Blood Spot" <?php echo ($sample['sample_type'] === 'Dried Blood Spot') ? 'selected' : ''; ?>>Dried Blood Spot</option>
                        <option value="Other" <?php echo ($sample['sample_type'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="patient-id">Patient ID <span class="required">*</span></label>
                    <input type="text" id="patient-id" name="patientId" required
                           value="<?php echo htmlspecialchars($sample['patient_id']); ?>"
                           placeholder="Enter patient ID">
                </div>

                <div class="form-group">
                    <label for="collect-date">Collection Date <span class="required">*</span></label>
                    <input type="date" id="collect-date" name="collectDate" required
                           value="<?php echo htmlspecialchars($sample['collect_date']); ?>"
                           max="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="collect-time">Collection Time <span class="required">*</span></label>
                    <input type="time" id="collect-time" name="collectTime" required
                           value="<?php echo htmlspecialchars($sample['collect_time']); ?>">
                </div>

                <div class="form-group">
                    <label for="collected-by">Collected By <span class="required">*</span></label>
                    <input type="text" id="collected-by" name="collectedBy" required
                           value="<?php echo htmlspecialchars($sample['collected_by']); ?>"
                           placeholder="Enter collector name or ID">
                </div>

                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="pending" <?php echo ($sample['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo ($sample['status'] === 'processing') ? 'selected' : ''; ?>>Processing</option>
                        <option value="completed" <?php echo ($sample['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="rejected" <?php echo ($sample['status'] === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes"
                              placeholder="Enter any additional notes or observations about the sample"><?php echo htmlspecialchars($sample['notes'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='facility-test-samples.php'">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Sample
                </button>
            </div>
        </form>
    </div>

    <?php include 'footer.html'; ?>
</body>
</html>
