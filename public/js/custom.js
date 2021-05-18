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
                        Swal.fire({
                            icon: "success",
                            title: data.message,
                            showCloseButton: true,
                        });
                        window.location.href = "/dashboard";
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "An error occured",
                            showCloseButton: true,
                        });
                    }
                },
                error: function (error) {
                    NProgress.done();

                    Swal.fire({
                        icon: "error",
                        title: "Order could not be placed. Please try again later",
                        text: error.responseJSON.message,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Please select a payment plan",
                showCloseButton: true,
            });
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
                if (response.status === "liked") {
                    $("#thumbsup" + id).addClass("thumbsup");
                    $("#thumbsup" + id).attr("data-value-id", 1);
                    $("#likes" + id).html(response.results.likes);
                } else if (response.status === "disliked") {
                    $("#thumbsup" + id).removeClass("thumbsup");
                    $("#thumbsup" + id).attr("data-value-id", 0);
                    $("#likes" + id).html(response.results.likes);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An error occured, try again",
                        showCloseButton: true,
                    });
                }
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: err.responseJSON.error,
                    showCloseButton: true,
                });
            },
        });
    });
    // Disable quantity update button on page load
    $(".btn-update-qty").prop("disabled", true);

    // Enable quantity update button if quantity input valu changes
    $(".qty").on("change", function (evt) {
        $(this).siblings(".btn-update-qty").prop("disabled", false);
    });

    // Hide and show browse category area on samller devices only
    $(document).ready(function () {
        $(".categories-menu").click(function () {
            $(this).closest("div").find(".category-menu-list").toggle(500);
        });
    });

    //add to cart js
    $(".addcart").on("click", function () {
        var id = $(this).data("id");
        if (id) {
            $.ajax({
                url: "/add/to/cart/" + id,
                type: "GET",
                datType: "json",
                success: function (data) {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });
                    Toast.fire({ icon: "success", title: data.success });
                    window.location.reload();
                },
                error: function (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: err.responseJSON.error,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An error, try again or contact support if issue persist",
                showCloseButton: true,
            });
        }
    });

    // add to wishlist js
    $(".addwishlist").on("click", function () {
        var id = $(this).data("id");

        if (id) {
            $.ajax({
                url: "/add/wishlist/" + id,
                type: "GET",
                datType: "json",
                success: function (data) {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            icon: "success",
                            title: data.success,
                        });
                        window.location.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: data.error,
                            showCloseButton: true,
                        });
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: err.responseJSON.error,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An error. Try again or contact support if issue persist",
                showCloseButton: true,
            });
        }
    });

    //return js
    $(document).on("click", "#return", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        swal({
            title: "Are you sure want to Return?",
            text: "Once you proceed, a refund will have to be processed!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = link;
            } else {
                swal("Cancel!");
            }
        });
    });

    //end of ready function
});
