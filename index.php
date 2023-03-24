<?php
include 'db/config.php';
session_start();
if (isset($_POST['login'])) {

    $user_name = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT `id`, `user_name`, `full_name`, `dob`, `mobile_no`, `password`, `user_type`, `status`, card_stauts FROM `td_user` 
WHERE `user_name`='$user_name' and password='$password' and status='Y'");
    $result = mysqli_fetch_array($sql);

    if ($result == null) {
        $_SESSION['error'] = "User Name or Passwrod is mismatch!!! Please try again.";
    } else {
        $_SESSION['name'] = $result['user_name'];
        $_SESSION['full_name'] = $result['full_name'];
        $_SESSION['id'] = $result['id'];
        $_SESSION['user_type'] = $result['user_type'];
        $_SESSION['card_stauts'] = $result['card_stauts'];
        header("Location: home.php");
    }
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $fullName = $_POST['fullName'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $sql = "INSERT INTO `td_user`(`user_name`, `full_name`, `dob`, `mobile_no`,`password`, `user_type`, `status`) VALUES 
('$name','$fullName','$dob', '$mobile','$password','1', 'Y')";


    $account = round(microtime(true) * 1000);
    if (mysqli_query($conn, $sql)){
        $id = mysqli_insert_id($conn);
        $result=  mysqli_query($conn, "INSERT INTO `td_account`(`account_no`, `user_id`, `balance`) VALUES ('$account', '$id', '0.0' )");
    }

    if ($result != null) {
        $_SESSION['success'] = "1";
    } else {
        $_SESSION['error'] = "2";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Banking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
-->
    <!--for bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!--for font awesome icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--for bootstrap js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-control {
            height: 50px;
        }
    </style>
</head>
<body>
<div class="container">



    <div class="col-md-6 col-sm-12 col-xs-12">
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible" id="s_message">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> You have registered Successfully!!!.
            </div>
            <?php
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) { ?>

            <div class="alert alert-danger alert-dismissible" id="e_message">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error!</strong> Something Went Wrong. Please try again!!!.
            </div>
            <?php unset($_SESSION['error']);
        } ?>
        <div class="login-panel panel panel-default">
            <div class="panel-heading" style="height:50px;">
                <h3 class="panel-title" style="font-size: 25px;">Sign In</h3>
            </div>
            <div class="panel-body">
                <form name="form1" method="post" action="" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Username" name="username" type="text" required="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" required>
                        </div>
                        <p class="text-center"><a href="" data-toggle="modal" data-target="#modalLoginForm"><b> Don't have
                                    an account Create one by clicking here</a></b></p>
                        <button type="submit" class="btn btn-lg btn-success btn-block" name="login">Login</button>

                        <p class="text-center" style="color: darkred;"><b> <?php if (isset($_SESSION['error'])) {
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                } ?></b></p>

                        <br/>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<form class="card-body cardbody-color p-lg-5" name="form2" method="post" action="" enctype="multipart/form-data">
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center" style="background-color: #283c6a; color: white;  ">
                    <h4 class="modal-title w-100 font-weight-bold">Register</h4>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5" style="margin-bottom: 10px;">
                        <input type="text" id="name" name="name" class="form-control validate" placeholder="Enter User Name">
                    </div>

                    <div class="md-form mb-5" style="margin-bottom: 10px;">
                        <input type="text" id="fullname" name="fullName" class="form-control validate" placeholder="Enter Full Name">
                    </div>


                    <div class="md-form mb-5" style="margin-bottom: 10px;">
                        <input type="date" id="dob" name="dob" class="form-control validate" placeholder="Enter date of birth">
                    </div>
                    <div class="md-form mb-5" style="margin-bottom: 10px;">
                        <input type="text" id="mobile" name="mobile" class="form-control validate" placeholder="Enter mobile no.">
                    </div>

                    <div class="md-form mb-4" style="margin-bottom: 10px;">
                        <input type="password" id="defaultForm-pass" name="password" class="form-control validate"
                               placeholder="Enter Password">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-danger" type="submit" name="register" style="float: left">Close <i
                                class="fa fa-close"></i></button>
                    <button class="btn btn-success" type="submit" name="register" style="float: right">Save <i
                                class="fa fa-check-circle"></i></button>
                </div>
            </div>
        </div>
    </div>


    <!--modal end-->
</form>

</body>
</html>