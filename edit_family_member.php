<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_SESSION['id'];
$edit_id = $_GET['id'];
if (isset($_POST['submit'])) {
    //user_name full_name  dob mobile_no  previlege_type
    $user_name = $_POST['user_name'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $mobile_no = $_POST['mobile_no'];

    $sql = "update `family_members` set `username`='$user_name', `full_name`='$full_name', `date_of_birth`='$dob', `mobile_number`='$mobile_no' where member_id = '$edit_id'";

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {

        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
$rows = mysqli_fetch_array(mysqli_query($conn, "SELECT `member_id`, `user_id`, `username`, `full_name`, `date_of_birth`, `mobile_number`,
 `privilege_status`, `status` FROM `family_members` WHERE member_id='$edit_id'"));
?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible" id="s_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Family Member Updated Successfully!!!.
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
            <h6><strong> ::: Edit Family Member ::: </strong></h6>
            <hr/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">User Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="user_name" id="user_name"
                                   value="<?php echo $rows['username']; ?>" class="form-control" />
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
                            <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="dob" id="dob" value="<?php echo $rows['date_of_birth']; ?>"
                                   class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Mobile No.</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="mobile_no" id="mobile_no" value="<?php echo $rows['mobile_number']; ?>"
                                   class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="family_member.php" type="button" name="submit" class="btn btn-warning"
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