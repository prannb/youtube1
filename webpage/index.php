<!DOCTYPE html>
<html>
<body>

<?php
echo "My first PHP script!";
// Start slider
$("#range_50").ionRangeSlider({
    type: "double",
    min: 0,
    max: 1000,
    from: 200,
    to: 500,
    grid: true
});

// Save slider instance to var
var slider = $("#range_50").data("ionRangeSlider");

// Call sliders update method with any params
slider.update({
    min: 100,
    max: 500,
    from: 150,
    to: 450,
    step: 50
    // etc.
});
?>

</body>
</html>