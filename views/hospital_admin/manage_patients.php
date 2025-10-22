<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Patients - HIVeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/HIV/systemadmin/public/css/style.css">
  <style>
    /* Main container */
<<<<<<< HEAD
    .main-container { max-width: 1200px; margin: 40px auto; padding: 20px; }
=======
    .main-container { max-width: 1400px; margin: 40px auto; padding: 20px; }
>>>>>>> origin/main

    /* Stats */
    .stats { display: flex; gap: 20px; margin-bottom: 30px; }
    .stat-box { flex: 1; background: #fff; padding: 20px; text-align: center; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .stat-number { font-size: 28px; font-weight: bold; }

    /* Filters */
<<<<<<< HEAD
    .filters { display: flex; gap: 10px; margin-bottom: 30px; }
    .filters input, .filters select { padding: 8px 10px; border-radius: 5px; border: 1px solid #ccc; flex: 1; }
    .filter-btn { padding: 8px 15px; background: #1d3557; color: #fff; border: none; border-radius: 5px; cursor: pointer; }

    /* Patient Cards */
    .hospital-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
    .hospital-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .hospital-card h3 { margin-top: 0; margin-bottom: 10px; font-size: 18px; }
    .hospital-card p { margin: 6px 0; font-size: 14px; }
    .hospital-card .status { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-top: 8px; }
    .status.Active { background-color: #2a9d8f; color: #fff; }
    .status.Pending { background-color: #e9c46a; color: #000; }
    .status.Inactive { background-color: #f4a261; color: #fff; }

    /* Action Buttons */
    .actions { margin-top: 12px; }
    .actions a { text-decoration: none; color: #fff; padding: 6px 12px; border-radius: 5px; font-size: 13px; margin-right: 5px; display: inline-block; }
    .btn-view { background: #1d3557; }
    .btn-edit { background: #457b9d; }
    .btn-delete { background: #e63946; }
    .btn-view:hover { background: #0f2f4d; }
    .btn-edit:hover { background: #1a5276; }
    .btn-delete:hover { background: #c5303f; }

    /* Form-style layout inside cards */
    .hospital-card label { display: block; font-weight: 600; font-size: 12px; margin-top: 10px; color: #555; }
    .hospital-card .field-value { font-size: 14px; padding: 6px 10px; background: #f4f6f9; border-radius: 5px; margin-top: 3px; }
=======
    .filters { display: flex; gap: 15px; margin-bottom: 30px; align-items: center; }
    .filters input, .filters select { padding: 10px 12px; border-radius: 5px; border: 1px solid #ccc; flex: 1; }
    .filter-btn { padding: 10px 20px; background: #1d3557; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; }
    .filter-btn:hover { background: #0f2f4d; }
    .clear-filters { padding: 10px 15px; background: #6c757d; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; }
    .clear-filters:hover { background: #5a6268; }

    /* Enhanced Table */
    .patients-table { width: 100%; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden; }
    .patients-table thead { background: #1d3557; color: #fff; }
    .patients-table th { padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; border: none; }
    .patients-table th.sortable { cursor: pointer; user-select: none; position: relative; }
    .patients-table th.sortable:hover { background: #0f2f4d; }
    .patients-table th.sortable::after { content: '⇅'; margin-left: 8px; opacity: 0.7; }
    .patients-table th.sort-asc::after { content: '↑'; }
    .patients-table th.sort-desc::after { content: '↓'; }
    .patients-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: background-color 0.2s; }
    .patients-table tbody tr:hover { background-color: #f8f9fa; }
    .patients-table td { padding: 12px; font-size: 14px; vertical-align: middle; }
    .patient-name { font-weight: 600; color: #1d3557; }
    .patient-id { color: #6c757d; font-family: monospace; }
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-align: center; min-width: 70px; }
    .status-Active { background-color: #d4edda; color: #155724; }
    .status-Pending { background-color: #fff3cd; color: #856404; }
    .status-Inactive { background-color: #f8d7da; color: #721c24; }

    /* Action Buttons */
    .action-buttons { display: flex; gap: 8px; justify-content: center; }
    .btn-action { padding: 6px 12px; border-radius: 4px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s; }
    .btn-view { background: #1d3557; color: #fff; }
    .btn-view:hover { background: #0f2f4d; transform: translateY(-1px); }
    .btn-edit { background: #457b9d; color: #fff; }
    .btn-edit:hover { background: #1a5276; transform: translateY(-1px); }
    .btn-delete { background: #e63946; color: #fff; }
    .btn-delete:hover { background: #c5303f; transform: translateY(-1px); }

    /* Pagination */
    .pagination { display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 30px; }
    .pagination-btn { padding: 8px 12px; border: 1px solid #ccc; background: #fff; color: #1d3557; border-radius: 4px; cursor: pointer; text-decoration: none; }
    .pagination-btn:hover { background: #1d3557; color: #fff; }
    .pagination-btn.active { background: #1d3557; color: #fff; border-color: #1d3557; }
    .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .pagination-info { color: #6c757d; font-size: 14px; }

    /* Responsive Design */
    @media (max-width: 768px) {
      .main-container { margin: 20px auto; padding: 15px; }
      .stats { flex-direction: column; gap: 15px; }
      .filters { flex-direction: column; gap: 10px; }
      .patients-table { font-size: 12px; }
      .patients-table th, .patients-table td { padding: 8px 6px; }
      .action-buttons { flex-wrap: wrap; }
      .btn-action { font-size: 11px; padding: 4px 8px; }
    }

    /* Loading state */
    .loading { text-align: center; padding: 40px; color: #6c757d; }
    .spinner { border: 3px solid #f3f3f3; border-top: 3px solid #1d3557; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; margin: 0 auto 15px; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Empty state */
    .empty-state { text-align: center; padding: 60px 20px; color: #6c757d; }
    .empty-state i { font-size: 48px; margin-bottom: 15px; color: #dee2e6; }
>>>>>>> origin/main
  </style>
</head>
<body>

<header class="header">
  <h1><i class="fas fa-hospital-user"></i> Manage Patients</h1>
  <a href="index.php?action=hospitalAdminDashboard" class="back-link">Back to Dashboard</a>
</header>

<div class="main-container">

  <!-- Stats -->
  <div class="stats">
    <div class="stat-box">
      <div class="stat-number">12</div>
      <div>Active Patients</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">3</div>
      <div>Pending Patients</div>
    </div>
    <div class="stat-box">
      <div class="stat-number">1</div>
      <div>Inactive Patients</div>
    </div>
  </div>

<<<<<<< HEAD
  <!-- Filter -->
  <form class="filters">
    <input type="text" placeholder="Search patient...">
    <select aria-label="Filter status">
      <option>All</option>
      <option>Active</option>
      <option>Pending</option>
      <option>Inactive</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- Patient Cards -->
  <div class="hospital-grid">

    <!-- Example Patient Card -->
    <div class="hospital-card">
      <h3>John Doe</h3>
      <label>Patient ID</label>
      <div class="field-value">1</div>

      <label>Email</label>
      <div class="field-value">john@example.com</div>

      <label>Contact Number</label>
      <div class="field-value">0771234567</div>

      <label>Date of Birth</label>
      <div class="field-value">1990-01-01</div>

      <label>Gender</label>
      <div class="field-value">Male</div>

      <label>Registered At</label>
      <div class="field-value">2024-01-15</div>

      <label>Status</label>
      <span class="status Active">Active</span>

      <div class="actions">
        <a href="#" class="btn-view"><i class="fas fa-eye"></i> View History</a>
        <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
        <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>

    <div class="hospital-card">
      <h3>Jane Smith</h3>
      <label>Patient ID</label>
      <div class="field-value">2</div>

      <label>Email</label>
      <div class="field-value">jane@example.com</div>

      <label>Contact Number</label>
      <div class="field-value">0719876543</div>

      <label>Date of Birth</label>
      <div class="field-value">1992-05-15</div>

      <label>Gender</label>
      <div class="field-value">Female</div>

      <label>Registered At</label>
      <div class="field-value">2024-03-01</div>

      <label>Status</label>
      <span class="status Pending">Pending</span>

      <div class="actions">
        <a href="#" class="btn-view"><i class="fas fa-eye"></i> View History</a>
        <a href="#" class="btn-edit"><i class="fas fa-edit"></i> Update</a>
        <a href="#" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>

    <!-- Add more patient cards dynamically as needed -->

  </div> <!-- .hospital-grid -->

</div> <!-- .main-container -->

=======
  <!-- Enhanced Filters -->
  <form class="filters" id="patientFilters">
    <input type="text" id="searchInput" placeholder="Search patients by name, ID, or email..." />
    <select id="statusFilter" aria-label="Filter by status">
      <option value="">All Statuses</option>
      <option value="Active">Active</option>
      <option value="Pending">Pending</option>
      <option value="Inactive">Inactive</option>
    </select>
    <button type="submit" class="filter-btn">
      <i class="fas fa-search"></i> Filter
    </button>
    <button type="button" class="clear-filters" id="clearFilters">
      <i class="fas fa-times"></i> Clear
    </button>
  </form>

  <!-- Enhanced Patients Table -->
  <div class="table-container">
    <table class="patients-table" id="patientsTable">
      <thead>
        <tr>
          <th class="sortable" data-column="name">Patient Name</th>
          <th class="sortable" data-column="id">Patient ID</th>
          <th class="sortable" data-column="email">Email</th>
          <th>Contact Number</th>
          <th class="sortable" data-column="dob">Date of Birth</th>
          <th>Gender</th>
          <th class="sortable" data-column="registered">Registered Date</th>
          <th class="sortable" data-column="status">Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="patientsTableBody">
        <!-- Patient data will be populated here -->
        <tr>
          <td class="patient-name">John Doe</td>
          <td class="patient-id">1</td>
          <td>john@example.com</td>
          <td>0771234567</td>
          <td>1990-01-01</td>
          <td>Male</td>
          <td>2024-01-15</td>
          <td><span class="status-badge status-Active">Active</span></td>
          <td>
            <div class="action-buttons">
              <a href="#" class="btn-action btn-view" title="View History">
                <i class="fas fa-eye"></i> View
              </a>
              <a href="#" class="btn-action btn-edit" title="Update Patient">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="#" class="btn-action btn-delete" title="Delete Patient" onclick="return confirm('Are you sure you want to delete this patient?')">
                <i class="fas fa-trash"></i> Delete
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td class="patient-name">Jane Smith</td>
          <td class="patient-id">2</td>
          <td>jane@example.com</td>
          <td>0719876543</td>
          <td>1992-05-15</td>
          <td>Female</td>
          <td>2024-03-01</td>
          <td><span class="status-badge status-Pending">Pending</span></td>
          <td>
            <div class="action-buttons">
              <a href="#" class="btn-action btn-view" title="View History">
                <i class="fas fa-eye"></i> View
              </a>
              <a href="#" class="btn-action btn-edit" title="Update Patient">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="#" class="btn-action btn-delete" title="Delete Patient" onclick="return confirm('Are you sure you want to delete this patient?')">
                <i class="fas fa-trash"></i> Delete
              </a>
            </div>
          </td>
        </tr>
        <!-- Add more patient rows dynamically as needed -->
      </tbody>
    </table>

    <!-- Loading State -->
    <div class="loading" id="loadingIndicator" style="display: none;">
      <div class="spinner"></div>
      <p>Loading patients...</p>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="emptyState" style="display: none;">
      <i class="fas fa-users"></i>
      <h3>No patients found</h3>
      <p>No patients match your current search criteria.</p>
    </div>
  </div>

  <!-- Pagination -->
  <div class="pagination" id="paginationControls" style="display: none;">
    <button class="pagination-btn" id="prevPage" disabled>
      <i class="fas fa-chevron-left"></i> Previous
    </button>
    <span class="pagination-info" id="paginationInfo">Page 1 of 1</span>
    <button class="pagination-btn" id="nextPage" disabled>
      Next <i class="fas fa-chevron-right"></i>
    </button>
  </div>

</div> <!-- .main-container -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Patient data (in a real application, this would come from a server)
    let patients = [
        { name: 'John Doe', id: '1', email: 'john@example.com', contact: '0771234567', dob: '1990-01-01', gender: 'Male', registered: '2024-01-15', status: 'Active' },
        { name: 'Jane Smith', id: '2', email: 'jane@example.com', contact: '0719876543', dob: '1992-05-15', gender: 'Female', registered: '2024-03-01', status: 'Pending' },
        { name: 'Michael Johnson', id: '3', email: 'michael@example.com', contact: '0785556666', dob: '1985-12-10', gender: 'Male', registered: '2024-02-20', status: 'Active' },
        { name: 'Sarah Wilson', id: '4', email: 'sarah@example.com', contact: '0701112222', dob: '1988-08-25', gender: 'Female', registered: '2024-01-30', status: 'Active' },
        { name: 'David Brown', id: '5', email: 'david@example.com', contact: '0757778888', dob: '1995-03-12', gender: 'Male', registered: '2024-03-15', status: 'Pending' }
    ];

    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredPatients = [...patients];
    let currentSort = { column: 'name', direction: 'asc' };

    // DOM elements
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const patientsTableBody = document.getElementById('patientsTableBody');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const emptyState = document.getElementById('emptyState');
    const paginationControls = document.getElementById('paginationControls');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const paginationInfo = document.getElementById('paginationInfo');

    // Initialize the table
    function init() {
        renderTable();
        setupEventListeners();
    }

    // Render the patients table
    function renderTable() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pagePatients = filteredPatients.slice(startIndex, endIndex);

        patientsTableBody.innerHTML = '';

        if (pagePatients.length === 0) {
            showEmptyState();
            return;
        }

        hideEmptyState();
        pagePatients.forEach(patient => {
            const row = createPatientRow(patient);
            patientsTableBody.appendChild(row);
        });

        updatePagination();
    }

    // Create a table row for a patient
    function createPatientRow(patient) {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td class="patient-name">${patient.name}</td>
            <td class="patient-id">${patient.id}</td>
            <td>${patient.email}</td>
            <td>${patient.contact}</td>
            <td>${formatDate(patient.dob)}</td>
            <td>${patient.gender}</td>
            <td>${formatDate(patient.registered)}</td>
            <td><span class="status-badge status-${patient.status}">${patient.status}</span></td>
            <td>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-view" title="View History">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="#" class="btn-action btn-edit" title="Update Patient">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="#" class="btn-action btn-delete" title="Delete Patient" onclick="return confirm('Are you sure you want to delete this patient?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </td>
        `;

        return row;
    }

    // Format date for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    // Filter patients based on search and status
    function filterPatients() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        filteredPatients = patients.filter(patient => {
            const matchesSearch = patient.name.toLowerCase().includes(searchTerm) ||
                                patient.id.toLowerCase().includes(searchTerm) ||
                                patient.email.toLowerCase().includes(searchTerm);

            const matchesStatus = !statusValue || patient.status === statusValue;

            return matchesSearch && matchesStatus;
        });

        currentPage = 1;
        renderTable();
    }

    // Sort patients
    function sortPatients(column) {
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'asc';
        }

        filteredPatients.sort((a, b) => {
            let aVal = a[column];
            let bVal = b[column];

            // Handle different data types
            if (column === 'dob' || column === 'registered') {
                aVal = new Date(aVal);
                bVal = new Date(bVal);
            } else if (typeof aVal === 'string') {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }

            if (aVal < bVal) return currentSort.direction === 'asc' ? -1 : 1;
            if (aVal > bVal) return currentSort.direction === 'asc' ? 1 : -1;
            return 0;
        });

        updateSortIndicators();
        renderTable();
    }

    // Update sort indicators in table headers
    function updateSortIndicators() {
        const headers = document.querySelectorAll('.sortable');
        headers.forEach(header => {
            header.classList.remove('sort-asc', 'sort-desc');
            if (header.dataset.column === currentSort.column) {
                header.classList.add(`sort-${currentSort.direction}`);
            }
        });
    }

    // Update pagination controls
    function updatePagination() {
        const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);

        if (totalPages <= 1) {
            paginationControls.style.display = 'none';
            return;
        }

        paginationControls.style.display = 'flex';
        paginationInfo.textContent = `Page ${currentPage} of ${totalPages}`;

        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
    }

    // Show empty state
    function showEmptyState() {
        patientsTableBody.innerHTML = '';
        emptyState.style.display = 'block';
        paginationControls.style.display = 'none';
    }

    // Hide empty state
    function hideEmptyState() {
        emptyState.style.display = 'none';
    }

    // Setup event listeners
    function setupEventListeners() {
        // Search input
        searchInput.addEventListener('input', debounce(filterPatients, 300));

        // Status filter
        statusFilter.addEventListener('change', filterPatients);

        // Clear filters
        clearFiltersBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            filterPatients();
        });

        // Sortable headers
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                sortPatients(this.dataset.column);
            });
        });

        // Pagination
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        nextPageBtn.addEventListener('click', function() {
            const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });
    }

    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Start the application
    init();
});
</script>

>>>>>>> origin/main
</body>
</html>
