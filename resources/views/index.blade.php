@extends('layouts.header')

@section('content')
    <!-- Main Content -->
    <main class="content-wrapper">
        <div class="chat-buttons mt-3 mb-3">
            <button class="btn deposit-chat">
                <i class="bi bi-chat-dots-fill"></i> Deposit Chat
            </button>
            <button class="btn withdraw-chat">
                <i class="bi bi-chat-dots-fill"></i> Withdraw Chat
            </button>
        </div>

        <div class="text-center mb-3">
            {{-- <img src="images/logo.png" alt="Government Logo" class="govt-logo"> --}}
                <h4>Mattka</h4>

        </div>

        <div class="action-buttons mb-3">
            <button class="btn btn-danger w-100 mb-2">Other Game</button>
            <button class="btn btn-success w-100">Clear Data</button>
        </div>

        <div class="welcome-banner text-center text-white p-3 mb-3">
            Welcome to Shree Shyam Matka
        </div>

        <div class="info-box text-center text-white p-3 mb-3">
            भरोसे का एक ही नाम प्रकाश खाईवाल<br>
            गेम खेलने में किसी भाई को दिक्कत आती है तो पेज में चैट वाले<br>
            ऑप्शन पर क्लिक करके हमसे बात कर सकते है<br><br>
            21-01-2025 (Tue) 09:02:31 PM
        </div>

        <div class="result-box text-center p-3 mb-3">
            न्यू इंडिया<br>
            Result<br>
            64
        </div>

        <div class="click-link-box text-center p-3 mb-3">
            सबसे पहले रिजल्ट देखने के लिए क्लिक करे
            <button class="btn btn-danger d-block mx-auto mt-2">Click Link</button>
        </div>

        <div class="game-info-box text-center text-white p-3 mb-3">
            जय खाटू सरकार भाईयो 😊<br>
            भाईयो इस ऐप पर सभी भाई गेम खेलो बिदास होकर यहां पर आपका<br>
            गेम ओटोमेटिक ओके होगा रिजल्ट इस ऐप में ओपन होते ही आपका<br>
            पैसा आपके अकाउंट में ऐड हो जायेगा आप कभी भी कोई सा भी गेम<br>
            लगा सकते है गेम खेलना सीखने के लिए आप नीचे हेल्प(help) वाले<br>
            बटन पर क्लिक करे
        </div>

        <div class="live-result-section mb-3">
            <div class="live-result-header text-center text-white p-3">
                Shree Shyam Matka Live Result of 2025-01-21
            </div>

            <div class="market-header d-flex justify-content-between text-white p-3">
                <div>Market Name/Time</div>
                <div class="d-flex">
                    <div class="me-3">Previous<br>Result</div>
                    <div>Today<br>Result</div>
                </div>
            </div>

            @foreach ($games as $game)
                <div class="market-result">
                    <div class="market-name">{{ $game->name }}</div>
                    <div class="market-times d-flex justify-content-between align-items-center">
                        <div class="time-info">
                            <div>Open Time</div>
                            <div>
                                {{ $game->timings && $game->timings->open_time
                                    ? \Carbon\Carbon::createFromFormat('H:i:s', $game->timings->open_time)->format('h:i A')
                                    : 'N/A' }}
                            </div>
                        </div>
                        <div class="time-info">
                            <div>Close Time</div>
                            <div>
                                {{ $game->timings && $game->timings->close_time
                                    ? \Carbon\Carbon::createFromFormat('H:i:s', $game->timings->close_time)->format('h:i A')
                                    : 'N/A' }}
                            </div>
                        </div>
                        <div class="time-info">
                            <div>Result At</div>
                            <div>
                                {{ $game->timings && $game->result_time
                                    ? \Carbon\Carbon::createFromFormat('H:i:s', $game->result_time)->format('h:i A')
                                    : 'N/A' }}
                            </div>
                        </div>
                        <div class="results d-flex">
                            {{-- पिछले दिन का परिणाम दिखाएं, अगर नहीं है तो "XX" --}}
                            <div class="prev-result">
                                {{
                                    $game->results
                                    ->where('result_date', \Carbon\Carbon::yesterday()->format('Y-m-d'))
                                    ->first()->jodi_number ?? 'XX'
                                }}
                            </div>

                            {{-- आज का परिणाम दिखाएं, अगर नहीं है तो "XX" --}}
                            <div class="today-result">
                                {{
                                    $game->results
                                    ->where('result_date', \Carbon\Carbon::today()->format('Y-m-d'))
                                    ->first()->jodi_number ?? 'XX'
                                }}
                            </div>
                        </div>


                    </div>
                </div>
            @endforeach

            {{-- <div class="market-result">
                <div class="market-name">लक्ष्मी क्लब</div>
                <div class="market-times d-flex justify-content-between align-items-center">
                    <div class="time-info">
                        <div>Open Time</div>
                        <div>05:30 AM</div>
                    </div>
                    <div class="time-info">
                        <div>Close Time</div>
                        <div>01:15 PM</div>
                    </div>
                    <div class="time-info">
                        <div>Result At</div>
                        <div>01:30 PM</div>
                    </div>
                    <div class="results d-flex">
                        <div class="prev-result">16</div>
                        <div class="today-result">72</div>
                    </div>
                </div>
            </div> --}}


        </div>
    </main>
@endsection
