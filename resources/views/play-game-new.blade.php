@extends('app-layout.header')

@section('app-content')
    <main class="content-wrapper game-content">
        <!-- Game Type Tabs -->
        <div class="game-types">
            <ul class="nav nav-pills" id="game-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="jodi-tab-btn" data-bs-toggle="tab" data-bs-target="#jodi-tab"
                        type="button" role="tab" aria-controls="jodi-tab" aria-selected="true">Jodi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manual-tab-btn" data-bs-toggle="tab" data-bs-target="#manual-tab"
                        type="button" role="tab" aria-controls="manual-tab" aria-selected="false">Manual</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="harraf-tab-btn" data-bs-toggle="tab" data-bs-target="#harraf-tab"
                        type="button" role="tab" aria-controls="harraf-tab" aria-selected="false">Harraf</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="crossing-tab-btn" data-bs-toggle="tab" data-bs-target="#crossing-tab"
                        type="button" role="tab" aria-controls="crossing-tab" aria-selected="false">Crossing</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="copy-paste-tab-btn" data-bs-toggle="tab" data-bs-target="#copy-paste-tab"
                        type="button" role="tab" aria-controls="copy-paste-tab" aria-selected="false">Copy
                        Paste</button>
                </li>
            </ul>
        </div>

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

        <!-- Tab Contents -->
        <div class="tab-content" id="game-tabContent">
            <!-- Jodi Tab Content -->
            <div class="tab-pane fade show active" id="jodi-tab" role="tabpanel" aria-labelledby="jodi-tab-btn">
                <form action="{{ route('place-bet-jodi') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                    <div class="number-grid">
                        <div class="row g-2">
                            @for ($i = 0; $i <= 99; $i++)
                                <div class="col-3">
                                    <div class="number-box">
                                        {{-- नंबर को सही फॉर्मेट में दिखाएं (01 से 09 और 10 से 99) --}}
                                        <div class="number-label">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</div>
                                        <input type="number" class="number-input input-num" min="5" max="5000"
                                            name="jodi[{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}]" />
                                    </div>
                                </div>
                            @endfor
                            <button type="submit" class="btn btn-play">Place bet</button>
                        </div>


                    </div>
                </form>
            </div>

            <!-- Manual Tab Content -->
            <div class="tab-pane fade" id="manual-tab" role="tabpanel" aria-labelledby="manual-tab-btn">


                <!-- Form HTML -->
                <form action="{{ route('place-bet-maual-jodi') }}" method="POST" id="manual-jodi-form">
                    @csrf
                    <input type="hidden" name="game_id" value="{{$game->id }}">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="color: #ff1493; border: 1px solid #00bfff;"
                                        colspan="5">Jodi</th>
                                    <th class="text-center" style="color: #00bfff; border: 1px solid #00bfff;">Point</th>
                                    <th class="text-center" style="color: #800080; border: 1px solid #00bfff;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < 10; $i++): ?>
                                <tr>
                                    <?php for ($j = 0; $j < 5; $j++): ?>
                                    <td style="border: 1px solid #00bfff;">
                                        <input id="manual-jodi-<?= $i ?>-<?= $j ?>" name="manual-jodi-<?= $i ?>-<?= $j ?>"
                                            type="text" class="form-control text-center p-0 manual-jodi-input"
                                            style="border: none;">
                                    </td>
                                    <?php endfor; ?>
                                    <td style="border: 1px solid #00bfff;">
                                        <input id="manual-point-<?= $i ?>" name="manual-point-<?= $i ?>" type="number"
                                            class="form-control text-center p-0 manual-point-input" style="border: none;">
                                    </td>
                                    <td id="manual-total-<?= $i ?>" class="text-center"
                                        style="border: 1px solid #00bfff;">0</td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between p-2" style="background-color: #f8f9fa;">
                            <span class="fw-bold">Total Points</span>
                            <span id="overall-total" class="fw-bold">0</span>
                        </div>
                        <button type="submit" class="btn btn-play">Place bet</button>
                    </div>
                </form>

                <script>
                    $(document).ready(function() {
                        // Allow only two-digit input and auto-tab
                        $(".manual-jodi-input").on("input", function() {
                            let value = $(this).val();

                            // Allow only numeric input and limit to two digits
                            if (!/^\d{0,2}$/.test(value)) {
                                $(this).val(value.slice(0, 2)); // Trim the value to two digits
                            }

                            // Move to the next input if two digits are entered
                            if (value.length === 2) {
                                let nextInput = $(this).closest("td").next().find(".manual-jodi-input");
                                if (nextInput.length) {
                                    nextInput.focus(); // Focus the next input in the row
                                } else {
                                    // Move to the point input if it's the last Jodi input
                                    $(this).closest("tr").find(".manual-point-input").focus();
                                }
                            }
                        });

                        // Update row total and validate unique values
                        $(".manual-jodi-input, .manual-point-input").on("input", function() {
                            $("tbody tr").each(function(rowIndex) {
                                let filledCount = 0; // To count the number of filled inputs
                                let pointValue = parseFloat($(`#manual-point-${rowIndex}`).val()) || 0;
                                let values = []; // To store values for uniqueness check
                                let isUnique = true;

                                // Check for unique values and count filled inputs
                                $(this).find(".manual-jodi-input").each(function() {
                                    let inputVal = $(this).val();

                                    if (inputVal && inputVal.trim() !== "") {
                                        filledCount++;
                                        if (values.includes(inputVal)) {
                                            isUnique = false;
                                            return false; // Break the loop
                                        }
                                        values.push(inputVal);
                                    }
                                });

                                // Calculate and update row total
                                let rowTotal = filledCount * pointValue;
                                $(`#manual-total-${rowIndex}`).text(rowTotal);

                                // Update overall total
                                let overallTotal = 0;
                                $("[id^='manual-total-']").each(function() {
                                    overallTotal += parseFloat($(this).text()) || 0;
                                });
                                $("#overall-total").text(overallTotal);
                            });
                        });

                        // Form submission validation
                        $("#manual-jodi-form").on("submit", function(e) {
                            let isValid = true;
                            let atLeastOneEntry = false;

                            // Check each row
                            $("tbody tr").each(function(rowIndex) {
                                let jodiInputs = $(this).find(".manual-jodi-input");
                                let pointInput = $(this).find(".manual-point-input");
                                let hasJodi = false;
                                let values = [];

                                // Check jodi inputs
                                jodiInputs.each(function() {
                                    let value = $(this).val();
                                    if (value && value.trim() !== "") {
                                        hasJodi = true;
                                        // Check for duplicate values
                                        if (values.includes(value)) {
                                            alert("Duplicate jodi numbers are not allowed in row " + (
                                                rowIndex + 1));
                                            isValid = false;
                                            return false;
                                        }
                                        // Check for valid two-digit number
                                        if (!/^\d{2}$/.test(value)) {
                                            alert("Please enter valid two-digit numbers in row " + (
                                                rowIndex + 1));
                                            isValid = false;
                                            return false;
                                        }
                                        values.push(value);
                                    }
                                });

                                // If there are jodi numbers, point must be entered
                                if (hasJodi) {
                                    atLeastOneEntry = true;
                                    let pointValue = pointInput.val();
                                    if (!pointValue || pointValue <= 0) {
                                        alert("Please enter a valid point value for row " + (rowIndex + 1));
                                        isValid = false;
                                        return false;
                                    }
                                }
                            });

                            if (!atLeastOneEntry) {
                                alert("Please enter at least one jodi number and point value");
                                isValid = false;
                            }

                            if (!isValid) {
                                e.preventDefault();
                                return false;
                            }
                        });
                    });
                </script>

            </div>


            <!-- Harraf Tab Content -->
            <div class="tab-pane fade" id="harraf-tab" role="tabpanel" aria-labelledby="harraf-tab-btn">
                <form action="{{ route('place-bet-harraf') }}" method="POST" id="harraf-form">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->id }}">

                    <div class="container-fluid bg-light p-3">
                        <!-- Andar Harraf Section -->
                        <h5 class="fw-bold mb-3">Andar Harraf</h5>
                        <div class="row row-cols-5 g-3 mb-4">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="col">
                                    <div class="border border-info">
                                        <div class="bg-info text-white text-center p-1">{{ $i }}</div>
                                        <input type="number" class="form-control border-0 text-center harraf-input"
                                            style="outline: none;" name="ander-{{ $i }}" min="0">
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Bahar Harraf Section -->
                        <h5 class="fw-bold mb-3">Bahar Harraf</h5>
                        <div class="row row-cols-5 g-3">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="col">
                                    <div class="border border-info">
                                        <div class="bg-info text-white text-center p-1">{{ $i }}</div>
                                        <input type="number" class="form-control border-0 text-center harraf-input"
                                            style="outline: none;" name="bahar-{{ $i }}" min="0">
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <button type="submit" class="btn btn-play">Place bet</button>
                    </div>
                </form>
            </div>

            <!-- jQuery Validation Script -->
            <script>
                $(document).ready(function() {
                    $('#harraf-form').on('submit', function(event) {
                        // Get all input fields in the form
                        let valid = false; // Flag to check if at least one valid input exists
                        $('.harraf-input').each(function() {
                            const value = $(this).val();
                            if (value && !isNaN(value) && Number(value) > 0) {
                                valid = true; // Set the flag to true if a valid input is found
                            }
                        });

                        // Check if the form is valid
                        if (!valid) {
                            event.preventDefault(); // Prevent form submission
                            alert('Please enter at least one positive number in the form.');
                            return false;
                        }
                    });

                    // Prevent negative numbers in input fields
                    $('.harraf-input').on('input', function() {
                        const value = $(this).val();
                        if (value < 0) {
                            $(this).val(''); // Clear the input if the value is negative
                            alert('Negative numbers are not allowed.');
                        }
                    });
                });
            </script>


            <!-- Crossing Tab Content -->
    <div class="container my-5">
        <div class="tab-pane fade show active" id="crossing-tab" role="tabpanel" aria-labelledby="crossing-tab-btn">
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
                        <div class="col-12">
                            <button class="btn btn-danger w-100" type="submit">Place bet</button>
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
                </div>
            </form>
        </div>
    </div>
