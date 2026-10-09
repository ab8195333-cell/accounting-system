<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نظام المحاسبة المالي - Laravel</title>

    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #1e293b;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background: #334155;
        }
        .sidebar .nav-link i {
            width: 25px;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .tree-view ul {
            list-style-type: none;
            padding-right: 20px;
        }
        .tree-view li {
            margin: 8px 0;
            position: relative;
        }
        .badge-account {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- القائمة الجانبية Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-3 collapse d-md-block" id="sidebarMenu">
            <div class="d-flex align-items-center mb-4 px-2">
                <i class="fa-solid fa-calculator text-primary fs-3 me-2"></i>
                <h5 class="fw-bold mb-0 text-white me-2">المحاسب الذكي</h5>
            </div>
            <hr class="text-secondary">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="switchTab('dashboard')">
                        <i class="fa-solid fa-chart-pie"></i> لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('accounts')">
                        <i class="fa-solid fa-sitemap"></i> دليل الحسابات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('journal')">
                        <i class="fa-solid fa-book"></i> قيود اليومية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('trial-balance')">
                        <i class="fa-solid fa-scale-balanced"></i> ميزان المراجعة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('income-statement')">
                        <i class="fa-solid fa-file-invoice-dollar"></i> قائمة الدخل
                    </a>
                </li>
            </ul>
        </div>

        <!-- المحتوى الرئيسي Main Content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">

            <!-- الهيدر العلوي -->
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                <h3 class="h4 fw-bold text-dark" id="page-title">لوحة التحكم المالية</h3>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-primary btn-sm rounded-pill px-3" onclick="switchTab('journal')">
                        <i class="fa-solid fa-plus me-1"></i> قيد جديد
                    </button>
                    <span class="badge bg-light text-dark p-2 border">
                        <i class="fa-regular fa-calendar me-1"></i> <span id="current-date"></span>
                    </span>
                </div>
            </div>

            <!-- TAB 1: Dashboard -->
            <div id="tab-dashboard" class="tab-content">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card p-3 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-bold">إجمالي الأصول</small>
                                    <h4 class="fw-bold text-dark mb-0" id="stat-assets">150,000 $</h4>
                                </div>
                                <div class="stat-icon bg-primary-subtle text-primary">
                                    <i class="fa-solid fa-vault"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-bold">إجمالي الخصوم</small>
                                    <h4 class="fw-bold text-dark mb-0" id="stat-liabilities">30,000 $</h4>
                                </div>
                                <div class="stat-icon bg-danger-subtle text-danger">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-bold">الإيرادات</small>
                                    <h4 class="fw-bold text-dark mb-0" id="stat-revenues">45,000 $</h4>
                                </div>
                                <div class="stat-icon bg-success-subtle text-success">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-bold">المصروفات</small>
                                    <h4 class="fw-bold text-dark mb-0" id="stat-expenses">12,000 $</h4>
                                </div>
                                <div class="stat-icon bg-warning-subtle text-warning">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="fw-bold mb-3">حركة التدفقات النقدية الشهري</h6>
                            <canvas id="cashFlowChart" height="120"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="fw-bold mb-3">آخر القيود المرحّلة</h6>
                            <div class="list-group list-group-flush small" id="recent-entries-list">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <div class="fw-bold">قيد إثبات مبيعات</div>
                                        <small class="text-muted">#JV-1001</small>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">5,000 $</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Chart of Accounts -->
            <div id="tab-accounts" class="tab-content d-none">
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">دليل الحسابات (شجرة الحسابات)</h5>
                        <button class="btn btn-outline-primary btn-sm" onclick="alert('إضافة حساب جديد')">
                            <i class="fa-solid fa-plus me-1"></i> حساب جديد
                        </button>
                    </div>
                    <div class="tree-view border rounded p-3 bg-white">
                        <ul class="m-0 p-0">
                            <li>
                                <i class="fa-solid fa-folder-open text-warning me-1"></i>
                                <strong>1 - الأصول (Assets)</strong>
                                <ul>
                                    <li><i class="fa-regular fa-file-lines me-1"></i> 101 - الصندوق الرئيسي <span class="badge bg-success badge-account me-2">أصول متداولة</span></li>
                                    <li><i class="fa-regular fa-file-lines me-1"></i> 102 - بنك الأهلي <span class="badge bg-success badge-account me-2">أصول متداولة</span></li>
                                </ul>
                            </li>
                            <li class="mt-2">
                                <i class="fa-solid fa-folder-open text-warning me-1"></i>
                                <strong>2 - الخصوم (Liabilities)</strong>
                                <ul>
                                    <li><i class="fa-regular fa-file-lines me-1"></i> 201 - الموردون <span class="badge bg-danger badge-account me-2">خصوم متداولة</span></li>
                                </ul>
                            </li>
                            <li class="mt-2">
                                <i class="fa-solid fa-folder-open text-warning me-1"></i>
                                <strong>4 - الإيرادات (Revenues)</strong>
                                <ul>
                                    <li><i class="fa-regular fa-file-lines me-1"></i> 401 - إيراد مبيعات البرامج <span class="badge bg-info badge-account me-2">إيرادات نشاط</span></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Journal Entries -->
            <div id="tab-journal" class="tab-content d-none">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>إنشاء قيد يومية جديد</h5>
                    <form id="journalForm">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">رقم القيد</label>
                                <input type="text" class="form-control form-control-sm" id="entryNumber" value="JV-1002" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">التاريخ</label>
                                <input type="date" class="form-control form-control-sm" id="entryDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">البيان / الوصف</label>
                                <input type="text" class="form-control form-control-sm" id="entryDescription" placeholder="شرح القيد المحاسبي..." required>
                            </div>
                        </div>

                        <!-- أسطر القيد -->
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-sm align-middle text-center" id="journalTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%;">الحساب</th>
                                        <th style="width: 25%;">مدين ($)</th>
                                        <th style="width: 25%;">دائن ($)</th>
                                        <th style="width: 10%;">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-select form-select-sm account-select" required>
                                                <option value="101">101 - الصندوق الرئيسي</option>
                                                <option value="102">102 - بنك الأهلي</option>
                                                <option value="201">201 - الموردون</option>
                                                <option value="401">401 - إيراد مبيعات البرامج</option>
                                            </select>
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm text-end debit-input" value="0" oninput="calculateTotals()"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm text-end credit-input" value="0" oninput="calculateTotals()"></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="fa-solid fa-trash"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-select form-select-sm account-select" required>
                                                <option value="401">401 - إيراد مبيعات البرامج</option>
                                                <option value="101">101 - الصندوق الرئيسي</option>
                                                <option value="102">102 - بنك الأهلي</option>
                                                <option value="201">201 - الموردون</option>
                                            </select>
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm text-end debit-input" value="0" oninput="calculateTotals()"></td>
                                        <td><input type="number" step="0.01" class="form-control form-control-sm text-end credit-input" value="0" oninput="calculateTotals()"></td>
                                        <td><button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="fa-solid fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light fw-bold">
                                    <tr>
                                        <td>المجموع</td>
                                        <td class="text-end text-primary" id="totalDebit">0.00 $</td>
                                        <td class="text-end text-primary" id="totalCredit">0.00 $</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addRow()">
                                <i class="fa-solid fa-plus me-1"></i> إضافة سطر
                            </button>
                            <div class="d-flex align-items-center gap-3">
                                <span id="balanceBadge" class="badge bg-danger p-2">غير متوازن (الفرق: 0)</span>
                                <button type="button" class="btn btn-success btn-sm px-4" id="saveEntryBtn" disabled onclick="saveJournalEntryLaravel()">
                                    <i class="fa-solid fa-check me-1"></i> حفظ وترحيل القيد
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 4: Trial Balance -->
            <div id="tab-trial-balance" class="tab-content d-none">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">ميزان المراجعة بالأرصدة</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>رقم الحساب</th>
                                    <th>اسم الحساب</th>
                                    <th>مدين ($)</th>
                                    <th>دائن ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>101</td>
                                    <td>الصندوق الرئيسي</td>
                                    <td>125,000.00</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>102</td>
                                    <td>بنك الأهلي</td>
                                    <td>25,000.00</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>201</td>
                                    <td>الموردون</td>
                                    <td>0.00</td>
                                    <td>30,000.00</td>
                                </tr>
                                <tr>
                                    <td>401</td>
                                    <td>إيراد مبيعات البرامج</td>
                                    <td>0.00</td>
                                    <td>45,000.00</td>
                                </tr>
                            </tbody>
                            <tfoot class="table-secondary fw-bold">
                                <tr>
                                    <td colspan="2">الإجمالي</td>
                                    <td class="text-success">150,000.00 $</td>
                                    <td class="text-success">150,000.00 $</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 5: Income Statement -->
            <div id="tab-income-statement" class="tab-content d-none">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">قائمة الدخل (الأرباح والخسائر)</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold text-success">
                            إجمالي الإيرادات
                            <span>45,000 $</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold text-danger">
                            إجمالي المصروفات
                            <span>(12,000 $)</span>
                        </li>
                    </ul>
                    <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">صافي الربح:</h6>
                        <h5 class="fw-bold text-primary mb-0">33,000 $</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Set Current Date
    document.getElementById('current-date').innerText = new Date().toISOString().split('T')[0];
    document.getElementById('entryDate').value = new Date().toISOString().split('T')[0];

    // Navigation Switcher
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
        document.querySelectorAll('.sidebar .nav-link').forEach(el => el.classList.remove('active'));

        document.getElementById(`tab-${tabId}`).classList.remove('d-none');
        event.currentTarget.classList.add('active');

        const titles = {
            'dashboard': 'لوحة التحكم المالية',
            'accounts': 'دليل الحسابات',
            'journal': 'قيود اليومية',
            'trial-balance': 'ميزان المراجعة',
            'income-statement': 'قائمة الدخل'
        };
        document.getElementById('page-title').innerText = titles[tabId];
    }

    // Dynamic Row Actions
    function addRow() {
        const tbody = document.querySelector('#journalTable tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-select form-select-sm account-select" required>
    <option value="1">101 - الصندوق الرئيسي</option>
    <option value="2">102 - بنك الأهلي</option>
    <option value="3">201 - الموردون</option>
    <option value="4">401 - إيراد مبيعات البرامج</option>
</select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm text-end debit-input" value="0" oninput="calculateTotals()"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm text-end credit-input" value="0" oninput="calculateTotals()"></td>
            <td><button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="fa-solid fa-trash"></i></button></td>
        `;
        tbody.appendChild(newRow);
    }

    function removeRow(btn) {
        const tbody = document.querySelector('#journalTable tbody');
        if (tbody.children.length > 2) {
            btn.closest('tr').remove();
            calculateTotals();
        } else {
            alert('يجب أن يحتوي القيد على سطرين على الأقل (مدين ودائن)');
        }
    }

    // Real-time Double-Entry Balance Calculation
    function calculateTotals() {
        let totalDebit = 0;
        let totalCredit = 0;

        document.querySelectorAll('.debit-input').forEach(input => totalDebit += parseFloat(input.value) || 0);
        document.querySelectorAll('.credit-input').forEach(input => totalCredit += parseFloat(input.value) || 0);

        document.getElementById('totalDebit').innerText = totalDebit.toFixed(2) + ' $';
        document.getElementById('totalCredit').innerText = totalCredit.toFixed(2) + ' $';

        const diff = Math.abs(totalDebit - totalCredit);
        const balanceBadge = document.getElementById('balanceBadge');
        const saveBtn = document.getElementById('saveEntryBtn');

        if (diff < 0.001 && totalDebit > 0) {
            balanceBadge.className = 'badge bg-success p-2';
            balanceBadge.innerText = 'القيد متوازن';
            saveBtn.disabled = false;
        } else {
            balanceBadge.className = 'badge bg-danger p-2';
            balanceBadge.innerText = `غير متوازن (الفرق: ${diff.toFixed(2)})`;
            saveBtn.disabled = true;
        }
    }

    // Chart.js initialization
    const ctx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
            datasets: [
                { label: 'المقبوضات', data: [12000, 19000, 15000, 25000, 22000, 30000], backgroundColor: '#0d6efd' },
                { label: 'المصروفات', data: [8000, 11000, 9000, 14000, 10000, 12000], backgroundColor: '#dc3545' }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Laravel API Integration Call
   async function saveJournalEntryLaravel() {
    const entryNumber = document.getElementById('entryNumber').value;
    const date = document.getElementById('entryDate').value;
    const description = document.getElementById('entryDescription').value;

    const items = [];
    document.querySelectorAll('#journalTable tbody tr').forEach(row => {
        const account_id = row.querySelector('.account-select').value;
        const debit = parseFloat(row.querySelector('.debit-input').value) || 0;
        const credit = parseFloat(row.querySelector('.credit-input').value) || 0;
        items.push({ account_id, debit, credit });
    });

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch('/api/journal-entries', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ entry_number: entryNumber, date, description, items })
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message || 'تم حفظ القيد المحاسبي بنجاح!');
            location.reload();
        } else {
            // إظهار رسالة الخطأ القادمة من لارافيل
            alert('خطأ من السيرفر (' + response.status + '): ' + (result.message || JSON.stringify(result)));
        }
    } catch (error) {
        console.error('Network/Parsing Error:', error);
        alert('حدث خطأ في الاتصال: ' + error.message);
    }
}

</script>

</body>
</html>