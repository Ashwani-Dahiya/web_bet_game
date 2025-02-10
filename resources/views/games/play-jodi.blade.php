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
                        <button type="submit" class="btn btn-play">Place bet</button>
                    </div>


                </div>
            </form>
        </div>

    </div>






    <script>
        $(document).ready(function() {
            // Get initial points from the span
            let points = parseInt($('#pointDisplay').text()) || 0;

            // Function to update points
            function updatePoints() {
                let totalDeduction = 0;

                $('.input-num').each(function() {
                    let value = parseInt($(this).val()) || 0;

                    // Ensure value is positive
                    if (value > 0) {
                        totalDeduction += value;
                    } else {
                        $(this).val(''); // Reset negative or invalid inputs
                    }
                });

                // Calculate new points
                let newPoints = points - totalDeduction;

                // Validation to ensure points don't go negative
                if (newPoints >= 0) {
                    $('#pointDisplay').text(newPoints);
                    $('#pointAddedDisplay').text(totalDeduction);
                } else {
                    alert("You cannot deduct more than available points!");
                    $('.input-num').val(''); // Reset inputs
                }
            }

            // Trigger update on input change
            $('.input-num').on('input', function() {
                updatePoints();
            });
        });
    </script>
@endSection