<script>
    $(document).ready(function () {
    let totalPoints = 0;

    // Function to generate all jodi combinations
    function generateJodis(numbers1, numbers2) {
        let jodis = [];
        for (let i = 0; i < numbers1.length; i++) {
            for (let j = 0; j < numbers2.length; j++) {
                jodis.push(numbers1[i] + numbers2[j]);
            }
        }
        return jodis;
    }

    // Update hidden input with the jodis array
    function updateHiddenInput(jodis) {
        $("#crossed-numbers").val(jodis.join(",")); // Store as a comma-separated string
    }

    // Add button click handler
    $("#add-btn").click(function () {
        const firstInput = $("#first-crossing").val().trim();
        const secondInput = $("#second-crossing").val().trim();
        const points = parseInt($("#points-input").val().trim(), 10);

        // Validation: Ensure inputs are not empty and points are valid
        if (!firstInput || !secondInput || isNaN(points) || points <= 0) {
            alert("Please fill all fields correctly.");
            return;
        }

        // Reset table and total points for fresh calculations
        $("table tbody").empty();
        totalPoints = 0;

        // Generate jodi pairs for recalculation
        const firstNumbers = firstInput.split("");
        const secondNumbers = secondInput.split("");
        const jodis = generateJodis(firstNumbers, secondNumbers);

        // Add new rows to the table for each crossing
        jodis.forEach((jodi) => {
            $("table tbody").append(`
                <tr>
                    <td>Crossing</td>
                    <td>${jodi}</td>
                    <td>${points}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                    </td>
                </tr>
            `);
        });

        // Update total points
        totalPoints += jodis.length * points;
        $("#total-points").text(totalPoints);

        // Update the hidden input field with the generated jodis
        updateHiddenInput(jodis);
    });

    // Delete row handler
    $(document).on("click", ".delete-btn", function () {
        const row = $(this).closest("tr");
        const points = parseInt(row.find("td:nth-child(3)").text(), 10);
        totalPoints -= points;
        $("#total-points").text(totalPoints);
        row.remove();

        // Recalculate jodis and update hidden input after row deletion
        const remainingJodis = [];
        $("table tbody tr").each(function () {
            const jodi = $(this).find("td:nth-child(2)").text();
            remainingJodis.push(jodi);
        });
        updateHiddenInput(remainingJodis);
    });
});

