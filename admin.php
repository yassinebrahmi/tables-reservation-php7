<?php
!isset($_SESSION) ? session_start() : header('Location: index.php');
if (empty($_SESSION['user']['profil']) OR !isset($_SESSION['user']['profil']))
    header('Location: router.php?query=logout');
include 'router.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Tables | <?= $_SESSION['user']["profil"] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.4.5.min.css">
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
    <link href="css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="css/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="css/select.dataTables.min.css" rel="stylesheet"/>
    <link href="css/select.dataTables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/jquery.toast.min.css"  />
    <style>
        @import url('css/fonts.googleapis.css');

        body {
            font-family: 'Roboto', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
        }

        i {
            margin-right: 10px;
        }

        /*----------multi-level-accordian-menu------------*/
        .navbar-logo {
            padding: 15px;
            color: #fff;
        }

        .navbar-mainbg {
            background-color: #5161ce;
            padding: 0px;
        }

        #navbarSupportedContent {
            overflow: hidden;
            position: relative;
        }

        #navbarSupportedContent ul {
            padding: 0px;
            margin: 0px;
        }

        #navbarSupportedContent ul li a i {
            margin-right: 10px;
        }

        #navbarSupportedContent li {
            list-style-type: none;
            float: left;
        }

        #navbarSupportedContent ul li a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 15px;
            display: block;
            padding: 20px 20px;
            transition-duration: 0.6s;
            transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        #navbarSupportedContent > ul > li.active > a {
            color: #5161ce;
            background-color: transparent;
            transition: all 0.7s;
        }

        #navbarSupportedContent a:not(:only-child):after {
            content: "\f105";
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 14px;
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
            transition: 0.5s;
        }

        #navbarSupportedContent .active > a:not(:only-child):after {
            transform: rotate(90deg);
        }

        .hori-selector {
            display: inline-block;
            position: absolute;
            height: 100%;
            top: 0px;
            left: 0px;
            transition-duration: 0.6s;
            transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            background-color: #fff;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin-top: 10px;
        }

        .hori-selector .right,
        .hori-selector .left {
            position: absolute;
            width: 25px;
            height: 25px;
            background-color: #fff;
            bottom: 10px;
        }

        .hori-selector .right {
            right: -25px;
        }

        .hori-selector .left {
            left: -25px;
        }

        .hori-selector .right:before,
        .hori-selector .left:before {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #5161ce;
        }

        .hori-selector .right:before {
            bottom: 0;
            right: -25px;
        }

        .hori-selector .left:before {
            bottom: 0;
            left: -25px;
        }


        @media (min-width: 992px) {
            .navbar-expand-custom {
                -ms-flex-flow: row nowrap;
                flex-flow: row nowrap;
                -ms-flex-pack: start;
                justify-content: flex-start;
            }

            .navbar-expand-custom .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row;
            }

            .navbar-expand-custom .navbar-toggler {
                display: none;
            }

            .navbar-expand-custom .navbar-collapse {
                display: -ms-flexbox !important;
                display: flex !important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto;
            }
        }


        @media (max-width: 991px) {
            #navbarSupportedContent ul li a {
                padding: 12px 30px;
            }

            .hori-selector {
                margin-top: 0px;
                margin-left: 10px;
                border-radius: 0;
                border-top-left-radius: 25px;
                border-bottom-left-radius: 25px;
            }

            .hori-selector .left,
            .hori-selector .right {
                right: 10px;
            }

            .hori-selector .left {
                top: -25px;
                left: auto;
            }

            .hori-selector .right {
                bottom: -25px;
            }

            .hori-selector .left:before {
                left: -25px;
                top: -25px;
            }

            .hori-selector .right:before {
                bottom: -25px;
                left: -25px;
            }
        }

        .error {
            color: red;
        }

    </style>
