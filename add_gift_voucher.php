<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    //member_id amount payment_option
    $member_id = $_POST['member_id'];
    $amount = $_POST['amount'];
    $payment_option = $_POST['payment_option'];
    $date  = mysqli_fetch_array(mysqli_query($conn, "SELECT `date_of_birth` FROM `family_members` WHERE `member_id`='$member_id'"));
    $dob = $date['date_of_birth'];

    $sql = "INSERT INTO `birthdays`(`user_id`, `member_id`, `amount`, `birthday_date`, `sending_type`) 
VALUES ('$id', '$member_id', '$amount', '$dob', '$payment_option')";

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible" id="s_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Gift Voucher Added Successfully!!!.
        </div>
        <?php
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) { ?>

        <div class="alert alert-danger" id="e_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php unset($_SESSION['error']);
    } ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #f8f8f8; border-radius: 5px; border: 1px solid black; ">
            <h6><strong> ::: Add Gift Voucher ::: </strong></h6>
            <hr/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Member Name</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="member_id" id="member_id" required>
                                <option value="">Select Member</option>
                                <?php $sql = mysqli_query($conn, "SELECT `member_id`, `full_name` FROM `family_members` WHERE status='Y' AND user_id='$id'");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['member_id'] ?>"><?php echo $row['full_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Amount</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="number" name="amount" id="amount"
                                   placeholder="Please Enter Amount" class="form-control" step="0.001"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Payment Type</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="payment_option" id="payment_option" onchange="getDate(this.value);" required>
                                <option value="Manual">Manual (One Time)</option>
                                <option value="Automatic">Automatic (Every Year)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="gift_voucher.php" type="button" name="submit" class="btn btn-warning"
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