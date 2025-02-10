<!-- Fixed Footer -->
<footer class="fixed-bottom">
    <div class="d-flex justify-content-around py-2 bg-light">
        <a href="{{ route('home.page') }}" class="text-center active">
            <i class="bi bi-house-door-fill"></i>
            <div>Home</div>
        </a>
        <a href="{{ route('play.page') }}" class="text-center">
            <i class="bi bi-controller"></i>
            <div>Play</div>
        </a>
        <a href="{{ route('wallet.page') }}" class="text-center">
            <i class="bi bi-wallet2"></i>
            <div>Wallet</div>
        </a>
        <a href="#" class="text-center">
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
