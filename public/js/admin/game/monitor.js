$(document).ready(function() {
    $(".timer").each(function() {
        var time = $(this).data("time");

        $(this).timer({
            action: "start",
            duration: time,
            countdown: true,
            callback: function() {
               window.location.reload()
            }
        });
    });
});
