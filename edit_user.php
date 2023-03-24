<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_SESSION['id'];
$edit_id = $_GET['id'];
if (isset($_POST['submit'])) {
    //user_name full_name  dob mobile_no  previlege_type
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $mobile_no = $_POST['mobile_no'];
    $e_id = $_POST['e_id'];

    $sql = "update `td_user` set full_name='$full_name', `dob`='$dob', `mobile_no`='$mobile_no'  where id = '$e_id'";
    //echo $sql;

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {

        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
$rows = mysqli_fetch_array(mysqli_query($conn, "SELECT `id`, `user_name`, `full_name`, `dob`, `mobile_no`,
 `user_type` FROM `td_user` WHERE `id`='$edit_id'"));
?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible" id="s_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> User Information Updated Successfully!!!.
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

    <form method="post" action="" enctype="multipart/form-data">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #f8f8f8; border-radius: 5px; border: 1px solid black; ">
            <h6><strong> ::: Edit User Information ::: </strong></h6>
            <hr/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">User Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="user_name" id="user_name"
                                   value="<?php echo $rows['user_name']; ?>" class="form-control" readonly />
                            <input class="col-md-12 col-sm-12 col-xs-12" type="hidden" name="e_id" id="e_id"
                                   value="<?php echo $edit_id; ?>" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Full Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="full_name" id="full_name"
                                   value="<?php echo $rows['full_name']; ?>" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Date of birth</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="dob" id="dob" value="<?php echo $rows['dob']; ?>"
                                   class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Mobile No.</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="mobile_no" id="mobile_no" value="<?php echo $rows['mobile_no']; ?>"
                                   class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="user_list.php" type="button" name="submit" class="btn btn-warning"
                               style="float: left; border: 1px solid #d9d9d9"><i
                                        class="fa fa-arrow-circle-left"></i> Back </a>
                            <button type="submit" name="submit" class="btn btn-success" style="float: right">Save <i
                                        class="fa fa-check-circle"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function getDate(val) {
        if (val == "Y"){
            $("#payment_date").removeAttr('disabled');
        }else{
            $("#payment_date").prop("disabled", true);
        }

    }
</script>

</body>
</html>