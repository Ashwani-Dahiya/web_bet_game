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

        <!-- Harraf Tab Content -->
        <div class="show active" id="harraf-tab" role="tabpanel" aria-labelledby="harraf-tab-btn">
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
                                    <input type="number" class="form-control border-0 text-center harraf-input input-num"
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
                                    <input type="number" class="form-control border-0 text-center harraf-input input-num"
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
    </div>
@endSection
