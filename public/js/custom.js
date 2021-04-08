$(document).ready(function () {
    alert("Welcome");
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

    //order update js
    $("#lender_organization_select").change(function () {
        console.log("Change");
        // var selected_status = $("select[name=selected_status]").val();
        // var user_id = $("input[name=user_id]").val();
        // var orderId = $("input[name=order_id]").val();
        // var merchant_organization_id = $("input[name=organization_id]").val();
        // var data_order_id = $(this).attr("data-order-id");

        // if (selected_status && user_id && orderId && merchant_organization_id) {
        //     $.ajax({
        //         url: "/order/" + orderId + "/update/",
        //         type: "POST",
        //         dataType: "json",
        //         data: {
        //             selected_status,
        //             user_id,
        //             orderId,
        //             merchant_organization_id,
        //         },
        //         success: function (data) {
        //             if (!data.message) {
        //                 if (
        //                     data.status_name === "ORDER RECEIVED" ||
        //                     data.status_name === "ORDER APPROVED" ||
        //                     data.status_name === "ORDER COMPLETED"
        //                 ) {
        //                     $(".statusdiv").empty();
        //                     $(".statusdiv").append(
        //                         `<h2 class='text-success font-weight-bold'>${data.status_name}</h2>`
        //                     );
        //                 } else {
        //                     $(".statusdiv").empty();
        //                     $(".statusdiv").append(
        //                         `<h2 class='text-danger font-weight-bold'>${data.status_name}</h2>`
        //                     );
        //                 }
        //                 swal("Success", "Order update successful", "success");
        //             } else {
        //                 swal("Error", data.message, "error");
        //             }
        //         },
        //     });
        // } else {
        //     swal("Nothing selected", "Select a status and try again", "error");
        // }
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
