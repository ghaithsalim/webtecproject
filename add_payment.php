<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    //remarks date payment_option amount bill_type
    $bill_type = $_POST['bill_type'];
    $amount = $_POST['amount'];
    $payment_option = $_POST['payment_option'];
    if (isset($_POST['payment_date'])){
        $date = $_POST['payment_date'];
    }else{
        $date = date("Y-m-d");
    }

    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO `bills`(`user_id`, `bill_type`, `bill_amount`, `bill_due_date`, `automatic_payment`, `remarks`) 
    VALUES ('$id','$bill_type','$amount','$date','$payment_option','$remarks')";

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $l_id = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO `transactions`(`user_id`, `transaction_date`, `transaction_type`,
 `amount`, `description`, `bill_id`) VALUES ('$id','$date', 'debit', '$amount', '$remarks', '$l_id')");


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
            <strong>Success!</strong> Transaction Complete Successfully!!!.
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
            <h6><strong> ::: Add New Payment ::: </strong></h6>
            <hr/>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Bill Type</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="bill_type" id="bill_type" required>
                                <option value="">Select Bill Type</option>
                                <?php $sql = mysqli_query($conn, "SELECT `id`, `name` FROM `bill_type` WHERE 1");
                                while ($row = mysqli_fetch_array($sql)) { ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
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
                                <option value="N">Manual (One Time)</option>
                                <option value="Y">Automatic (Every Month)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Payment Due Date</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="payment_date" id="payment_date" value="<?php echo date("Y-m-d");?>"
                                   class="form-control" disabled />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Remarks</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea class="form-control" name="remarks" id="remarks"
                                      placeholder="Remarks ... "></textarea>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="bill_pay.php" type="button" name="submit" class="btn btn-warning"
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