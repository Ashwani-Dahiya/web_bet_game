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
