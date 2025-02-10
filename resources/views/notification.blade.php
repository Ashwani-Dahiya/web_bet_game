@extends('layouts.header')
@section('content')

<main class="content-wrapper notification-page">
    <div class="notification-container">
        <div class="row">
            <div class="col-md-12">
                <div class="notification-wrapper">
                    @foreach ($notifications as $notification)
                    <div class="notification-item">
                        <div class="notification-content">
                            <i class="bi bi-exclamation-circle text-danger"></i>
                            <div class="notification-text">
                                <h6 class="text-danger"> {{ $notification->title }}</h6>
                                {{ $notification->message }}
                            </div>
                        </div>
                        <div class="notification-date">
                            Date:{{ $notification->created_at->format('d-m-Y H:i:s A') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.notification-container {
    padding: 5px;
    background: #f5f3f3;
    height: 100vh;
    border: 1px solid #ddd;
}

.notification-wrapper {
    overflow-y: auto;
    padding: 10px;
}

.notification-wrapper::-webkit-scrollbar {
    width: 6px;
}

.notification-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.notification-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.notification-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.notification-item {
    background-color: #fff;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.notification-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 10px;
}

.warning-icon {
    color: #ff4d4d;
    font-size: 20px;
    margin-top: 3px;
}

.notification-text {
    font-size: 12px;
    color: #333;
    line-height: 1.5;
}

.notification-date {
    font-size: 12px;
    color: #666;
    text-align: right;
}
</style>

@endsection
