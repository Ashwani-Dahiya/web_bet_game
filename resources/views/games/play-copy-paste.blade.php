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
        <form action="{{ route('place-bet-copy-paste') }}" method="POST">
            @csrf
        <div class="container mt-5">
            <input type="hidden" name="game_id" value="{{ $game->id }}">

            <input type="hidden" id="jodi-numbers-aaray" name="jodi_numbers[]" class="form-control">

            <div class="mb-4">
                <label class="form-label">Number</label>
                <input type="text" id="jodi-number" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Points</label>
                <input type="number" id="points" class="form-control" required name="point">
            </div>
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="platiOption" id="withPlati" value="withPlati"
                        checked>
                    <label class="form-check-label" for="withPlati">With Plati</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="platiOption" id="withoutPlati"
                        value="withoutPlati">
                    <label class="form-check-label" for="withoutPlati">Without Plati</label>
                </div>
            </div>
            <button class="btn btn-danger w-100" id="add-btn">Add</button>

            <!-- Table Section -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Number type</th>
                            <th class="text-center">Number</th>
                            <th class="text-center">Points</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="jodi-table-body">
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn  btn-play btn-danger w-100">Place bet</button>


        </div>
    </form>
    </div>

  <script>
    $(document).ready(function() {
    let initialWalletPoints = parseInt($('#pointDisplay').text()) || 0;
    let walletPoints = initialWalletPoints;
    let addedJodis = []; // Store added Jodi numbers
    let isAdded = false; // To check if add button was clicked

    // Handle radio button change
    $("input[name='platiOption']").change(function() {
        resetTable();
    });

    $("#add-btn").click(function(event) {
        event.preventDefault(); // 🔹 Form Submit होने से रोकें
        isAdded = true; // User ने add किया है

        let jodiNumber = $("#jodi-number").val().trim();
        let points = parseFloat($("#points").val()) || 0;
        let isWithPlati = $("#withPlati").is(":checked");

        // 🔹 इनपुट वैलिडेशन
        if (jodiNumber === "" || points === 0) {
            alert("Please enter both Jodi Number and Points.");
            return;
        }

        if (jodiNumber.length % 2 !== 0) {
            alert("Please enter valid Jodi numbers (even digit numbers like 145678)");
            return;
        }

        let jodiPairs = jodiNumber.match(/.{1,2}/g) || [];
        let totalDeductPoints = 0;

        jodiPairs.forEach(num => {
            if (!addedJodis.includes(num)) {
                addedJodis.push(num);
                addRow("Jodi", num, points);
                totalDeductPoints += points;
            }

            if (isWithPlati) {
                let reverseNum = num.split("").reverse().join("");
                if (!addedJodis.includes(reverseNum)) {
                    addedJodis.push(reverseNum);
                    addRow("Jodi", reverseNum, points);
                    totalDeductPoints += points;
                }
            }
        });

        $("#jodi-numbers-aaray").val(JSON.stringify(addedJodis));
        walletPoints -= totalDeductPoints;
        $("#pointDisplay").text(walletPoints);
        updateTotalPoints();
    });

    function addRow(type, number, points) {
        let row = `<tr>
            <td class="text-center">${type}</td>
            <td class="text-center">${number}</td>
            <td class="text-center">${points}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm delete-btn" data-number="${number}" data-points="${points}">Delete</button>
            </td>
        </tr>`;
        $("#jodi-table-body").append(row);
    }

    $(document).on("click", ".delete-btn", function() {
        let numberToDelete = $(this).data("number");
        let pointsToRefund = parseFloat($(this).data("points"));

        addedJodis = addedJodis.filter(num => num !== numberToDelete);
        $("#jodi-numbers-aaray").val(JSON.stringify(addedJodis));

        walletPoints += pointsToRefund;
        $("#pointDisplay").text(walletPoints);

        $(this).closest("tr").remove();
        updateTotalPoints();
    });

    function updateTotalPoints() {
        let totalPoints = 0;
        $("#jodi-table-body tr").each(function() {
            totalPoints += parseFloat($(this).find("td:nth-child(3)").text()) || 0;
        });
        $("#pointAddedDisplay").text(totalPoints);
    }

    function resetTable() {
        $("#jodi-table-body").empty();
        addedJodis = [];
        $("#jodi-numbers-aaray").val("");
        walletPoints = initialWalletPoints;
        $("#pointDisplay").text(walletPoints);
        $("#pointAddedDisplay").text("0");
        isAdded = false;
    }

    // **Form Validation Before Submit**
    $("form").submit(function(event) {
        if (!isAdded) {
            alert("Please click the Add button before placing your bet.");
            event.preventDefault();
            return false;
        }

        if ($("#jodi-table-body tr").length === 0) {
            alert("Please add at least one Jodi before placing your bet.");
            event.preventDefault();
            return false;
        }
    });
});

  </script>
@endSection
