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
                        <th>Name</th>
                        <th>Type</th>
                        <th>Number</th>
                        <th>Points</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($bets) && $bets->count() > 0)
                        @foreach ($bets as $index => $bet)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ optional($bet->created_at)->format('d-m-Y') }}</td> {{-- यदि date कॉलम नहीं है तो created_at --}}
                                <td>{{ optional($bet->game)->name ?? 'N/A' }}</td> {{-- गेम न मिले तो N/A दिखाए --}}
                                <td>{{ $bet->bet_type }}</td>
                                <td>{{ $bet->number }}</td>
                                <td>{{ $bet->amount }}</td>
                                @if ($bet->status == 'win')
                                    <td><span class="badge bg-success">{{ $bet->status }}</span></td>
                                @elseif($bet->status == 'lost')
                                    <td><span class="badge bg-danger">{{ $bet->status }}</span></td>
                                @else
                                    <td><span class="badge bg-info">{{ $bet->status }}</span></td>
                                @endif
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
    </style>


<script>
    $(document).ready(function () {
    $('#filter-bet-history-form').on('change', 'input, select', function (e) {
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
            success: function (response) {
                let tbody = $('tbody');
                tbody.empty(); // पहले से मौजूद डेटा हटाएँ

                if (response.bets.length > 0) {
                    $.each(response.bets, function (index, bet) {
                        let statusClass = bet.status === 'win' ? 'bg-success' :
                                          bet.status === 'lost' ? 'bg-danger' : 'bg-info';

                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${bet.date}</td>
                            <td>${bet.game_name}</td>
                            <td>${bet.bet_type}</td>
                            <td>${bet.number}</td>
                            <td>${bet.amount}</td>
                            <td><span class="badge ${statusClass}">${bet.status}</span></td>
                        </tr>`;

                        tbody.append(row);
                    });
                } else {
                    tbody.html('<tr><td colspan="7" class="text-center">No Data Found</td></tr>');
                }
            },
            error: function () {
                alert("Something went wrong! Please try again.");
            }
        });
    });
});

</script>
@endsection
