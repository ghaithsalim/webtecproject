<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$user_id = $_SESSION['id'];
$type = $_SESSION['user_type'];

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">

    <h5 class="left_align"><strong><i class="fa fa-empire"></i> Report &nbsp;</strong></h5>
    <hr/>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="border: 1px solid #d9d9d9; padding-top: 15px; margin-bottom: 10px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-dark left_align margin_left" id="btn_daily"><i
                                    class="fa fa-tasks"></i> Transaction Report
                        </button>
                    </div>
                    <hr/>
                    <div class="row" id="monthly">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px; padding-bottom: 15px;">
                            <span class="left_align" style="margin-left: 15px;"><i class="fa fa-filter"></i> Search &nbsp;</span>
                            <hr/>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="from_date" id="from_date"
                                       style="padding: 3px;"
                                       value="<?php echo date("Y-m-d"); ?>"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <input class="col-md-12 col-sm-12 col-xs-12" type="date" name="to_date" id="to_date"
                                       style="padding: 3px;"
                                       value="<?php echo date("Y-m-d"); ?>"
                                       class="form-control"/>
                            </div>
                            <?php if ($type =='1'){?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <select class="form-control" name="f_id" id="f_id">

                                    <option value=""> --- Select Family Memeber ---</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT `id`, `user_name` FROM `td_user` WHERE member_id in (SELECT `member_id` FROM `family_members` WHERE `user_id`='$user_id') AND status='Y'");
                                    while ($rows = mysqli_fetch_array($sql)) {
                                        ?>
                                        <option value="<?php echo $rows['id']; ?>"><?php echo $rows['user_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php }elseif($type == '3'){ ?>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <select class="form-control" name="f_id" id="f_id">

                                        <option value=""> --- Select User ---</option>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT `id`, `user_name` FROM `td_user` WHERE `user_type`!='3' AND status='Y'");
                                        while ($rows = mysqli_fetch_array($sql)) {
                                            ?>
                                            <option value="<?php echo $rows['id']; ?>"><?php echo $rows['user_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php }else{} ?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <button type="submit" name="submit" class="btn btn-success left_align"> Search <i
                                            class="fa fa-search"></i></button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <?php if (isset($_POST['submit'])) {
        ?>

        <div class="row" id="r_daily_report">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-responsive table-bordered" id="table_report">
                    <thead>
                    <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                        <th>##</th>
                        <th>Date</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Amount</th>
                        <th>Bill Type</th>
                        <th>Desciption</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $temp_user = "";
                    $temp_date = "";
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];

                    if ($type =='1'){
                        if ($_POST['f_id']!=''){
                            $f_id = $_POST['f_id'];
                        }else{
                            $f_id = $user_id;
                        }
                        $sql = mysqli_query($conn, "SELECT t1.transaction_date, t2.full_name, t2.user_name,
 IF(transaction_type='Debit', amount * -1, amount) as amount, t1.description, t4.name FROM `transactions` t1 inner JOIN td_user t2 ON t1.user_id =t2.id 
 LEFT JOIN bill_type t4 ON t1.bill_id=t4.id 
 WHERE t1.user_id='$f_id' and t1.transaction_date BETWEEN '$from_date' AND '$to_date'");

                    }else if ($type == '3'){
                        if ($_POST['f_id']!=''){
                            $f_id = $_POST['f_id'];

                            $sql = mysqli_query($conn, "SELECT t1.transaction_date, t2.full_name, t2.user_name,
 IF(transaction_type='Debit', amount * -1, amount) as amount, t1.description, t4.name FROM `transactions` t1 inner JOIN td_user t2 ON t1.user_id =t2.id 
 LEFT JOIN bill_type t4 ON t1.bill_id=t4.id 
 WHERE t1.user_id='$f_id' and t1.transaction_date BETWEEN '$from_date' AND '$to_date'");

                        }else{
                            $sql = mysqli_query($conn, "SELECT t1.transaction_date, t2.full_name, t2.user_name,
 IF(transaction_type='Debit', amount * -1, amount) as amount, t1.description, t4.name FROM `transactions` t1 inner JOIN td_user t2 ON t1.user_id =t2.id 
 LEFT JOIN bill_type t4 ON t1.bill_id=t4.id 
 WHERE t1.transaction_date BETWEEN '$from_date' AND '$to_date'");
                        }

                    }else{
                        $sql = mysqli_query($conn, "SELECT t1.transaction_date, t2.full_name, t2.user_name,
 IF(transaction_type='Debit', amount * -1, amount) as amount, t1.description, t4.name FROM `transactions` t1 inner JOIN td_user t2 ON t1.user_id =t2.id 
 LEFT JOIN bill_type t4 ON t1.bill_id=t4.id 
 WHERE t1.user_id='$user_id' and t1.transaction_date BETWEEN '$from_date' AND '$to_date'");
                    }

                    while ($rows = mysqli_fetch_array($sql)) {

                        ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $rows['transaction_date']; ?></td>
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['user_name']; ?></td>
                            <td><?php echo $rows['amount']; ?></td>
                            <td><?php echo $rows['description']; ?></td>
                            <td><?php echo $rows['name']; ?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    <?php } ?>
</div>


</body>

<script>
    $(document).ready(function () {

        //$('#r_daily_report').hide();
        $('#table_report').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
</html>