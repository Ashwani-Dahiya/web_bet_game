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

    <!-- Tab Contents -->
    <div class="tab-content">

        <!-- Manual Tab Content -->
        <div class="show active">


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
                    let walletPoints = parseInt($('#pointDisplay').text()) || 0;

                    $(".manual-jodi-input").on("input", function() {
                        let value = $(this).val();
                        if (!/^\d{0,2}$/.test(value)) {
                            $(this).val(value.slice(0, 2));
                        }
                        if (value.length === 2) {
                            let nextInput = $(this).closest("td").next().find(".manual-jodi-input");
                            if (nextInput.length) {
                                nextInput.focus();
                            } else {
                                $(this).closest("tr").find(".manual-point-input").focus();
                            }
                        }
                    });

                    $(".manual-jodi-input, .manual-point-input").on("input", function() {
                        let overallTotal = 0;
                        $("tbody tr").each(function(rowIndex) {
                            let filledCount = 0;
                            let pointValue = parseFloat($(`#manual-point-${rowIndex}`).val()) || 0;
                            let values = [];
                            let isUnique = true;

                            $(this).find(".manual-jodi-input").each(function() {
                                let inputVal = $(this).val();
                                if (inputVal && inputVal.trim() !== "") {
                                    filledCount++;
                                    if (values.includes(inputVal)) {
                                        isUnique = false;
                                        return false;
                                    }
                                    values.push(inputVal);
                                }
                            });

                            let rowTotal = filledCount * pointValue;
                            $(`#manual-total-${rowIndex}`).text(rowTotal);
                            overallTotal += rowTotal;
                        });

                        let newWalletBalance = walletPoints - overallTotal;
                        if (newWalletBalance >= 0) {
                            $("#overall-total").text(overallTotal);
                            $("#pointDisplay").text(newWalletBalance);
                            $("#pointAddedDisplay").text(overallTotal);
                        } else {
                            alert("You don't have enough points!");
                            $(this).val('');
                        }
                    });

                    $("#manual-jodi-form").on("submit", function(e) {
                        let isValid = true;
                        let atLeastOneEntry = false;

                        $("tbody tr").each(function(rowIndex) {
                            let jodiInputs = $(this).find(".manual-jodi-input");
                            let pointInput = $(this).find(".manual-point-input");
                            let hasJodi = false;
                            let values = [];

                            jodiInputs.each(function() {
                                let value = $(this).val();
                                if (value && value.trim() !== "") {
                                    hasJodi = true;
                                    if (values.includes(value)) {
                                        alert("Duplicate jodi numbers are not allowed in row " + (rowIndex + 1));
                                        isValid = false;
                                        return false;
                                    }
                                    if (!/^\d{2}$/.test(value)) {
                                        alert("Please enter valid two-digit numbers in row " + (rowIndex + 1));
                                        isValid = false;
                                        return false;
                                    }
                                    values.push(value);
                                }
                            });

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

    </div>
@endSection
