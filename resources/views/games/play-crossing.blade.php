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

        <!-- Manual Tab Content -->
        <div class="show active">
            <!-- Crossing Tab Content -->
            <div class="container my-5">
                <div class="tab-pane fade show active">
                    <form action="{{ route('place-bet-crossing') }}" method="POST" id="crossing-form">
                        @csrf
                        <input type="hidden" id="crossed-numbers" name="crossed_numbers">
                        <input type="hidden" name="game_id" value="{{ $game->id }}">

                        <div class="container-fluid bg-light p-3">
                            <!-- Input Section -->
                            <div class="row g-3 mb-4">
                                <!-- First Crossing Input -->
                                <div class="col-6">
                                    <label class="form-label fw-bold">Crossing</label>
                                    <input type="text" class="form-control" name="first_crossing" id="first-crossing">
                                </div>
                                <!-- Second Crossing Input -->
                                <div class="col-6">
                                    <label class="form-label fw-bold">Crossing</label>
                                    <input type="text" class="form-control" name="second_crossing" id="second-crossing">
                                </div>
                                <!-- Points Input -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">Points</label>
                                    <input type="number" class="form-control" name="points" id="points-input">
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
                                            <th>Number type</th>
                                            <th>Number</th>
                                            <th>Points</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic rows will be appended here -->
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
    let addedJodis = new Set(); // Store unique Jodi numbers
    let isAdded = false; // To track if Add button was clicked

    function generateJodis(numbers1, numbers2) {
        let jodis = [];
        for (let i = 0; i < numbers1.length; i++) {
            for (let j = 0; j < numbers2.length; j++) {
                let jodi = numbers1[i] + numbers2[j];
                if (!addedJodis.has(jodi)) { // Ensure uniqueness
                    jodis.push(jodi);
                    addedJodis.add(jodi);
                }
            }
        }
        return jodis;
    }

    function updateHiddenInput() {
        $("#crossed-numbers").val([...addedJodis].join(","));
    }

    function updatePointsDisplay() {
        let newWalletPoints = walletPoints - totalPoints;
        if (newWalletPoints >= 0) {
            $('#pointDisplay').text(newWalletPoints);
            $('#pointAddedDisplay').text(totalPoints);
            $('#total-points').text(totalPoints);
        } else {
            alert("You cannot deduct more than available points!");
        }
    }

    $("#add-btn").click(function() {
        isAdded = true;
        const firstInput = $("#first-crossing").val().trim();
        const secondInput = $("#second-crossing").val().trim();
        const points = parseInt($("#points-input").val().trim(), 10);

        if (!firstInput || !secondInput || isNaN(points) || points <= 0) {
            alert("Please fill all fields correctly.");
            return;
        }

        const firstNumbers = firstInput.split("");
        const secondNumbers = secondInput.split("");
        const jodis = generateJodis(firstNumbers, secondNumbers);

        jodis.forEach((jodi) => {
            $("table tbody").append(`
                <tr>
                    <td>Crossing</td>
                    <td>${jodi}</td>
                    <td>${points}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-number="${jodi}" data-points="${points}">Delete</button>
                    </td>
                </tr>
            `);
        });

        totalPoints += jodis.length * points;
        updateHiddenInput();
        updatePointsDisplay();
    });

    $(document).on("click", ".delete-btn", function() {
        const row = $(this).closest("tr");
        const jodiToDelete = $(this).data("number");
        const pointsToDeduct = parseInt($(this).data("points"), 10);

        if (!isNaN(pointsToDeduct) && pointsToDeduct > 0) {
            totalPoints -= pointsToDeduct;
        }
        addedJodis.delete(jodiToDelete);
        row.remove();

        updateHiddenInput();
        updatePointsDisplay();
    });

    $("form").submit(function(event) {
        if (!isAdded) {
            alert("Please click the Add button before placing your bet.");
            event.preventDefault();
            return false;
        }
        if ($("#crossed-numbers").val() === "") {
            alert("Please add at least one Jodi before placing your bet.");
            event.preventDefault();
            return false;
        }
    });
});

  </script>
@endSection
