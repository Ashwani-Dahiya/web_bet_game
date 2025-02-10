<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tab functionality script -->
<script>
    $(document).ready(function() {
        // Initialize Bootstrap tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#game-tabs button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Add active class to tab content when tab is shown
        $('#game-tabs button').on('shown.bs.tab', function(e) {
            $($(e.target).data('bs-target')).addClass('show active').siblings('.tab-pane').removeClass(
                'show active');
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Get initial points from the span
        let points = parseInt($('#pointDisplay').text()) || 0;

        // Function to update points
        function updatePoints() {
            let totalDeduction = 0;

            $('.input-num').each(function() {
                let value = parseInt($(this).val()) || 0;

                // Ensure value is positive
                if (value > 0) {
                    totalDeduction += value;
                } else {
                    $(this).val(''); // Reset negative or invalid inputs
                }
            });

            // Calculate new points
            let newPoints = points - totalDeduction;

            // Validation to ensure points don't go negative
            if (newPoints >= 0) {
                $('#pointDisplay').text(newPoints);
                $('#pointAddedDisplay').text(totalDeduction);
            } else {
                alert("You cannot deduct more than available points!");
                $('.input-num').val(''); // Reset inputs
            }
        }

        // Trigger update on input change
        $('.input-num').on('input', function() {
            updatePoints();
        });
    });
</script>
</body>

</html>