</head>
<body>
<header>
    <!-- Book Your Table -->
    <nav class="navbar navbar-expand-custom navbar-mainbg">
        <a class="navbar-brand navbar-logo" href="#">Book Your Table</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector">
                    <div class="left"></div>
                    <div class="right"></div>
                </div>

                <li class="nav-item <?php if (isset($_GET['active']) and ($_GET['page'] == "list_table")) echo 'active'; else echo ''; ?>">
                    <a class="nav-link" href="admin.php?page=list_table&active=1"><i
                                class="far fa-address-book"></i><b>Tables</b></a>
                </li>
                <li class="nav-item <?php if (isset($_GET['active']) and ($_GET['page'] == "list_notification")) echo 'active'; else echo ''; ?>">
                    <a class="nav-link" href="admin.php?page=list_notification&active=1"><i
                                class="far fa-calendar-alt"></i><b>Notification</b></a>
                </li>
                <li class="nav-item <?php if (isset($_GET['active']) and ($_GET['page'] == "list_book")) echo 'active'; else echo ''; ?>">
                    <a class="nav-link" href="admin.php?page=list_book&active=1"><i
                                class="far fa-calendar-alt"></i><b>Reservations</b></a>
                </li>
                <li class="nav-item <?php if (isset($_GET['active']) and ($_GET['page'] == "list_user")) echo 'active'; else echo ''; ?>">
                    <a class="nav-link" href="admin.php?page=list_user&active=1"><i
                                class="far fa-chart-bar"></i><b>Users</b></a>
                </li>
                <li class="nav-item <?php if (isset($_GET['active']) and ($_GET['page'] == "profil")) echo 'active'; else echo ''; ?>">
                    <a class="nav-link" href="admin.php?page=profil&active=1"><i class="far fa-copy"></i><b>User
                            : </b><?= $_SESSION['user']['username'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="router.php?query=logout"><i class="far fa-copy"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main role="main">
    <div class="container-fluid">
        <?php

        if (isset($_GET['page']) && $_GET['page'] == 'add_table')
            require(__Dir__ . '\add_table.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'list_table')
            require(__Dir__ . '\list_table.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'list_user')
            require(__Dir__ . '\list_user.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'list_notification')
            require(__Dir__ . '\list_notification.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'list_book')
            require(__Dir__ . '\list_reservation.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'dashboard')
            require(__Dir__ . '\dashboard.php');
        elseif (isset($_GET['page']) && $_GET['page'] == 'profil')
            require(__Dir__ . '\profil.php');

        ?>
    </div>
</main>
<!-- Bootstrap JS -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/loadingoverlay.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/dataTables.buttons.min.js"></script>
<script src="js/buttons.flash.min.js"></script>
<script src="js/buttons.html5.min.js"></script>
<script src="js/buttons.print.min.js"></script>
<script src="js/buttons.colVis.min.js"></script>
<script src="js/pdfmake.min.js"></script>
<script src="js/vfs_fonts.js"></script>
<script src="js/jszip.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/dataTables.select.min.js"></script>
<script src="js/jquery.toast.min.js"></script>

<script type="text/javascript">
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.go(1);
    };

    function test() {
        var tabsNewAnim = $('#navbarSupportedContent');
        var selectorNewAnim = $('#navbarSupportedContent').find('li').length;
        var activeItemNewAnim = tabsNewAnim.find('.active');
        var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
        var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
        var itemPosNewAnimTop = activeItemNewAnim.position();
        var itemPosNewAnimLeft = activeItemNewAnim.position();
        $(".hori-selector").css({
            "top": itemPosNewAnimTop.top + "px",
            "left": itemPosNewAnimLeft.left + "px",
            "height": activeWidthNewAnimHeight + "px",
            "width": activeWidthNewAnimWidth + "px"
        });
        $("#navbarSupportedContent").on("click", "li", function (e) {
            $('#navbarSupportedContent ul li').removeClass("active");
            $(this).addClass('active');
            var activeWidthNewAnimHeight = $(this).innerHeight();
            var activeWidthNewAnimWidth = $(this).innerWidth();
            var itemPosNewAnimTop = $(this).position();
            var itemPosNewAnimLeft = $(this).position();
            $(".hori-selector").css({
                "top": itemPosNewAnimTop.top + "px",
                "left": itemPosNewAnimLeft.left + "px",
                "height": activeWidthNewAnimHeight + "px",
                "width": activeWidthNewAnimWidth + "px"
            });
        });
    }

    $(document).ready(function () {
        setTimeout(function () {
            test();
        });
    });
    $(window).on('resize', function () {
        setTimeout(function () {
            test();
        }, 500);
    });
    $(".navbar-toggler").click(function () {
        setTimeout(function () {
            test();
        });
    });
</script>
<script>
    function checkPasswordMatch() {
        var new_password = $("#new_password").val();
        var confirmPassword = $("#conf_password").val();
        if (new_password != confirmPassword) {

            $("#CheckPasswordMatch").html('<div class="text-danger"><b>Passwords does not match!</b></div>');
            $('#fup').prop('disabled', true);
        } else {
            $('#fup').prop('disabled', false);
            $("#CheckPasswordMatch").html(' <div class="text-success"><b>Passwords match.</b></div>');
        }

    }

    $('#idtabNotify').on('click', 'tr', function (event) {

        var data = $('#idtabNotify').DataTable().rows(this).data();
        $('#title').empty();
        $('#title').html("View Book Table")
        $('#book_id').val(data[0].id);
        $('#name').val(data[0].name);
        $('#table_id').val(data[0].table_id);
        $('#phone').val(data[0].phone);
        $('#many_people').val(data[0].many_people);
        $('#day').val(data[0].day);
        $('#time').val(data[0].time);
        $('#special_request').val(data[0].special_request);
        $('#created_by').val(data[0].created_by);
        $('#created_at').val(data[0].created_at);

        $('#ViewBookModal').modal('show');

    });

    function DelUser(userid) {
        if (confirm('Are you sure you want to delete this User into the database?')) {
            $.ajax({
                url: 'router.php?query=delete_user',
                type: "POST",
                data: {user_id: userid},
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $('#idtabUser').DataTable().row('.selected').remove().draw(false);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }
    }
    function EditUser(userid) {
        $.ajax({
            url: 'router.php?query=showuser',
            type: "GET",
            data: {user_id: userid},
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var result = jQuery.parseJSON(response);
                $('#title').empty();
                $('#title').html("Edit User")
                $('#user_id').val(result.id);
                $('#name').val(result.name);
                $('#password').val(result.password);
                $('#username').val(result.username);
                $('#profil').val(result.profil);
                $("#profil option:contains(" + result.profil + ")").attr('selected', true);
                $('#AddUserModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    function DelTable(tableid) {

        if (confirm('Are you sure you want to delete this table into the database?')) {
            $.ajax({
                url: 'router.php?query=delete_table',
                type: "POST",
                data: {table_id: tableid},
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                    $('#idtab').DataTable().row('.selected').remove().draw(false);
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }

            })
        }
    }
    function EditTable(tableid) {
        $.ajax({
            url: 'router.php?query=show_table',
            type: "GET",
            data: {table_id: tableid},
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var data = jQuery.parseJSON(response);
                $('#title').empty();
                $('#title').html("Edit Table")
                $('#table_id').val(data.id);
                $('#guests').val(data.guests);
                $('#description').val(data.description);
                $("#category_id option:contains(" + data.desc + ")").attr('selected', true);
                $("#placement option:contains(" + data.placement + ")").attr('selected', true);
                $('#SaveTable').text("Update Table")
                $('#AddTableModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    function DelBook(bookid) {

        if (confirm('Are you sure you want to delete this Book into the database?')) {
            $.ajax({
                url: 'router.php?query=delete_book',
                type: "POST",
                data: {book_id: bookid},
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                    $('#idtabBook').DataTable().row('.selected').remove().draw(false);
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }

            })
        }
    }
    function EditBook(bookid) {
        $.ajax({
            url: 'router.php?query=show_book',
            type: "GET",
            data: {book_id: bookid},
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var data = jQuery.parseJSON(response);
                $('#title').empty();
                $('#title').html("Edit Book Table- Created by : " + data.created_by + "- Created At :" + data.created_at)
                $('#SaveBook').text("Book Update");
                $('#book_id').val(data.id);
                $('#name').val(data.name);
                $('#table_id').val(data.table_id);
                $('#phone').val(data.phone);
                $('#many_people').val(data.many_people);
                $('#day').val(data.day);
                $('#time').val(data.time);
                $('#special_request').val(data.special_request);
                $("#table_id option:contains(" + data.table_id + ")").attr('selected', true);
                $('#AddBookModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    $("#AcceptBook").click(function () {

        $.ajax({
            url: 'router.php?query=accept_book',
            type: "POST",
            data: {book_id: $("#book_id").val()},
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var result = jQuery.parseJSON(response);
                $.toast({
                    heading: 'Information',
                    icon: 'info',
                    text :result.message ,
                    showHideTransition : 'slide',  // It can be plain, fade or slide
                    textColor : '#000000',            // text color
                    allowToastClose : false,       // Show the close button or not
                    hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                    stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                    textAlign : 'center',            // Alignment of text i.e. left, right, center
                    position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                });
                $('#ViewBookModal').modal('hide');
                mytables = $('#idtabNotify').DataTable();
                mytables.draw();


            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $("#RefuseBook").click(function () {

        $.ajax({
            url: 'router.php?query=refuse_book',
            type: "POST",
            data: {book_id: $("#book_id").val()},
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var result = jQuery.parseJSON(response);
                $.toast({
                    heading: 'Information',
                    icon: 'info',
                    text :result.message ,
                    showHideTransition : 'slide',  // It can be plain, fade or slide
                    textColor : '#000000',            // text color
                    allowToastClose : false,       // Show the close button or not
                    hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                    stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                    textAlign : 'center',            // Alignment of text i.e. left, right, center
                    position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                });
                $('#ViewBookModal').modal('hide');
                mytables = $('#idtabNotify').DataTable();
                mytables.draw();


            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    });
    $("#CloseForm").click(function () {
        $('#AddTableModal').modal('hide');
    });
    $("#CloseFormUser").click(function () {
        $('#AddUserModal').modal('hide');
    });
    $("#CloseFormBook").click(function () {
        $('#AddBookModal').modal('hide');
    });
    $("#CloseFormViewBook").click(function () {
        $('#ViewBookModal').modal('hide');
    });
    $("#FormModalAddTable").validate({
        rules: {
            placement: {
                required: true
            },
            category_id: {
                required: true
            },
            guests: {
                required: true,
                minlength: 1
            },
            description: {required: false}

        },
        messages: {
            reference: {
                required: "Please enter some reference",
                minlength: "Min 1 person"
            },
            action: "Please provide some data"
        },
        submitHandler: function () {
            $.ajax({
                url: 'router.php?query=save_table&table_id=' + $("#table_id").val(),
                type: "POST",
                data: {
                    placement: $('#placement').val(),
                    category_id: $('#category_id').val(),
                    guests: $('#guests').val(),
                    description: $('#description').val()
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                    $('#AddTableModal').modal('hide');
                    mytables = $('#idtab').DataTable();
                    mytables.draw();


                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }
    });
    $("#FormModalAddUser").validate({
        rules: {
            name: {
                required: true
            },
            username: {
                required: true
            },
            password: {
                required: true,
                minlength: 1
            },
            profil: {required: false}

        },
        messages: {
            password: {
                required: "Please enter some password",
                minlength: "Min 6 char"
            },
            action: "Please provide some data"
        },
        submitHandler: function () {
            $.ajax({
                url: 'router.php?query=save_user&user_id=' + $("#user_id").val(),
                type: "POST",
                data: {
                    name: $('#name').val(),
                    username: $('#username').val(),
                    password: $('#password').val(),
                    profil: $('#profil').val()
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                 //   alert(result.message);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                    ///****

                    $('#AddUserModal').modal('hide');
                    myusers = $('#idtabUser').DataTable();
                    myusers.draw();
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        }
    });
    $("#FormModalAddBook").validate({
        rules: {
            table_id: {
                required: true
            },
            name: {required: true},
            many_people: {
                required: true,
                minlength: 1
            },
            day: {required: true},
            time: {required: true},
            phone: {required: false},
            special_request: {required: false}

        },
        messages: {
            reference: {
                required: "Please enter some reference",
                minlength: "Min 1 person"
            },
            action: "Please provide some data"
        },
        submitHandler: function () {
            $.ajax({
                url: 'router.php?query=save_book&book_id=' + $("#book_id").val(),
                type: "POST",
                data: {
                    book_id: $('#book_id').val(),
                    table_id: $('#table_id').val(),
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    many_people: $('#many_people').val(),
                    day: $('#day').val(),
                    time: $('#time').val(),
                    special_request: $('#special_request').val()
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                },
                success: function (response) {
                    var result = jQuery.parseJSON(response);
                    $.toast({
                        heading: 'Information',
                        icon: 'info',
                        text :result.message ,
                        showHideTransition : 'slide',  // It can be plain, fade or slide
                        textColor : '#000000',            // text color
                        allowToastClose : false,       // Show the close button or not
                        hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                        textAlign : 'center',            // Alignment of text i.e. left, right, center
                        position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    });
                    $('#AddBookModal').modal('hide');
                    mybooks = $('#idtabBook').DataTable();
                    mybooks.draw();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                }
            });
        }
    });
    $("#day").change(function () {
        var today = new Date();
        var datemin = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
        var d1 = new Date($('#day').val());
        var d2 = new Date(datemin);
        if (d1 < d2) {

            alert('Book Table error day');
            $('#day').val("<?= date('Y-m-d', time()); ?>")
        }
    });
    $("#FormProfil").submit(function (event) {
        $.ajax({
            url: 'router.php?query=profil_update',
            type: "POST",
            data: {
                user_id: $('#user_id').val(),
                name: $('#name').val(),
                new_password: $('#new_password').val(),
                email: $('#email').val(),
                username: $('#username').val()

            },
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            complete: function () {
                $.LoadingOverlay("hide");
            },
            success: function (response) {
                var result = jQuery.parseJSON(response);
                $.toast({
                    heading: 'Information',
                    icon: 'info',
                    text :result.message ,
                    showHideTransition : 'slide',  // It can be plain, fade or slide
                    textColor : '#000000',            // text color
                    allowToastClose : false,       // Show the close button or not
                    hideAfter : 3000,              // `false` to make it sticky or time in miliseconds to hide after
                    stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
                    textAlign : 'center',            // Alignment of text i.e. left, right, center
                    position : 'top-center'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                });
                window.location.href = "router.php?query=logout";
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
        event.preventDefault();
    });
    $(document).ready(function () {
        $("#conf_password").keyup(checkPasswordMatch);

// dt Tables :
        $('#idtab').DataTable({
            "dom": "Bfrltip",
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            "ajax": {
                "url": "router.php?query=alltables",
                "type": "POST"
            },
            "order": [[1, 'desc']],
            buttons: [
                {
                    text: '<img src="./images/table.jpg"> New Table',
                    action: function (e, dt, node, config) {
                        $('#title').empty();
                        $('#title').html("Add New Table")
                        $('#FormModalAddTable').trigger("reset");
                        $("#placement option").prop("selected", false).trigger( "change" );
                        $("#category_id option").prop("selected", false).trigger( "change" );
                        $('#AddTableModal').modal('show');

                    }
                }
                ],
            pageLength: 0,
            lengthMenu: [5, 10, 20, 50],
            "columns": [
                {"data": "id", "visible": false, target: 0},
                {"data": "category_id", "visible": false, target: 1},
                {"data": "ref", target: 2},
                {"data": "placement", target: 3},
                {"data": "desc", target: 4},
                {"data": "guests", target: 5},
                {"data": "created_at", target: 6},
                {"data": "category_id", "visible": false, target: 7},
                {"data": "actions", target: 8}
            ]
        });
// dt Users :
        $('#idtabUser').DataTable({
            "dom": "Bfrltip",
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            "ajax": {
                "url": "router.php?query=allusers",
                "type": "POST"
            },
            order: [[5, "desc"]],
            buttons: [
                {
                    text: '<img src="./images/user.png"> New User',
                    action: function (e, dt, node, config) {
                        $('#title').empty();
                        $('#title').html("Add User")
                        $('#FormModalAddUser').trigger("reset");
                        $('#SaveTable').text("Save Table")
                        $('#AddUserModal').modal('show');
                    }
                }],
            processing: true,
            pageLength: 0,
            lengthMenu: [5, 10, 20, 50],
            "columns": [
                {"data": "id", "visible": false, target: 0},
                {"data": "name", target: 1},
                {"data": "username", target: 2},
                {"data": "profil", target: 3},
                {"data": "created_by", target: 4},
                {"data": "created_at", target: 5},
                {"data": "password", "visible": false, target: 6},
                {"data": "actions", target:7}
            ]

        });
// dt Book :
        $('#idtabBook').DataTable({
            dom: "Bfrltip",
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            "ajax": {
                "url": "router.php?query=allbooks",
                "type": "POST"
            },
            "order": [[1, 'desc']],
            buttons: [{
                text: 'Make a reservation',
                action: function (e, dt, node, config) {
                    $('#title').empty();
                    $('#title').html("Make a reservation");
                    $('#FormModalAddBook').trigger("reset");
                    $('#SaveBook').text("Book Now");
                    $('#AddBookModal').modal('show');
                }
            },
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    className: 'btn-danger',
                    text: '<img src="./images/pdf.png"> PDF Report',
                    exportOptions: {
                        columns: [2,3,4,5,6,7,9,10],
                        orientation: 'landscape'
                    }
                }
            ],
            pageLength: 0,
            lengthMenu: [5, 10, 20, 50],
            "columns": [
                {"data": "id", "visible": false, target: 0},
                {"data": "table_id", "visible": false, target: 1},
                {"data": "tablebook", target: 2},
                {"data": "name", target: 3},
                {"data": "phone", "visible": false, target: 4},
                {"data": "many_people", width: 100, target: 5},
                {"data": "day", target: 6},
                {"data": "time", target: 7},
                {"data": "special_request", "visible": false, target: 8},
                {"data": "status", width: 20, target: 9},
                {"data": "created_by", "visible": false, target: 10},
                {"data": "created_at", "visible": false, target: 11},
                {"data": "actions", target: 12}
            ]

        });
// dt Notification :
        $('#idtabNotify').DataTable({
            dom: "Bfrltip",
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            "ajax": {
                "url": "router.php?query=allnotifys",
                "type": "POST"
            },
            order: [[10, "desc"]],
            buttons: [],
            pageLength: 0,
            lengthMenu: [5, 10, 20, 50],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },

            "columns": [
                {"data": "id", "visible": false, target: 0},
                {"data": "table_id", "visible": false, target: 1},
                {"data": "tablebook", target: 2},
                {"data": "name", target: 3},
                {"data": "phone", "visible": false, target: 4},
                {"data": "many_people", target: 5},
                {"data": "day", target: 6},
                {"data": "time", target: 7},
                {"data": "special_request", "visible": false, target: 8},
                {"data": "status", target: 9},
                {"data": "created_by", "visible": false, target: 10},
                {"data": "created_at", target: 11},
                {"data": "actions", target: 12}
            ]
        });

        document.getElementById("day").defaultValue = "<?= date('Y-m-d', time()); ?>";
        document.getElementById("time").defaultValue = "<?= date('H:i', strtotime('+0 hour')) ?>";


    });
</script>
</body>
</html>