@extends('games.layout.header')

@section('app-game-content')
    <style>
        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .quick-amounts input[type="radio"] {
            display: none;
        }

        .quick-amounts label {
            display: block;
            padding: 10px;
            background: white;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .quick-amounts input[type="radio"]:checked+label {
            background-color: #00a3d3;
            color: white;
            border-color: #00a3d3;
        }

        .quick-amounts label:hover {
            background-color: #6ad0ef;
            border-color: #00a3d3;
        }

        .number-box {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .number-box:hover {
            border-color: #00a3d3;
            background-color: #f8f9fa;
        }

        .number-box .number-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .number-box .number-value {
            color: #00a3d3;
            font-weight: bold;
        }
    </style>
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
        <div class="show active" id="jodi-tab" role="tabpanel" aria-labelledby="jodi-tab-btn">
            <form action="{{ route('place-bet-tap-play') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <div class="number-grid">
                    <div class="quick-amounts">
                        @for ($i = 10; $i <= 100; $i += 10)
                            <input type="radio" name="amount" value="{{ $i }}" id="amount{{ $i }}"
                                class="points-amount">
                            <label for="amount{{ $i }}">{{ $i }}</label>
                        @endfor
                    </div>
                    <div class="row g-2">
                        @for ($i = 0; $i <= 99; $i++)
                            <div class="col-3">
                                <div class="number-box" data-number="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                    <div class="number-label">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</div>
                                    <input type="hidden" class="number-input input-num" min="5" max="5000"
                                        name="jodi[{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}]" readonly />
                                    <div class="number-value h6">0</div>
                                </div>
                            </div>
                        @endfor
                        <button type="submit" class="btn btn-danger btn-play">Place bet</button>
                        <button type="button" class="btn btn-reset btn-warning">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let points = parseInt($('#pointDisplay').text()) || 0;
            let selectedAmount = 0;
            let selectedNumbers = new Map();

            // Handle radio button selection
            $('.points-amount').on('change', function() {
                selectedAmount = parseInt($(this).val());
            });

            // Handle number box clicks
            $('.number-box').on('click', function() {
                if (selectedAmount === 0) {
                    alert('Please select an amount first');
                    return;
                }

                let number = $(this).data('number');
                let numberValue = $(this).find('.number-value');
                let inputField = $(this).find('.input-num');
                let currentValue = parseInt(numberValue.text()) || 0;
                let newValue = currentValue + selectedAmount;

                // Check if user is selecting more than 50 numbers
                if (!selectedNumbers.has(number) && selectedNumbers.size >= 50) {
                    alert("You cannot select more than 50 numbers!");
                    return;
                }

                // If number is already selected, increase the amount
                if (selectedNumbers.has(number)) {
                    selectedNumbers.set(number, selectedNumbers.get(number) + selectedAmount);
                } else {
                    selectedNumbers.set(number, selectedAmount);
                    $(this).addClass('selected');
                }

                numberValue.text(newValue);
                inputField.val(newValue);

                updatePoints();
            });

            // Function to update points
            function updatePoints() {
                let totalDeduction = 0;

                $('.input-num').each(function() {
                    let value = parseInt($(this).val()) || 0;
                    if (value > 0) {
                        totalDeduction += value;
                    }
                });

                $('#pointAddedDisplay').text(totalDeduction);

                let remainingPoints = points - totalDeduction;
                if (remainingPoints < 0) {
                    alert('Not enough points!');
                    return false;
                }
                $('#pointDisplay').text(remainingPoints);
            }

            // Reset button functionality
            $('.btn-reset').on('click', function() {
                selectedNumbers.clear();
                $('.number-box').removeClass('selected');
                $('.number-value').text('0');
                $('.input-num').val('');
                updatePoints();
            });

            // Form submission handling
            $('form').on('submit', function(e) {
                e.preventDefault();

                if (selectedNumbers.size === 0) {
                    alert('Please select at least one number!');
                    return false;
                }

                this.submit();
            });
        });
    </script>

    <style>
        .number-box.selected {
            background-color: rgb(154, 230, 255);
            border: 2px solid #4bd1fe
        }
        .number-box.selected .number-value { color: #001dff; } 
    </style>
@endSection
