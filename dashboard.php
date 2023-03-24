<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$user_id = $_SESSION['id'];
$type = $_SESSION['user_type'];
if ($type == '1') {
    $account_summary = mysqli_fetch_array(mysqli_query($conn, "SELECT `account_no`, `balance` FROM `td_account` WHERE `user_id`='$user_id'"));
    $family_no = mysqli_fetch_array(mysqli_query($conn, "SELECT count(member_id) as total_members FROM `family_members` WHERE user_id='$user_id'"));
    $up_bir = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(member_id) as total FROM `family_members` WHERE `user_id`='$user_id' AND status='Y' and date_of_birth BETWEEN 'curdate()' and curdate() + INTERVAL 3 day"));
    $up_payment = mysqli_fetch_array(mysqli_query($conn, "SELECT IFNULL (SUM(bill_amount),0) as total_amount FROM `bills` WHERE `user_id`='$user_id' and  payment_status='N' and  bill_due_date BETWEEN curdate() and curdate() + INTERVAL 7 day"));
} elseif ($type == '3') {
    $t_user = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) as t_user FROM `td_user` WHERE user_type='1' AND status='Y'"));
    $g_user = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) as g_user FROM `td_user` WHERE user_type='2' AND status='Y'"));
    $t_card = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(card_id) as t_card FROM `credit_cards` WHERE status='Y' "));
    $t_amnt = mysqli_fetch_array(mysqli_query($conn, "SELECT IFNULL(SUM(amount),0) as t_amnt FROM `transactions` WHERE date(transaction_date) = curdate()"));

}


?>
<style>
    .panel-header {
        background-color: #428bca;
        color: #fff;
        padding: 10px;
    }

    .panel-header-green {
        background-color: #00c735;
        color: #fff;
        padding: 10px;
    }

    .panel-header-yellow {
        background-color: #f28f2c;
        color: #fff;
        padding: 10px;
    }

    .panel-header-red {
        background-color: #c98f97;
        color: #fff;
        padding: 10px;
    }

    .panel-header i {
        margin-right: 5px;
    }
