$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(document).ready(function () {
        NProgress.configure({
            parent: "body",
        });
    });
    $(document).ajaxStart(function () {
        NProgress.start();
    });
    $(document).ajaxError(function () {
        NProgress.done();
    });
    $(document).ajaxSuccess(function () {
        NProgress.done();
    });

    $(document).ajaxComplete(function () {
        NProgress.done();
    });

    //checkout process
    $("#checkout").click(function () {
        var selectedOfferId = $(
            'input[name="lenderOfferingRadio"]:checked'
        ).val();

        if (selectedOfferId) {
            $.ajax({
                url: "/user/checkout/process/",
                type: "GET",
                dataType: "json",
                cache: false,
                data: {
                    selectedOfferId,
                },
                success: function (data) {
                    if (data.message) {
                        swal("Success", data.message, "success");
                        window.location.href = "/dashboard";
                    } else {
                        swal("Error", "An error occured", "error");
                    }
                },
                error: function (err) {
                    swal("Error", err, "error");
                },
            });
        } else {
            swal("Error", "Please select a payment plan", "error");
        }
    });

    $(".like-btn").click(function () {
        var id = $(this).attr("data-request-id");
        var status = $(".like-btn").val();

        $.ajax({
            url: "/feature-request/" + id + "/like",
            type: "POST",
            cache: false,
            dataType: "json",
            data: { id, status },
            success: function (response) {
                if (response === 1) {
                    $("#thumbsup" + id).addClass("thumbsup");
                    $(".like-btn" + id).val("1");
                } else if (response === "disliked") {
                    $("#thumbsup" + id).removeClass("thumbsup");
                    $(".like-btn" + id).val("0");
                } else {
                    swal("Error", "An error occured, try again", "error");
                }
            },
        });
    });
});
