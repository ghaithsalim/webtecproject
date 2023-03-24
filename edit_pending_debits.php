<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_GET['id'];
$user_id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    //remarks date payment_option amount bill_type
    $edit_id = $_POST['edit_id'];
    $debit_title = $_POST['debit_title'];
    $amount = $_POST['amount'];
    $installment_month = $_POST['installment_month'];

    $date = $_POST['payment_date'];

    $remarks = $_POST['remarks'];


    $sql = "update `pending_debts` set `debit_title`='$debit_title', `debit_amount`='$amount', `installment_per_month`='$installment_month',
 `final_date`='$date', `remarks`='$remarks' where `debit_id` = '$edit_id'";

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}


$row = mysqli_fetch_array(mysqli_query($conn, "SELECT `debit_id`, `debit_title`, `debit_amount`, `installment_per_month`, `final_date`, `remarks`
 FROM `pending_debts` WHERE `debit_id`='$id' "));

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

        <div class="alert alert-danger alert-dismissible" id="e_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php unset($_SESSION['error']);
    } ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #f8f8f8; border-radius: 5px; border: 1px solid black; ">
            <h4><strong> ::: Edit Payment ::: </strong></h4>
            <hr/>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Debit Title</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="text" name="debit_title" id="debit_title"
                                   value="<?php echo $row['debit_title']; ?>" class="form-control" required />

                            <input class="col-md-12 col-sm-12 col-xs-12" type="hidden" name="edit_id" id="edit_id"
                                   value="<?php echo $row['debit_id']; ?>" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Amount</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="number" name="amount" id="amount"
                                   value="<?php echo $row['debit_amount']; ?>" class="form-control" step="0.001" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Installment/Month</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="number" name="installment_month"
                                   id="installment_month"
                                   value="<?php echo $row['installment_per_month']; ?>" class="form-control" step="0.001" required />
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-left">Payment Final Date</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="payment_date"
                                   id="payment_date" value="<?php echo $row['final_date']; ?>"
                                   class="form-control" required />
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
                                      placeholder="Remarks ... "><?php echo $row['remarks']; ?></textarea>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="debit_list.php" type="button" name="submit" class="btn btn-warning"
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