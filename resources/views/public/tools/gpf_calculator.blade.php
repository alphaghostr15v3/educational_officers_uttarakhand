@extends('layouts.public')

@section('content')
<div class="bg-primary text-white py-5 mb-5 shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold">GPF Calculator</h1>
                <p class="lead mb-0">Calculate your General Provident Fund (GPF) interest and closing balance for the financial year.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('tools.index') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left me-2"></i> Back to Tools</a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <!-- Input Section -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="fw-bold mb-0 text-primary">Calculator Inputs</h5>
                </div>
                <div class="card-body p-4">
                    <form id="gpfForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Financial Year Opening Balance (₹)</label>
                            <input type="number" id="openingBalance" class="form-control" placeholder="Enter opening balance" value="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Monthly Subscription (₹)</label>
                            <input type="number" id="monthlySub" class="form-control" placeholder="Monthly contribution" value="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Voluntary Subscription (₹)</label>
                            <input type="number" id="voluntarySub" class="form-control" placeholder="Additonal VGPF" value="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Monthly Withdrawals (₹)</label>
                            <input type="number" id="withdrawals" class="form-control" placeholder="Monthly withdrawal amount" value="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Refund of Advance (₹)</label>
                            <input type="number" id="refunds" class="form-control" placeholder="Refund amount" value="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Interest Rate (%)</label>
                            <input type="number" id="interestRate" class="form-control" value="7.1" step="0.1">
                            <div class="form-text text-muted small">Current GPF interest rate is usually updated quarterly by the government.</div>
                        </div>
                        <button type="button" onclick="calculateGPF()" class="btn btn-primary w-100 py-2 fw-bold shadow-sm mt-3">
                            <i class="fas fa-calculator me-2"></i> Calculate
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="fw-bold mb-0 text-primary">Summary Report</h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 bg-light border-bottom">
                        <div class="row g-3 text-center">
                            <div class="col-md-4">
                                <div class="px-2">
                                    <div class="text-muted small mb-1">Total Deposits</div>
                                    <div class="h5 fw-bold text-success mb-0">₹<span id="resTotalDeposits">0</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="px-2">
                                    <div class="text-muted small mb-1">Total Interest</div>
                                    <div class="h5 fw-bold text-primary mb-0">₹<span id="resTotalInterest">0</span></div>
                                </div>
                            </div>
                            <div class="col-md-4 border-start">
                                <div class="px-2">
                                    <div class="text-muted small mb-1">Closing Balance</div>
                                    <div class="h4 fw-bold text-dark mb-0">₹<span id="resClosingBalance">0</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Month</th>
                                    <th>Opening</th>
                                    <th>Contribution</th>
                                    <th>Withdrawal</th>
                                    <th class="pe-4">Closing</th>
                                </tr>
                            </thead>
                            <tbody id="monthlyTableBody">
                                <!-- Monthly rows will be injected here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 12px !important; }
    .table th { font-weight: 600; font-size: 0.85rem; color: #64748b; text-transform: uppercase; }
    .table td { vertical-align: middle; }
    .bg-primary-subtle { background-color: #e0e7ff !important; }
    .text-primary { color: #6366f1 !important; }
    .btn-primary { background-color: #6366f1; border-color: #6366f1; }
    .btn-primary:hover { background-color: #4f46e5; border-color: #4f46e5; }
</style>

<script>
function calculateGPF() {
    const opening = parseFloat(document.getElementById('openingBalance').value) || 0;
    const monthlySub = parseFloat(document.getElementById('monthlySub').value) || 0;
    const voluntarySub = parseFloat(document.getElementById('voluntarySub').value) || 0;
    const withdrawal = parseFloat(document.getElementById('withdrawals').value) || 0;
    const refund = parseFloat(document.getElementById('refunds').value) || 0;
    const rate = parseFloat(document.getElementById('interestRate').value) || 7.1;

    const months = ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March'];
    let currentBalance = opening;
    let totalDeposits = 0;
    let productsSum = 0;
    let tableHtml = '';

    const netMonthlyDeposit = monthlySub + voluntarySub + refund - withdrawal;

    months.forEach((month, index) => {
        let monthOpening = currentBalance;
        let monthContribution = monthlySub + voluntarySub + refund;
        let monthWithdrawal = withdrawal;
        
        // Product for interest calculation
        // Interest is calculated on the minimum balance between 10th and last day of month
        // Simplifying for basic estimation: Opening + Contribution - Withdrawal
        let monthEndBalance = monthOpening + monthContribution - monthWithdrawal;
        productsSum += monthEndBalance;
        
        tableHtml += `
            <tr>
                <td class="ps-4 fw-semibold">${month}</td>
                <td>₹${monthOpening.toLocaleString('en-IN', {maximumFractionDigits: 2})}</td>
                <td class="text-success">+₹${monthContribution.toLocaleString('en-IN', {maximumFractionDigits: 2})}</td>
                <td class="text-danger">-₹${monthWithdrawal.toLocaleString('en-IN', {maximumFractionDigits: 2})}</td>
                <td class="pe-4 fw-bold text-dark">₹${monthEndBalance.toLocaleString('en-IN', {maximumFractionDigits: 2})}</td>
            </tr>
        `;
        
        currentBalance = monthEndBalance;
        totalDeposits += monthContribution;
    });

    // Interest Calculation: (Sum of monthly product * rate) / (12 * 100)
    const annualInterest = (productsSum * rate) / 1200;
    const finalBalance = currentBalance + annualInterest;

    document.getElementById('monthlyTableBody').innerHTML = tableHtml;
    document.getElementById('resTotalDeposits').innerText = totalDeposits.toLocaleString('en-IN', {maximumFractionDigits: 2});
    document.getElementById('resTotalInterest').innerText = annualInterest.toLocaleString('en-IN', {maximumFractionDigits: 2});
    document.getElementById('resClosingBalance').innerText = finalBalance.toLocaleString('en-IN', {maximumFractionDigits: 2});
}

// Initial calculation
window.onload = function() {
    calculateGPF();
};
</script>
@endsection
