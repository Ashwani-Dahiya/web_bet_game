<!-- Fixed Footer -->
<style>
    .game-footer {
        background: linear-gradient(to right, rgb(38, 171, 248), rgb(38, 171, 248));
        box-shadow: 0 -4px 15px rgba(255, 167, 38, 0.3);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .game-footer a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        padding: 12px 16px;
        border-radius: 12px;
    }

    .game-footer a.active {
        color: #fff;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .game-footer a:hover {
        color: #fff;
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.1);
    }

    .game-footer a:hover i {
        transform: scale(1.1);
        filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
    }

    .game-footer i {
        font-size: 1.5rem;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 4px;
    }

    .game-footer div {
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Glowing effect for active item */
    .game-footer a.active::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 20px rgba(255, 255, 255, 0.4);
    }

    /* Hover effect for icons */
    .game-footer a:hover i.bi-house-door-fill {
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
    .game-footer a:hover i.bi-controller {
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
    .game-footer a:hover i.bi-wallet2 {
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
    .game-footer a:hover i.bi-question-circle {
        color: #fff;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }

    /* Active icon colors */
    .game-footer a.active i {
        color: #fff;
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.6));
    }
</style>

<footer class="fixed-bottom game-footer">
    <div class="d-flex justify-content-around">
        <a href="{{ route('home.page') }}" class="text-center {{ request()->routeIs('home.page') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <div>Home</div>
        </a>
        <a href="{{ route('play.page') }}" class="text-center {{ request()->routeIs('play.page') ? 'active' : '' }}">
            <i class="bi bi-controller"></i>
            <div>Play</div>
        </a>
        <a href="{{ route('wallet.page') }}" class="text-center {{ request()->routeIs('wallet.page') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <div>Wallet</div>
        </a>
        <a href="#" class="text-center {{ request()->routeIs('help.page') ? 'active' : '' }}">
            <i class="bi bi-question-circle"></i>
            <div>Help</div>
        </a>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/js.js') }}"></script>

</body>
</html>
