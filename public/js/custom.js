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
                            title: "Success",
                            text: data.message,
                            showCloseButton: true,
                        });
                        window.location.href = "/dashboard";
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Oops an error occured. Try again or contact support if issue persist.",
                            showCloseButton: true,
                        });
                    }
                },
                error: function (error) {
                    NProgress.done();

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error.responseJSON.message,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Please select a payment plan",
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
                    $("#disliked_request" + id).hide(); //from the userlikes page
                } else if (response.status === "liked_already") {
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: "You liked this request. To dislike it,Click on the icon or  go to the likes section and click on the thumbs icon to dislike it.",
                        showCloseButton: true,
                    });
                    $("#thumbsup" + id).addClass("thumbsup");
                    $("#thumbsup" + id).attr("data-value-id", 1);
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
                        timer: 5000,
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
                        timer: 5000,
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

    //customer order update js
    $(".updateRadio").on("click", function () {
        var statusId = $(this).val();
        var orderId = $(this).attr("data-order-id");
        var productId = $(this).attr("data-product-id");
        var orderDetailId = $(this).attr("data-order-datail-id");

        if (statusId && orderId && productId && orderDetailId) {
            $.ajax({
                url: "/order/" + orderId + "/" + orderDetailId + "/update",
                type: "POST",
                cache: false,
                dataType: "json",
                data: {
                    statusId,
                    productId,
                },

                success: function (data) {
                    $("#statustd" + orderDetailId).empty();
                    $("#statustd" + orderDetailId).append(
                        `<span class="badge badge-success">${data.status_name}</span>`
                    );
                    $(".updateCheckBox" + orderDetailId).hide();
                    $(".lable" + orderDetailId).html("Yes");
                    NProgress.done();
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Order updated successfully",
                        showCloseButton: true,
                    });
                },
                error: function (error) {
                    NProgress.done();
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error.attrresponseJSON.error,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            NProgress.done();
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An error occured. Try again or contact support if issue persist",
                showCloseButton: true,
            });
        }
    });

    //Product review rating js
    $("#star1").hover(function () {
        $(".rate").removeClass("mystar");
        $("#star1").addClass("mystar");
    });
    $("#star2").hover(function () {
        $(".rate").removeClass("mystar");
        $("#star1, #star2").addClass("mystar");
    });
    $("#star3").hover(function () {
        $(".rate").removeClass("mystar");
        $("#star1, #star2, #star3").addClass("mystar");
    });
    $("#star4").hover(function () {
        $(".rate").removeClass("mystar");
        $("#star1, #star2, #star3, #star4").addClass("mystar");
    });
    $("#star5").hover(function () {
        $(".rate").removeClass("mystar");
        $("#star1, #star2, #star3, #star4, #star5").addClass("mystar");
    });

    // removing the color when the user leaves without clicking on any star
    $(".rating").hover(function () {
        $("#star1, #star2, #star3, #star4, #star5").removeClass("mystar");
    });

    var selected_rating;
    $(".rate").on("click", function (evt) {
        selected_rating = parseInt($(this).attr("data-rate-id"));

        if (selected_rating === 1) {
            $(".rating__list").empty();
            $(".rating__list").append(`
            <ul class="rating">
            <li><i class="zmdi zmdi-star mystar"></i></li>
                <li><i class="zmdi zmdi-star"></i></li>
                <li><i class="zmdi zmdi-star"></i></li>
                <li><i class="zmdi zmdi-star"></i></li>
                <li><i class="zmdi zmdi-star"></i></li>
            </ul>`);
        } else if (selected_rating === 2) {
            $(".rating__list").empty();
            $(".rating__list").append(`
            <ul class="rating">
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            </ul>`);
        } else if (selected_rating === 3) {
            $(".rating__list").empty();
            $(".rating__list").append(`
            <ul class="rating">
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            </ul>`);
        } else if (selected_rating === 4) {
            $(".rating__list").empty();
            $(".rating__list").append(`
            <ul class="rating">
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star"></i></li>
            </ul>`);
        } else if (selected_rating === 5) {
            $(".rating__list").empty();
            $(".rating__list").append(`
            <ul class="rating">
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            <li><i class="zmdi zmdi-star mystar"></i></li>
            </ul>`);
        }
    });

    $("#submit-review-btn").on("click", function (evt) {
        evt.preventDefault();
        var product_id = $(this).attr("data-product-id");
        var review = $('textarea[name="review"]').val();

        if (selected_rating && product_id) {
            $.ajax({
                url: "/product/review",
                type: "GET",
                dataType: "json",
                cache: false,
                data: {
                    selected_rating,
                    product_id,
                    review,
                },
                success: function (data) {
                    if (data.message) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: data.message,
                            showCloseButton: true,
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
                error: function (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error.responseJSON.error,
                        showCloseButton: true,
                    });
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Please add a rating",
                showCloseButton: true,
            });
        }
    });
    //select finance institution js

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function () {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li")
            .eq($("fieldset").index(next_fs))
            .addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });
                    next_fs.css({ opacity: opacity });
                },
                duration: 600,
            }
        );
    });

    $(".previous").click(function () {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li")
            .eq($("fieldset").index(current_fs))
            .removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });
                    previous_fs.css({ opacity: opacity });
                },
                duration: 600,
            }
        );
    });

    $(".radio-group .radio").click(function () {
        $(this).parent().find(".radio").removeClass("selected");
        $(this).addClass("selected");
    });

    $(".submit").click(function () {
        return false;
    });

    //product questiong and answer js
    //submithing questions
    $("#submit-questions-btn").on("click", function (evt) {
        evt.preventDefault();
        var product_id = $(this).attr("data-product-id");
        var merchant_organization_id = $(this).attr(
            "data-merchant-organization-id"
        );
        var question = $('textarea[name="question"]').val();

        if (product_id && question && merchant_organization_id) {
            $.ajax({
                url: "/product/question",
                type: "POST",
                dataType: "json",
                cache: false,
                data: {
                    product_id,
                    question,
                    merchant_organization_id,
                },
                success: function (data) {
                    $("#productQuestionContainer").append(`
                        <div class="pro__review ans">
                            <div class="review__thumb thumb_image">
                                <img src=${data.profile_secure_url} alt="user_image"> 
                            </div>
                            <div class="review__details">
                                <div class="review__info">
                                    <h5><a href="#">${data.name}</a></h5> 
                                </div>
                                <div class="review__date">
                                    <span>${data.created_at}</span>
                                </div>
                                <p> ${data.question}</p>
                                <p> ${data.answer}</p>
                                </div>
                            </div>`);
                    $('textarea[name="question"]').empty();

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An error occured",
                        showCloseButton: true,
                    });
                },
                error: function (error) {
                    if (error.status === 401) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "You are not logged, in Please login to ask your question.",
                            showCloseButton: true,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: error.responseJSON.error,
                            showCloseButton: true,
                        });
                    }
                },
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Oops... An error occured try again or contact support if issue persist.",
                showCloseButton: true,
            });
        }
    });

    //fetching questions and answers
    $("#QandATab").on("click", function (evt) {
        evt.preventDefault();

        var product_id = $('input[name="product_id"]').val();
        $.ajax({
            url: "/product/" + product_id + "/questions/answers",
            type: "GET",
            dataType: "json",
            cache: false,
            data: {
                product_id,
            },
            success: function (data) {
                $.each(data, function (index, value) {
                    $("#productQuestionContainer").append(`
                    <div class="pro__review ans">
                            <div class="review__thumb">
                                <img src=${value.profile_secure_url} alt="user_image"> 
                            </div>
                            <div class="review__details">
                                <div class="review__info">
                                    <h5><a href="#">${value.name}</a></h5> 
                                </div>
                                <div class="review__date">
                                    <span>${value.created_at}</span>
                                </div>
                                <p> ${value.question}</p>
                                <p> ${value.answer}</p>
                                </div>
                            </div>`);
                });
            },
            error: function (error) {
                if (error.status === 401) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "You are not logged, in Please login to view product questions and answers.",
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Oops an error occured, please try again or contact support if issue persist.",
                        showCloseButton: true,
                    });
                }
            },
        });
    });
    //end of ready function
});
