<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matka Game</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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

        /* Offcanvas styles */
        .offcanvas {
            background-color: #008cba;
        }

        .offcanvas-header {
            background-color: #008cba;
            color: white;
            padding: 1rem;
        }

        .offcanvas-body {
            padding: 0;
        }

        .menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-list li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-list li a {
            color: white;
            text-decoration: none;
            padding: 1rem;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .menu-list li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-list .bi {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .edit-profile-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            border-radius: 5px;
        }

        .menu-item-red {
            background-color: #dc3545;
        }

        .menu-item-green {
            background-color: #28a745;
        }

        .social-links {
            display: flex;
            justify-content: space-around;
            padding: 1rem;
            background-color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .social-links a {
            color: #000;
            text-decoration: none;
            text-align: center;
            font-size: 0.8rem;
        }

        .social-links .bi {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Fixed Header -->
    <header class="fixed-top">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand">Home</span>
                <div class="d-flex align-items-center">
                    <div class="point-display me-2">Point: <span id="pointDisplay">{{ Auth::user()->wallet_balance }}</span></div>
                    <button class="btn btn-danger me-2">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                    <a href="{{ route('notifications.page') }}" class="notification-icon position-relative">
                        <i class="bi bi-bell-fill text-white fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuOffcanvas">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center">
                {{-- <img src="images/logo.png" alt="User" class="rounded-circle me-2" style="width: 50px; height: 50px;"> --}}
                <div>
                    <div>Name:  {{ Auth::user()->name }}</div>
                    <div>ID: {{ Auth::user()->mobile }}</div>
                </div>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <button class="edit-profile-btn">Edit Profile</button>
            <ul class="menu-list">
                <li class="menu-item-red">
                    <a href="#">
                        <i class="bi bi-file-text"></i>
                        Bonus Report
                        <small class="ms-2">अपनी गेम का कमीशन देखने के लिए यहाँ दबायें</small>
                    </a>
                </li>
                <li class="menu-item-green">
                    <a href="{{ route('play.history') }}">
                        <i class="bi bi-clock-history"></i>
                        My Play History
                        <small class="ms-2">अपनी खेली हुई गेम देखने के लिए यहाँ दबाये</small>
                    </a>
                </li>
                <li class="menu-item-green">
                    <a href="#">
                        <i class="bi bi-table"></i>
                        Result History
                        <small class="ms-2">गेम के रिजल्ट देखने के लिए यहाँ दबायें</small>
                    </a>
                </li>
                <li class="menu-item-red">
                    <a href="#">
                        <i class="bi bi-file-text"></i>
                        Terms and Condition
                        <small class="ms-2">नियम एवं शर्तें</small>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-share"></i>
                        Share
                        <small class="ms-2">जो भाई नयी डिवाइस पे खेल रहे है व्हाट्सअप पर शेयर करें</small>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-star"></i>
                        Rate our app
                        <small class="ms-2">हमारी एप्लिकेशन को सुधार देने के लिए दबायें</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>
                </li>
            </ul>
            <!-- <div class="social-links">
                <a href="#" class="text-center">
                    <i class="bi bi-chat-dots-fill text-danger"></i><br>
                    हमसे बात करने के लिए<br>यहाँ पे क्लिक करें
                </a>
                <a href="#" class="text-center">
                    <i class="bi bi-facebook text-primary"></i><br>
                    सोशल गेम के लिए हमारा<br>फेसबुक पेज जॉइन करें
                </a>
                <a href="#" class="text-center">
                    <i class="bi bi-instagram text-danger"></i><br>
                    इंस्टाग्राम पर जाने के<br>लिए क्लिक करें
                </a>
            </div> -->
        </div>
    </div>
@yield('content')
@include('layouts.footer')
