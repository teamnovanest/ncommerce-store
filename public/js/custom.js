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
                url: "/user/checkout/process",
                type: "GET",
                dataType: "json",
                cache: false,
                data: {
                    selectedOfferId,
                },
                success: function (data) {
                    NProgress.done();
                    if (data.message) {
                        Swal.fire({icon: 'success', title: data.message,   showCloseButton: true});
                        window.location.href = "/dashboard";
                    } else {
                        //swal("Error", "An error occured", "error");
                        Swal.fire({icon: 'error', title:"An error occured",   showCloseButton: true});
                    }
                },
                error: function (error) {
                    
                    NProgress.done();
                    //swal("Error", error.message, "error");
                    var parsedResponse  = JSON.parse(error);
                    Swal.fire({icon: 'error', title: parsedResponse.message,   showCloseButton: true});
                },
            });
        } else {
            Swal.fire({icon: 'error', title:"Please select a payment plan",   showCloseButton: true});
        }
    });

    $(".like-btn").click(function () {
        var id = $(this).attr("data-request-id");
        var status = $("#thumbsup" + id).attr("data-value-id");

        $.ajax({
            url: "/feature-request/" + id + "/like",
            type: "POST",
            cache: false,
            dataType: "json",
            data: { id, status },
            success: function (response) {
                // console.log("response =>", response.status);
                if (response.status === "liked") {
                    $("#thumbsup" + id).addClass("thumbsup");
                    $("#thumbsup" + id).attr("data-value-id", 1);
                    $("#likes" + id).html(response.results.likes);
                } else if (response.status === "disliked") {
                    $("#thumbsup" + id).removeClass("thumbsup");
                    $("#thumbsup" + id).attr("data-value-id", 0);
                    $("#likes" + id).html(response.results.likes);
                } else {
                    swal("Error", "An error occured, try again", "error");
                }
            },
        });
    });
    // Disable quantity update button on page load
    $(".btn-update-qty").prop("disabled", true);

    // Enable quantity update button if quantity changes
    $(".qty").on("change", function (evt) {
        console.log($(this).val());
        $(this).siblings(".btn-update-qty").prop("disabled", false);
    });
});
