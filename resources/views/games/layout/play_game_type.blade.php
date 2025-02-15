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

        .game-timer {
            background: #00B4DB;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .game-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .game-button {
            background: white;
            color: #333;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            text-align: left;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .game-button:hover, .game-button.active {
            background: #f8f9fa;
            color: #00B4DB;
        }
    </style>
</head>

<body>

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

        .game-timer {
            background: #00B4DB;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .game-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .game-button {
            background: white;
            color: #333;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            text-align: left;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .game-button:hover, .game-button.active {
            background: #f8f9fa;
            color: #00B4DB;
        }
    </style>

    <!-- Game Header -->
    <header class="game-header fixed-top">
        <div class="d-flex align-items-center">
            <a href="{{ route('play.page') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="game-title">{{ $game->name }}</h1>
        </div>
        <div class="game-timer">
            {{ $game->name }}

        </div>
    </header>

    <main class="content-wrapper game-content">
        <div class="game-container">
            <div class="game-timer">
                {{ $game->name }}<br>
                {{ $game->timings && $game->timings->close_time
                    ? \Carbon\Carbon::createFromFormat('H:i:s', $game->timings->close_time)->format('h:i:s')
                    : 'N/A' }}
            </div>

            <div class="game-buttons">
                <a href="{{ route('play.game', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot green"></span>
                    Play Jodi
                </a>
                <a href="{{ route('play.manual', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot red"></span>
                    Play Manual
                </a>
                <a href="{{ route('play.harraf', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot red"></span>
                    Play Haroop
                </a>
                <a href="{{ route('play.crossing', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot red"></span>
                    Play Crossing
                </a>
                <a href="{{ route('play.num-to-num', ['gameName' => $game->name]) }}" class="game-button">
                    <span class="status-dot gray"></span>
                    Play Number to Number
                </a>
                <a href="{{ route('play.copy', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot gray"></span>
                    Play Copy Paste
                </a>
                <a href="{{ route('play.tap-play', ['gameName' => $game->name]) }}" class="game-button ">
                    <span class="status-dot gray"></span>
                    Play Tap Play
                </a>
            </div>
        </div>

        <style>
            .game-container {
                background: #00B4DB;
                padding: 15px;
                border-radius: 15px;
                max-width: 400px;
                margin: 0 auto;
            }

            .game-timer {
                color: white;
                text-align: center;
                margin-bottom: 15px;
                font-weight: bold;
                font-size: 1.1em;
            }

            .game-buttons {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .game-button {
                background: white;
                color: #333;
                padding: 12px 15px;
                text-decoration: none;
                border-radius: 10px;
                display: flex;
                align-items: center;
                font-weight: 500;
                font-size: 1em;
                transition: all 0.3s ease;
            }

            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                margin-right: 10px;
            }

            .status-dot.green {
                background-color: #4CAF50;
            }

            .status-dot.red {
                background-color: #f44336;
            }

            .status-dot.gray {
                background-color: #9e9e9e;
            }

            .game-button:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
        </style>
    </main>
    @include('games.layout.footer')
