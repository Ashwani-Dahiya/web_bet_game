<!doctype html>
<html lang="en">

<head>
    <title>Login Game</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            padding: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
        }
        .card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: #FFA726;
            border-radius: 50%;
            opacity: 0.2;
        }
        .card-header {
            background: none;
            border: none;
            padding: 0 0 24px 0;
        }
        .card-title {
            font-size: 24px;
            font-weight: 600;
            color: #2D3748;
            margin: 0;
        }
        .card-subtitle {
            font-size: 14px;
            color: #718096;
            margin-top: 8px;
        }
        .form-floating {
            margin-bottom: 24px;
            position: relative;
        }
        .form-floating > .form-control {
            padding: 20px 16px 8px 40px !important;
            height: 60px;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-floating > label {
            padding: 16px 16px 0 40px;
            height: 60px;
            font-size: 14px;
            color: #718096;
            font-weight: 500;
        }
        .form-floating > .form-control:focus {
            border-color: #FFA726;
            box-shadow: 0 0 0 3px rgba(255, 167, 38, 0.1);
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: 0.8;
            transform: scale(0.85) translateY(-15px);
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
            z-index: 2;
            pointer-events: none;
        }
        .btn-primary {
            background: #FFA726;
            border: none;
            border-radius: 12px;
            padding: 16px 24px;
            font-weight: 500;
            color: white;
            width: 100%;
            margin-bottom: 16px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 56px;
        }
        .btn-primary:hover {
            background: #FF9800;
            transform: translateY(-1px);
        }
        .btn-icon {
            margin-left: 8px;
        }
        a {
            color: #FFA726;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: block;
            text-align: center;
        }
        a:hover {
            color: #FF9800;
        }
        .text-danger {
            font-size: 12px;
            margin-top: 4px;
            position: absolute;
            bottom: -20px;
            left: 0;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Login</h1>
                        <p class="card-subtitle">Please sign in to continue.</p>
                    </div>
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('post.login') }}">
                            @csrf
                            <div class="form-floating">
                                <i class="bi bi-phone input-icon"></i>
                                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile') }}" 
                                       placeholder=" " required />
                                <label for="mobile">Mobile Number</label>
                                @error('mobile')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       placeholder=" " required />
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                LOGIN
                                <i class="bi bi-arrow-right btn-icon"></i>
                            </button>
                            <a href="{{ route('auth.register') }}">Don't have an account? Sign up</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
