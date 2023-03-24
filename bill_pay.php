<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';


$user_id = $_SESSION['id'];
if (isset($_POST['delete'])){
    $id = $_POST['delete'];

    $sql = "DELETE FROM `bills` WHERE `bill_id`='$id'";
    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
//sql query for fetching class information


$sql = mysqli_query($conn, "SELECT t1.`bill_id`, t2.`name` as bill_type, t1.`bill_amount`, t1.`bill_due_date`,
 t1.`automatic_payment`, Date(t1.`created_at`) as c_date FROM `bills` t1 INNER  JOIN  bill_type t2 on t1.bill_type = t2.id WHERE `user_id`='$user_id'");

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible" id="s_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong>Transaction Completed Successfully!!!.
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

    <h5><strong> ::: Payment History::: </strong></h5>
    <hr/>
    <div class="row margin_a">
        <form method="post" action="" enctype="multipart/form-data">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">

                <a href="add_payment.php" class="btn btn-success left_align"> Manage Payment <i
                            class="fa fa-plus-circle"></i>
                </a>
                <table class="table table-responsive table-bordered" id="table_list">
                    <thead>
                    <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                        <th>SL.</th>
                        <th>Date</th>
                        <th>Bill Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Automatic Payment</th>

                        <th>Actions</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    while ($rows = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $rows['c_date']; ?></td>
                            <td><?php echo $rows['bill_type']; ?></td>
                            <td><?php echo $rows['bill_amount']; ?></td>
                            <td><?php echo $rows['bill_due_date']; ?></td>
                            <td><?php echo $rows['automatic_payment']; ?></td>
                            <td>
                            <?php if ($rows['automatic_payment'] == 'Y') { ?>

                                    <a href="edit_payment.php?id=<?php echo $rows['bill_id']; ?>"
                                       class="btn btn-success btn-sm"><i
                                                class="fa fa-edit"></i> Edit</a> |
                                <button type="submit" class="btn btn-danger btn-sm"
                                        value="<?php echo $rows['bill_id']; ?>"
                                        name="delete"
                                        onclick="return confirm('Do you want to Delete?')"><i
                                            class="fa fa-trash"></i> Delete
                                </button>

                            <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>

    </div>
</div>


</body>

<script>
    $(document).ready(function () {
        $('#table_list').DataTable({
            "lengthChange": false,
            "searching": false
        });

    });
</script>
</html>