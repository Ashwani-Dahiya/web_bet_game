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
                    <button type="submit" class="btn btn-play btn-danger col-12 mt-3">Place bet</button>
                </div>
            </form>
        </div>


    </div>
    <script>
        $(document).ready(function() {
    // Get initial points from the span
    let points = parseInt($('#pointDisplay').text()) || 0;

    function countSelectedInputs(selector) {
        let count = 0;
        $(selector).each(function() {
            if ($(this).val().trim() !== '') {
                count++;
            }
        });
        return count;
    }

    $('.input-num').on('input', function() {
        let isAnderInput = $(this).attr('name').startsWith('ander');
        let isBaharInput = $(this).attr('name').startsWith('bahar');

        let anderCount = countSelectedInputs('.input-num[name^="ander"]');
        let baharCount = countSelectedInputs('.input-num[name^="bahar"]');

        if ((isAnderInput && anderCount > 5) || (isBaharInput && baharCount > 5)) {
            alert("आप केवल 5 अन्दर और 5 बाहर नंबर ही डाल सकते हैं!");
            $(this).val('');
            return;
        }

        updatePoints();
    });

    function updatePoints() {
        let totalDeduction = 0;
        $('.input-num').each(function() {
            let value = parseInt($(this).val()) || 0;
            if (value > 0) {
                totalDeduction += value;
            } else {
                $(this).val('');
            }
        });

        let newPoints = points - totalDeduction;
        if (newPoints >= 0) {
            $('#pointDisplay').text(newPoints);
            $('#pointAddedDisplay').text(totalDeduction);
        } else {
            alert("आपके पास पर्याप्त पॉइंट्स नहीं हैं!");
            $('.input-num').val('');
        }
    }

    $('#harraf-form').on('submit', function(event) {
        let anderCount = countSelectedInputs('.input-num[name^="ander"]');
        let baharCount = countSelectedInputs('.input-num[name^="bahar"]');

        if (anderCount > 5 || baharCount > 5) {
            alert("आप अधिकतम 5 अन्दर और 5 बाहर नंबर ही डाल सकते हैं!");
            event.preventDefault();
            return false;
        }

        let valid = anderCount > 0 || baharCount > 0;
        if (!valid) {
            alert('कृपया कम से कम एक अन्दर या बाहर नंबर दर्ज करें।');
            event.preventDefault();
            return false;
        }
    });
});

    </script>
@endSection
