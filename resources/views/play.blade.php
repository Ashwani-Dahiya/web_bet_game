@extends('layouts.header')
@section('content')
    <!-- Main Content -->
    <main class="content-wrapper">
        @if(session('success-bet'))
            <div class="alert alert-success">
                {{ session('success-bet') }}
            </div>
        @endif
        @if(session('error-bet'))
            <div class="alert alert-danger">
                {{ session('error-bet') }}
            </div>
        @endif
        <!-- play games list here  -->
        <div class="games-list">

            @foreach ($games as $index => $game)
    @php
        // Convert the close_time to today's datetime
        $closeTime = \Carbon\Carbon::createFromTimeString($game->close_time); // Use today's date with close_time
        $now = \Carbon\Carbon::now(); // Current datetime
    @endphp

    @if ($now->lessThan($closeTime))
        <div class="game-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="game-name">{{ $game->name }}</div>
                <div class="game-info">
                    <span class="badge bg-danger me-2 live-count">
                        <i class="bi bi-circle-fill"></i> LIVE:
                        <span id="live-value-{{ $index }}" class="live-value">{{ rand(999, 10000) }}</span>
                    </span>
                    <span class="badge bg-primary me-2 bids-count">
                        Bids:
                        <span id="bids-value-{{ $index }}" class="bids-value">{{ rand(999, 10000) }}</span>
                    </span>
                    <a href="{{ route('play.zone.page', ['gameName' => $game->name]) }}" class="btn btn-success btn-sm">Play Game</a>
                </div>
            </div>
        </div>
    @else
        <div class="game-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="game-name">{{ $game->name }}</div>
                <div class="time-status">
                    <span class="badge bg-danger">Time Out</span>
                </div>
            </div>
        </div>
    @endif
@endforeach




        </div>
    </main>
    <script>
        $(document).ready(function () {
            // Initialize Bids and Live values on page load
            const bids = {}; // To store bids for each game item
            const live = {}; // To store live values for each game item

            // Initialize random values for bids and live on page load
            $('.game-item').each(function (index) {
                const initialBids = Math.floor(Math.random() * (10000 - 999)) + 999; // Random between 999 and 10000
                const initialLive = Math.floor(Math.random() * (10000 - 999)) + 999; // Random between 999 and 10000
                bids[index] = initialBids; // Store bids
                live[index] = initialLive; // Store live

                // Update the HTML
                $(`#bids-value-${index}`).text(initialBids);
                $(`#live-value-${index}`).text(initialLive);
            });

            // Function to update bids and live dynamically
            function updateBidsAndLive() {
                $('.game-item').each(function (index) {
                    // Increment bids by 10
                    bids[index] += 10;

                    // Generate random live value
                    live[index] = Math.floor(Math.random() * (10000 - 999)) + 999;

                    // Update the HTML
                    $(`#bids-value-${index}`).text(bids[index]);
                    $(`#live-value-${index}`).text(live[index]);
                });
            }

            // Call the function every 5 seconds
            setInterval(updateBidsAndLive, 5000);
        });
    </script>
@endsection
