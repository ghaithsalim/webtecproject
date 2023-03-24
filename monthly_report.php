<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$role = $_SESSION['role_id'];
$user_id = $_SESSION['id'];

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['delete']) == 1) { ?>
        <div class="alert alert-success" id="s_message">
            <strong>Success!</strong> Student Information Deleted Successfully!!!.
        </div>
        <?php
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['delete']) == 2) { ?>

        <div class="alert alert-danger" id="e_message">
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php unset($_SESSION['delete']);
    } ?>

    <h5 class="left_align"><strong><i class="fa fa-empire"></i> Report &nbsp;</strong></h5>
    <hr/>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="border: 1px solid #d9d9d9; padding-top: 15px; margin-bottom: 10px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-dark left_align margin_left" id="btn_daily"><i
                                    class="fa fa-tasks"></i> Monthly Details Report
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
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <select class="form-control" name="user_name" id="user_name">
                                    <?php if ($role == '1') { ?>
                                        <option value=""> --- Select User ---</option>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT id, user_name FROM `td_user` WHERE status='Y'");
                                        while ($rows = mysqli_fetch_array($sql)) {
                                            ?>
                                            <option value="<?php echo $rows['id']; ?>"><?php echo $rows['user_name']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT id, user_name FROM `td_user` WHERE status='Y' AND id='$user_id'");
                                        while ($rows = mysqli_fetch_array($sql)) {
                                            ?>
                                            <option value="<?php echo $rows['id']; ?>"><?php echo $rows['user_name']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
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
                        <th>User Name</th>
                        <th>Task Details</th>
                        <th>Status</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $temp_user = "";
                    $temp_date = "";
                    $from_date = $_POST['from_date'];
                    $to_date = $_POST['to_date'];
                    $user = $_POST['user_name'];
                    if ($role == '1' and $user == "") {

                        $sql = mysqli_query($conn, "SELECT * from ((SELECT t1.date, t1.user_id, t2.user_name, t1.task_title, t3.type as status,
 (t1.created_at) as start_date,
(t1.updated_at) as end_date FROM `tt_task` t1 INNER JOIN td_user t2 ON t1.user_id=t2.id INNER JOIN td_work_type t3 ON t1.status=t3.id 
WHERE DATE(t1.created_at) BETWEEN  '$from_date' and '$to_date' ORDER  BY t1.user_id, t1.date)
UNION
(SELECT t1.date, t1.user_id, t2.user_name, '' as task_title, 'Leave' as status, '' as start_date,
 '' as end_date FROM `tt_holiday` t1 INNER JOIN td_user t2 ON t1.user_id=t2.id WHERE date BETWEEN '$from_date' and '$to_date'))
  as dd ORDER BY date, user_id");
                    } else {
                        $sql = mysqli_query($conn, "SELECT * from ((SELECT t1.date, t1.user_id, t2.user_name, t1.task_title, t3.type as status,
 (t1.created_at) as start_date,
(t1.updated_at) as end_date FROM `tt_task` t1 INNER JOIN td_user t2 ON t1.user_id=t2.id INNER JOIN td_work_type t3 ON t1.status=t3.id 
WHERE DATE(t1.created_at) BETWEEN  '$from_date' and '$to_date' AND t1.user_id='$user' ORDER  BY t1.user_id, t1.date)
UNION
(SELECT t1.date, t1.user_id, t2.user_name, '' as task_title, 'Leave' as status, '' as start_date,
 '' as end_date FROM `tt_holiday` t1 INNER JOIN td_user t2 ON t1.user_id=t2.id WHERE date BETWEEN '$from_date' and '$to_date' AND t1.user_id='$user'))
  as dd ORDER BY date, user_id");
                    }

                    while ($rows = mysqli_fetch_array($sql)) {
                        if ($rows['status'] !='Leave'){
                            $diff = abs(strtotime($rows['start_date']) - strtotime($rows['end_date']));
                            $time_query = "SELECT SEC_TO_TIME(" . $diff . ") as time";
                            $time = mysqli_fetch_array(mysqli_query($conn, $time_query));
                            $time_r = $time['time'];
                        }else {
                            $time_r = 0;
                        }

                        ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['user_name']; ?></td>
                            <td><?php echo $rows['task_title']; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td><?php echo $rows['start_date']; ?></td>
                            <td><?php echo $rows['end_date']; ?></td>
                            <td><?php echo $time_r; ?></td>

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