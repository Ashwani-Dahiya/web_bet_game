<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Play Game - Shree Shyam Matka</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5e7dc;
        }

        .fixed-top {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #008cba;
            color: white;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #008cba;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .content-wrapper {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .btn-custom {
            background-color: #ff4500;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e63e00;
        }

        .govt-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .welcome-banner {
            background-color: #008cba;
        }

        .info-box {
            background-color: #008cba;
        }

        .result-box {
            background-color: #008cba;
        }

        .click-link-box {
            background-color: #008cba;
        }

        /* Custom styles for tabs */
        .game-types {
            padding: 10px;
        }

        .nav-pills .nav-link {
            color: #008cba;
            background-color: #fff;
            border: 1px solid #008cba;
            margin: 2px;
        }

        .nav-pills .nav-link.active {
            background-color: #008cba;
            color: #fff;
        }

        .tab-content {
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            margin-top: 10px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
        .fade:not(.show) {
    display: none !important;
}
    </style>
</head>

<body>
    <!-- Game Header -->
    <header class="game-header fixed-top">
        <div class="d-flex align-items-center">
            <a href="{{ route('play.page') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="game-title">{{ $game->name }}</h1>
        </div>
        <div class="game-timer">
            गेम का लास्ट टाइम<br>
            {{ $game->timings && $game->timings->close_time
                ? \Carbon\Carbon::createFromFormat('H:i:s', $game->timings->close_time)->format('h:i A')
                : 'N/A' }} | Active
        </div>
    </header>
@yield('app-content')
@include('app-layout.footer')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Play Game - Shree Shyam Matka</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5e7dc;
        }

        .fixed-top {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #008cba;
            color: white;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #008cba;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .content-wrapper {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .btn-custom {
            background-color: #ff4500;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e63e00;
        }

        .govt-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .welcome-banner {
            background-color: #008cba;
        }

        .info-box {
            background-color: #008cba;
        }

        .result-box {
            background-color: #008cba;
        }

        .click-link-box {
            background-color: #008cba;
        }

        /* Custom styles for tabs */
        .game-types {
            padding: 10px;
        }

        .nav-pills .nav-link {
            color: #008cba;
            background-color: #fff;
            border: 1px solid #008cba;
            margin: 2px;
        }

        .nav-pills .nav-link.active {
            background-color: #008cba;
            color: #fff;
        }

        .tab-content {
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            margin-top: 10px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
        .fade:not(.show) {
    display: none !important;
}
    </style>
</head>

<body>
    <!-- Game Header -->
    <header class="game-header fixed-top">
        <div class="d-flex align-items-center">
            <a href="{{ route('play.page') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="game-title">{{ $game->name }}</h1>
        </div>
        <div class="game-timer">
            गेम का लास्ट टाइम<br>
            {{ $game->timings && $game->timings->close_time
                ? \Carbon\Carbon::createFromFormat('H:i:s', $game->timings->close_time)->format('h:i A')
                : 'N/A' }} | Active
        </div>
    </header>
@yield('app-content')
@include('app-layout.footer')
