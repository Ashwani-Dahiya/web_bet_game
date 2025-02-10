@extends('games.layout.header')

@section('app-game-content')
    <!-- Game Timer Banner -->
    <div class="timer-banner">
        मोटी जोड़ी का लास्ट टाइम : 00:00:14
    </div>

    <!-- Points Status -->
    <div class="points-status d-flex justify-content-between">
        <div class="points-item">
            <div class="points-label">Points Remaining</div>
            <div class="points-value" id="pointDisplay">{{ Auth::user()->wallet_balance }}</div>
        </div>
        <div class="points-item">
            <div class="points-label">Points Added</div>
            <div class="points-value" id="pointAddedDisplay">00</div>
        </div>
    </div>

    <div class="tab-content">

        <!-- Nmm to Num Tab Content -->
        <div class="show active">
            <div class="container my-5">
                <div class="tab-pane fade show active">
                    <form action="{{ route('place-bet-num-to-num') }}" method="POST" id="crossing-form">
                        @csrf
                        <input type="hidden" id="crossed-numbers" name="numbers">
                        <input type="hidden" name="game_id" value="{{ $game->id }}">

                        <div class="container-fluid bg-light p-3">
                            <div class="row g-3 mb-4">
                                <!-- Start Number Input -->
                                <div class="col-6">
                                    <label class="form-label fw-bold">Start Number</label>
                                    <input type="number" class="form-control" name="first_crossing" id="first-crossing" min="0" max="99">
                                </div>
                                <!-- End Number Input -->
                                <div class="col-6">
                                    <label class="form-label fw-bold">End Number</label>
                                    <input type="number" class="form-control" name="second_crossing" id="second-crossing" min="0" max="99">
                                </div>
                                <!-- Points Input -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Points</label>
                                    <input type="number" class="form-control" name="points" id="points-input" min="1">
                                </div>
                                <!-- Add Button -->
                                <div class="col-12">
                                    <button class="btn btn-danger w-100" type="button" id="add-btn">Add</button>
                                </div>
                            </div>

                            <!-- Table Section -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Number Type</th>
                                            <th>Number</th>
                                            <th>Points</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic rows will be added here -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="fw-bold">Total Points</td>
                                            <td colspan="2" class="fw-bold" id="total-points">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-danger w-100" type="submit">Place bet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let totalPoints = 0;
            let walletPoints = parseInt($('#pointDisplay').text()) || 0;

            function generateNumbers(start, end) {
                let numbers = [];
                for (let i = start; i <= end; i++) {
                    numbers.push(i.toString().padStart(2, '0')); // Ensure two-digit format
                }
                return numbers;
            }

            function updateHiddenInput(numbers) {
                $("#crossed-numbers").val(numbers.join(",")); // Store numbers as a comma-separated string
            }

            function updatePointsDisplay() {
                let newWalletPoints = walletPoints - totalPoints;
                if (newWalletPoints >= 0) {
                    $('#pointDisplay').text(newWalletPoints);
                    $('#pointAddedDisplay').text(totalPoints);
                } else {
                    alert("You cannot deduct more than available points!");
                }
            }

            $("#add-btn").click(function() {
                let startNum = parseInt($("#first-crossing").val(), 10);
                let endNum = parseInt($("#second-crossing").val(), 10);
                let points = parseInt($("#points-input").val(), 10);

                // Validation Checks
                if (isNaN(startNum) || isNaN(endNum) || isNaN(points)) {
                    alert("All fields are required!");
                    return;
                }
                if (startNum < 0 || endNum < 0 || points <= 0) {
                    alert("Numbers and points must be positive!");
                    return;
                }
                if (startNum > 99 || endNum > 99) {
                    alert("Numbers must be between 00 and 99!");
                    return;
                }
                if (startNum > endNum) {
                    alert("Start Number must be less than or equal to End Number!");
                    return;
                }

                // Clear previous table data
                $("table tbody").empty();
                totalPoints = 0;

                // Generate numbers from Start to End
                let numbers = generateNumbers(startNum, endNum);

                // Append new rows to table
                numbers.forEach((num) => {
                    $("table tbody").append(`
                        <tr>
                            <td>Crossing</td>
                            <td>${num}</td>
                            <td>${points}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </td>
                        </tr>
                    `);
                });

                // Update total points
                totalPoints = numbers.length * points;
                $("#total-points").text(totalPoints);

                // Update the hidden input field with the generated numbers
                updateHiddenInput(numbers);

                // Update wallet points
                updatePointsDisplay();
            });

            $(document).on("click", ".delete-btn", function() {
                const row = $(this).closest("tr");
                const points = parseInt(row.find("td:nth-child(3)").text(), 10);

                if (!isNaN(points) && points > 0) {
                    totalPoints -= points;
                }

                row.remove();

                const remainingNumbers = [];
                $("table tbody tr").each(function() {
                    const num = $(this).find("td:nth-child(2)").text();
                    remainingNumbers.push(num);
                });

                updateHiddenInput(remainingNumbers);
                updatePointsDisplay();
            });
        });
    </script>

@endSection