</style>
<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">

    <?php if ($type == '3') { ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-green">
                        <i class="fa fa-group"></i> Total User
                    </div>
                    <div class="panel-body"><strong>Total User <br/><?php echo $t_user['t_user']; ?> </strong></div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-yellow">
                        <i class="fa fa-group"></i> Total Guest User
                    </div>
                    <div class="panel-body"><strong>Guest User <br/> <?php echo $g_user['g_user']; ?>  </strong></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <i class="fa fa-cc-mastercard"></i> Total Credit Card
                    </div>
                    <div class="panel-body"><strong>Credit Credit User <br/> <?php echo $t_card['t_card'] ?> </strong>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-red">
                        <i class="glyphicon glyphicon-transfer"></i> Total Transaction
                    </div>
                    <div class="panel-body"><strong>Total Transaction - (
                            <small><?php echo date("Y-m-d"); ?></small>
                            ) <br/><?php echo $t_amnt['t_amnt']; ?> </strong></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <i class="glyphicon glyphicon-transfer"></i> Recent Transaction ( Last 30 day)
                    </div>
                    <div class="panel-body" style=" height: 350px; overflow-y: scroll;">
                        <table class="table table-responsive table-striped" id="table_list">
                            <thead>
                            <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Debit Amount</th>
                                <th>Credit Amount</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $sql = mysqli_query($conn, "SELECT tempTable.transaction_date, t2.user_name, SUM(tempTable.debit) as debit,
sum(tempTable.credit) as credit from (
SELECT transaction_date, user_id, SUM(amount) as debit, '0' as credit 
FROM `transactions` WHERE transaction_type='Debit' and transaction_date BETWEEN curdate() - INTERVAL 30 day AND curdate() 
GROUP BY transaction_date, user_id 
UNION 
SELECT transaction_date, user_id, '0' as debit, SUM(amount) as credit FROM transactions 
WHERE transaction_type='Credit' and transaction_date BETWEEN curdate() - INTERVAL 30 day AND curdate() GROUP by transaction_date, user_id
 ) as tempTable INNER JOIN td_user t2 ON tempTable.user_id = t2.id GROUP by tempTable.transaction_date, tempTable.user_id 
 ORDER BY tempTable.transaction_date, tempTable.user_id");
                            while ($rows = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i++; ?></td>
                                    <td class="text-left"><?php echo $rows['transaction_date']; ?></td>
                                    <td class="text-left"><?php echo $rows['user_name']; ?></td>
                                    <td class="text-left"><?php echo $rows['debit']; ?></td>
                                    <td class="text-left"><?php echo $rows['credit']; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-header-red">
                        <i class="glyphicon glyphicon-calendar"></i> Transaction Summary (Last 30 days)
                    </div>
                    <div class="panel-body" style=" height: 350px; overflow-y: scroll;">
                        <table class="table table-responsive table-striped" id="table_list">
                            <thead>
                            <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Debit Amount</th>
                                <th>Credit Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $sql = mysqli_query($conn, "SELECT transaction_date, SUM(debit) as debit, sum(credit) as  credit from (SELECT transaction_date, SUM(amount) as debit, '0' as credit FROM `transactions` WHERE transaction_type='Debit' and transaction_date BETWEEN curdate() - INTERVAL 30 day AND curdate() GROUP BY transaction_date
UNION
SELECT transaction_date, '0' as debit, SUM(amount) as credit FROM transactions WHERE transaction_type='Credit' and transaction_date BETWEEN curdate() - INTERVAL 30 day AND curdate() GROUP by transaction_date ) as tempTable GROUP by transaction_date");
                            while ($rows = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i++; ?></td>
                                    <td class="text-left"><?php echo $rows['transaction_date']; ?></td>
                                    <td class="text-left"><?php echo $rows['debit']; ?></td>
                                    <td class="text-left"><?php echo $rows['credit']; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-green">
                        <i class="glyphicon glyphicon-briefcase"></i> Account Summary
                    </div>
                    <div class="panel-body"><strong>Available Balance
                            <br/> <?php echo "A/C No. - " . $account_summary['account_no'] . " - " . $account_summary['balance'] ?>
                            AED</strong></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <i class="glyphicon glyphicon-user"></i> Family Members
                    </div>
                    <div class="panel-body"><strong>No. of family Members
                            <br/> <?php echo $family_no['total_members'] ?> </strong></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-yellow">
                        <i class="glyphicon glyphicon-credit-card"></i> Upcoming Payment
                    </div>
                    <div class="panel-body"><strong>Upcoming Payment <br/> <?php echo $up_payment['total_amount']; ?>
                            Aed(Within 7 days) </strong></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-header-red">
                        <i class="glyphicon glyphicon-gift"></i> Upcoming birthday
                    </div>

                    <div class="panel-body"><strong><?php if ($up_bir['total'] != '0') { ?>Upcoming Birthday
                                <br/> <?php echo $up_bir['total']; ?> members birthday(Within 3 days)  <?php } else {
                                echo "0";
                            } ?> </strong></div>

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-header">
                        <i class="glyphicon glyphicon-transfer"></i> Recent Transaction( Last 30 day)
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped" id="table_list">
                            <thead>
                            <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Bill Type</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $sql = mysqli_query($conn, "SELECT t1.`transaction_date`, `transaction_type`, IF(t1.`transaction_type`='Debit',
 t1.`amount`*-1, t1.amount) as amount, t1.`description`, t2.name FROM `transactions` t1 LEFT JOIN bill_type t2 ON t1.bill_id = t2.id 
 WHERE t1.user_id='$user_id' ORDER by transaction_id desc LIMIT 10;");
                            while ($rows = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i++; ?></td>
                                    <td class="text-left"><?php echo $rows['transaction_date']; ?></td>
                                    <td class="text-left"><?php echo $rows['amount']; ?></td>
                                    <td class="text-left"><?php echo $rows['description']; ?></td>
                                    <td class="text-left"><?php echo $rows['description']; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-header-red">
                        <i class="glyphicon glyphicon-calendar"></i> Upcomping Debits & Payments
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped" id="table_list">
                            <thead>
                            <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Bill Payment Type</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $sql = mysqli_query($conn, "SELECT `bill_due_date`, `bill_amount`, `remarks`, IF(`automatic_payment`='Y', 'Automatic', 'Manual') as p_type 
FROM `bills` WHERE user_id='$user_id' and bill_due_date BETWEEN curdate() and curdate() + INTERVAL 30 day ORDER by bill_due_date asc LIMIT 10");
                            while ($rows = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td class="text-left"><?php echo $i++; ?></td>
                                    <td class="text-left"><?php echo $rows['bill_due_date']; ?></td>
                                    <td class="text-left"><?php echo $rows['bill_amount']; ?></td>
                                    <td class="text-left"><?php echo $rows['remarks']; ?></td>
                                    <td class="text-left"><?php echo $rows['p_type']; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


</div>


</body>

<script>
    $(document).ready(function () {
        $('#class_table').DataTable({
            "lengthChange": false,
            "searching": false
        });

    });
</script>
</html>