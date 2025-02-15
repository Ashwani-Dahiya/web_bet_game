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
        <!-- Jodi Tab Content -->
        <div class="show active" id="jodi-tab" role="tabpanel" aria-labelledby="jodi-tab-btn">
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
                        <button type="submit" class="btn btn-play btn-danger">Place bet</button>
                    </div>


                </div>
            </form>
        </div>

    </div>






    <script>
        $(document).ready(function() {
    let points = parseInt($('#pointDisplay').text()) || 0;
    let maxJodiLimit = 50; // Jodi limit set to 50

    function validateForm() {
        let totalDeduction = 0;
        let selectedJodis = 0;
        let isAnyFilled = false;

        $('.input-num').each(function() {
            let value = parseInt($(this).val()) || 0;

            if (value > 0) {
                isAnyFilled = true;
                totalDeduction += value;
                selectedJodis++;
            }
        });

        if (!isAnyFilled) {
            alert("कम से कम एक नंबर भरना अनिवार्य है!");
            return false;
        }

        if (selectedJodis > maxJodiLimit) {
            alert(`आप केवल ${maxJodiLimit} जोड़ी तक ही बेट कर सकते हैं!`);
            return false;
        }

        if (totalDeduction > points) {
            alert("आपके पास पर्याप्त बैलेंस नहीं है!");
            return false;
        }

        return true;
    }

    // Prevent form submission if validation fails
    $("form").submit(function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Stop form submission
        }
    });

    $(".input-num").on("input", function() {
        let totalDeduction = 0;
        let selectedJodis = 0;

        $(".input-num").each(function() {
            let value = parseInt($(this).val()) || 0;

            if (value > 0) {
                totalDeduction += value;
                selectedJodis++;
            }
        });

        if (selectedJodis > maxJodiLimit) {
            alert(`आप केवल ${maxJodiLimit} जोड़ी तक ही बेट कर सकते हैं!`);
            $(this).val(''); // Reset last input
        }

        let newPoints = points - totalDeduction;

        if (newPoints >= 0) {
            $("#pointDisplay").text(newPoints);
            $("#pointAddedDisplay").text(totalDeduction);
        } else {
            alert("आपके पास पर्याप्त बैलेंस नहीं है!");
            $(this).val(''); // Reset last input
        }
    });
});

    </script>
@endSection
