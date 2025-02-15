@extends('layouts.header')
@section('content')
    <main class="content-wrapper">
        <form action="{{ route('filter.bet.history') }}" method="POST" id="filter-bet-history-form">
            @csrf
            <div class="container-fluid p-0">
                <div class="row mb-3 p-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Market</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control" name="game_id">
                                    <option selected>Select Market</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-link ms-2">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th >Type</th>
                        <th>Number</th>
                        <th>Points</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($bets) && $bets->count() > 0)
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($bets as $group_key => $bet_group)
                           @php
                            $i++;
                           @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ \Carbon\Carbon::parse($bet_group['bets'][0]['created_at'])->format('d/m/y') }}</td>


                                <td >
                                    {{ $bet_group['bets'][0]['bet_type'] }}
                                </td>
                                <td >
                                    @php
                                        $numbers = collect($bet_group['bets'])->pluck('number')->toArray();
                                    @endphp

                                    {!! implode(',', array_map(function ($num, $index) {
                                        return (($index + 1) % 5 == 0) ? $num . '<br>' : $num;
                                    }, $numbers, array_keys($numbers))) !!}
                                </td>

                                <td>
                                    {{ $bet_group['bets'][0]['amount'] ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $bet_group['total_amount'] }}
                                </td>
                                <td>
                                    @if ($bet_group['bets'][0]['status'] == 'win')
                                        <span class="badge bg-success">{{ $bet_group['bets'][0]['status'] }}</span>
                                    @elseif($bet_group['bets'][0]['status'] == 'lost')
                                        <span class="badge bg-danger">{{ $bet_group['bets'][0]['status'] }}</span>
                                    @else
                                        <span class="badge bg-info">{{ $bet_group['bets'][0]['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No Data Found</td>
                        </tr>
                    @endif



                </tbody>
            </table>
        </div>
    </main>
    <style>
        .content-wrapper {
            background-color: rgb(0 152 199);
        }

        .table {
            background-color: rgb(0 152 199);

        }

        .form-control {
            border-radius: 4px;
        }

        .btn-link {
            color: #0dcaf0;
        }

        .content-wrapper {
            padding: 5px;
        }
        td{
            font-size: 14px;
        }
    </style>


    <script>
        $(document).ready(function() {
    $('#filter-bet-history-form').on('change', 'input, select', function(e) {
        e.preventDefault();

        let formData = {
            _token: $('input[name="_token"]').val(),
            date: $('input[type="date"]').val(),
            game_id: $('select[name="game_id"]').val()
        };

        $.ajax({
            url: "{{ route('filter.bet.history') }}",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                let tbody = $('tbody');
                tbody.empty(); // पहले से मौजूद डेटा हटाएँ

                if (Object.keys(response.bets).length > 0) {
                    let i = 0;

                    $.each(response.bets, function(groupKey, betGroup) {
                        i++;
                        let firstBet = betGroup.bets[0]; // पहले bet को अलग निकालें

                        let statusClass = firstBet.status === 'win' ? 'bg-success' :
                            firstBet.status === 'lost' ? 'bg-danger' : 'bg-info';

                        // Numbers को group करके दिखाने के लिए processing
                        let numbers = betGroup.bets.map(b => b.number);
                        let formattedNumbers = numbers.map((num, index) => {
                            return ((index + 1) % 5 === 0) ? num + '<br>' : num;
                        }).join(',');

                        let row = `<tr>
                            <td>${i}</td>
                            <td>${firstBet.date}</td>
                            <td>${firstBet.bet_type}</td>
                            <td>${formattedNumbers}</td>
                            <td>${firstBet.amount ?? 'N/A'}</td>
                            <td>${betGroup.total_amount}</td>
                            <td><span class="badge ${statusClass}">${firstBet.status}</span></td>
                        </tr>`;

                        tbody.append(row);
                    });

                } else {
                    tbody.html('<tr><td colspan="7" class="text-center">No Data Found</td></tr>');
                }
            },
            error: function() {
                alert("Something went wrong! Please try again.");
            }
        });
    });
});

    </script>
@endsection
