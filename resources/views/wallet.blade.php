@extends('layouts.header')
@section('content')

<main class="content-wrapper">
<div class="wallet-container">
    <!-- Tabs -->
    <div class="tab-container">
        <button class="tab-button active" data-tab="add-points">Add Points</button>
        <button class="tab-button" data-tab="withdraw-points">Withdraw Points</button>
    </div>

    <!-- Add Points Tab Content -->
    <div class="tab-content active" id="add-points">
        <div class="points-input">
            <span class="bank-icon">
                <i class="bi bi-bank"></i>
            </span>
            <input type="number" value="100" class="points-amount">
        </div>

        <div class="quick-amounts">
            <button>100</button>
            <button>1000</button>
            <button>1500</button>
            <button>2000</button>
            <button>2500</button>
            <button>3000</button>
        </div>

        <div class="info-text">
            <div class="video-link">
                पेमेंट करने का न्यू तरीका। विडियो देखो
            </div>
            <div class="time-text">
                आपका पैसा 5 से 10 मिनट में पहुंच जाएगा
            </div>
        </div>

        <div class="action-buttons">
            <button class="action-btn add-points-btn">Add Points</button>
            <button class="action-btn transfer-points-btn">Transfer Points</button>
        </div>

        <div class="history-section">
            <h3>Deposit History</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Pay Mode</th>
                            <th>Date</th>
                            <th>Points</th>
                            <th>Closing Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">No Data Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Withdraw Points Tab Content -->
    <div class="tab-content" id="withdraw-points">
        <div class="points-input">
            <span class="bank-icon">
                <i class="bi bi-bank"></i>
            </span>
            <input type="number" value="100" class="points-amount">
        </div>

        <div class="quick-amounts">
            <button>475</button>
            <button>1000</button>
            <button>1500</button>
            <button>2000</button>
            <button>2500</button>
            <button>3000</button>
        </div>

        <div class="time-text">
            आपका पैसा 5 से 10 मिनट में पहुंच जाएगा
        </div>

        <div class="win-amount">
            Win Amount :- 0
        </div>

        <div class="bank-details">
            <h3>Bank Account Details</h3>
            <div class="account-type">
                <label>
                    <input type="radio" name="account-type" value="permanent" checked> Permanent
                </label>
                <label>
                    <input type="radio" name="account-type" value="temporary"> Temporary
                </label>
            </div>

            <div class="form-inputs">
                <input type="text" placeholder="Enter Bank Name">
                <input type="text" placeholder="Enter Account Holder Name">
                <input type="text" placeholder="Enter Account Number">
                <input type="text" placeholder="Enter IFSC Code">
            </div>

            <button class="withdraw-btn">Withdraw</button>
        </div>

        <div class="history-section">
            <h3>Withdraw History</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Pay Mode</th>
                            <th>Date</th>
                            <th>Points</th>
                            <th>Closing Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">No Data Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>
<style>
.wallet-container {
    padding: 15px;
    background-color: #f5f5f5;
}

.tab-container {
    display: flex;
    margin-bottom: 20px;
}

.tab-button {
    flex: 1;
    padding: 15px;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.tab-button:first-child {
    background-color: #4CAF50;
    color: white;
}

.tab-button:last-child {
    background-color: #DC3545;
    color: white;
}

.tab-button.active {
    opacity: 1;
}

.tab-content {
    display: none;
    padding: 20px 0;
}

.tab-content.active {
    display: block;
}

.points-input {
    position: relative;
    margin-bottom: 20px;
}

.bank-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #0dcaf0;
    font-size: 24px;
}

.points-amount {
    width: 100%;
    padding: 15px 15px 15px 45px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
}

.quick-amounts {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.quick-amounts button {
    padding: 15px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}

.info-text {
    text-align: center;
    margin-bottom: 20px;
}

.video-link {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 25px;
    margin-bottom: 10px;
}

.time-text {
    color: #666;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 20px;
}

.action-btn {
    padding: 15px;
    border: none;
    border-radius: 25px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.add-points-btn {
    background-color: #DC3545;
}

.transfer-points-btn {
    background-color: #DC3545;
}

.history-section {
    margin-top: 30px;
}

.history-section h3 {
    color: #007bff;
    margin-bottom: 15px;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

th {
    background-color: #28a745;
    color: white;
    padding: 9px;
    text-align: center;
    font-size: 14px;
}

td {
    padding: 12px;
    border: 1px solid #ddd;
}

/* Withdraw specific styles */
.win-amount {
    text-align: center;
    color: #007bff;
    margin: 15px 0;
}

.bank-details {
    margin-top: 20px;
}

.account-type {
    display: flex;
    gap: 20px;
    margin: 15px 0;
}

.form-inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.form-inputs input {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.withdraw-btn {
    width: 100%;
    padding: 15px;
    background-color: #DC3545;
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked button and corresponding content
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Quick amount selection
    const quickAmountButtons = document.querySelectorAll('.quick-amounts button');
    const pointsInputs = document.querySelectorAll('.points-amount');

    quickAmountButtons.forEach(button => {
        button.addEventListener('click', () => {
            const amount = button.textContent;
            const tabContent = button.closest('.tab-content');
            const input = tabContent.querySelector('.points-amount');
            input.value = amount;
        });
    });
});
</script>
@endsection
