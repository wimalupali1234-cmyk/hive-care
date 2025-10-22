<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Sample - HIVeCare</title>
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

        .form-help {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .form-help h4 {
            color: #031e46;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .form-help p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
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
            <h1><i class="fas fa-plus"></i> Add New Test Sample</h1>
            <p>Enter the details of a new facility-based test sample</p>
        </div>

        <div class="breadcrumb">
            <a href="lab-tech-dashboard.html">Dashboard</a> >
            <a href="lab-tech-samples.html">Samples</a> >
            <a href="facility-test-samples.php">Facility Based Testing</a> >
            <strong>Add Sample</strong>
        </div>

        <button class="back-button" onclick="window.location.href='facility-test-samples.php'">
            <i class="fas fa-arrow-left"></i> Back to Samples
        </button>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="form-help">
            <h4><i class="fas fa-info-circle"></i> Sample Information Guidelines</h4>
            <p>Please ensure all information is accurate. Sample IDs will be auto-generated. Make sure to collect samples following proper protocols and maintain chain of custody.</p>
        </div>

        <form action="facility-test-samples.php?action=add" method="POST" class="form-card">
            <div class="form-header">
                <h1>Sample Details</h1>
                <p>Fill in the information for the new test sample</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="sample-type">Sample Type <span class="required">*</span></label>
                    <select id="sample-type" name="sampleType" required>
                        <option value="">Select sample type</option>
                        <option value="Blood Sample">Blood Sample</option>
                        <option value="Oral Fluid">Oral Fluid</option>
                        <option value="Urine Sample">Urine Sample</option>
                        <option value="Dried Blood Spot">Dried Blood Spot</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="patient-id">Patient ID <span class="required">*</span></label>
                    <input type="text" id="patient-id" name="patientId" required
                           placeholder="Enter patient ID (e.g., P2025001)">
                </div>

                <div class="form-group">
                    <label for="collect-date">Collection Date <span class="required">*</span></label>
                    <input type="date" id="collect-date" name="collectDate" required
                           max="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="collect-time">Collection Time <span class="required">*</span></label>
                    <input type="time" id="collect-time" name="collectTime" required>
                </div>

                <div class="form-group">
                    <label for="collected-by">Collected By <span class="required">*</span></label>
                    <input type="text" id="collected-by" name="collectedBy" required
                           placeholder="Enter your name or ID">
                </div>

                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes"
                              placeholder="Enter any additional notes or observations about the sample"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='facility-test-samples.php'">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Sample
                </button>
            </div>
        </form>
    </div>

    <?php include 'footer.html'; ?>

    <script>
        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('collect-date').value = today;

            // Set default time to current time
            const now = new Date();
            const timeString = now.toTimeString().slice(0, 5);
            document.getElementById('collect-time').value = timeString;
        });

        // Form validation
        document.getElementById('sample-type').addEventListener('change', function() {
            if (this.value === 'Other') {
                // Could add a text input for custom sample type
                console.log('Custom sample type selected');
            }
        });
    </script>
</body>
</html>