</script>
            <!-- Copy Paste Tab Content -->
            <div class="tab-pane fade" id="copy-paste-tab" role="tabpanel" aria-labelledby="copy-paste-tab-btn">
                <div class="container-fluid bg-light p-3">
                    <!-- Input Form -->
                    <div class="mb-4">
                        <div class="mb-3">
                            <label class="form-label">Number</label>
                            <input type="text" class="form-control" placeholder="12">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Points</label>
                            <input type="number" class="form-control" placeholder="10">
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="platiOption" id="withPlati"
                                    value="withPlati" checked>
                                <label class="form-check-label" for="withPlati">With Plati</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="platiOption" id="withoutPlati"
                                    value="withoutPlati">
                                <label class="form-check-label" for="withoutPlati">Without Plati</label>
                            </div>
                        </div>
                        <button class="btn btn-danger w-100">Add</button>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Number type</th>
                                    <th class="text-center">Number</th>
                                    <th class="text-center">Points</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Jodi</td>
                                    <td class="text-center">12</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">Jodi</td>
                                    <td class="text-center">21</td>
                                    <td class="text-center">10</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Points -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h5 class="mb-0">Total Points</h5>
                        <h5 class="mb-0">20</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Play Button -->
        {{-- <div class="play-button-container">
            <button class="btn btn-play">Place bet</button>
        </div> --}}
    </main>
@endSection

