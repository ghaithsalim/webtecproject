<?php
include_once 'session.php';
$type = $_SESSION['user_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal Banking Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--for bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!--for font awesome icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--for bootstrap js-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--for datatable js-->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <style>
        body {
            font: 15px Montserrat, sans-serif;
            line-height: 1.8;
            color: #f5f6f7;
        }

        p {
            font-size: 16px;
        }

        .margin {
            margin-bottom: 10px;
        }

        .margin_left {
            margin-left: 5px;
        }

        .bg-1 {
            background-color: #1abc9c; /* Green */
            color: #ffffff;
        }

        .bg-2 {
            background-color: #474e5d; /* Dark Blue */
            color: #ffffff;
        }

        .bg-3 {
            background-color: #ffffff; /* White */
            color: #555555;
        }

        .bg-4 {
            background-color: #2f2f2f; /* Black Gray */
            color: #fff;
        }

        .container-fluid {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .navbar {
            padding-top: 5px;
            padding-bottom: 5px;
            border: 0;
            border-radius: 0;
            margin-bottom: 0;
            font-size: 15px;
            letter-spacing: 2px;
        }

        .navbar-nav li a:hover {
            color: #1abc9c !important;
        }

        .table th {
            font-size: 12px;
        }

        .left_align {
            float: left;
        }

        .margin_a {
            margin-left: 30px;
            margin-right: 30px;
        }

        hr {
            border-top: 1px solid #4ab131;
        }

        input {
            border: 1px solid #CFCFCF;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li style="font-size: 15px;"><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
            </ul>


            <?php if ($type == '1') { ?>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="dashboard.php"><i class="fa fa-paw"></i> Dashboard</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="family_member.php"><i class="fa fa-user"></i> Family
                            Member</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="bill_pay.php"><i class="fa fa-refresh"></i> Pay Bill</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="gift_voucher.php"><i class="fa fa-birthday-cake"></i> Birthday
                            Gift Voucher </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="debit_list.php"><i class="fa fa-money"></i> Add Debits</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="chatbot.php"><i class="fa fa-comments"></i> Chatbot</a>
                    </li>
                </ul>

            <?php } else if ($type == '3') { ?>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="dashboard.php"><i class="fa fa-paw"></i> Dashboard</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="user_list.php"><i class="fa fa-user"></i> User List</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li style="font-size: 15px;"><a href="deposit.php"><i class="fa fa-money"></i> Deposit</a></li>
                </ul>
            <?php } ?>
            <ul class="nav navbar-nav navbar-left">
                <li style="font-size: 15px;"><a href="bill_pay.php"><i class="fa fa-refresh"></i> Pay Bill</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li style="font-size: 15px;" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-empire"></i> Statement
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="transaction_report.php"><i class="fa fa-gear"></i> Transaction Report</a></li>
                    </ul>
                </li>
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <li style="font-size: 15px;"><a href="logout.php">Logout <i class="fa fa-sign-out"></i> </a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li style="font-size: 15px;"><a href="#">Welcome, <?php echo $_SESSION['name']; ?></a></li>
            </ul>
        </div>
    </div>
</nav>