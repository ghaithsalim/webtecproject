<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$user_id = $_SESSION['id'];


if (isset($_POST['delete'])){
    $id = $_POST['delete'];

    $sql = "DELETE FROM `pending_debts` WHERE `debit_id`='$id'";
    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
//sql query for fetching class information

$sql = mysqli_query($conn, "SELECT `debit_id`, `debit_title`, `debit_amount`, `installment_per_month`, `final_date`, `remarks`,
 `created_at` FROM `pending_debts` WHERE `user_id`='$user_id'");

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['delete']) == 1) { ?>
        <div class="alert alert-success alert-dismissible" id="s_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> User Status Changed Successfully!!!.
        </div>
        <?php
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['delete']) == 2) { ?>

        <div class="alert alert-danger alert-dismissible" id="e_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php unset($_SESSION['delete']);
    } ?>

    <h5><strong> ::: Debit Profile ::: </strong></h5>
    <hr/>
    <div class="row margin_a">
        <form method="post" action="" enctype="multipart/form-data">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">

                <a href="add_debits.php" class="btn btn-success left_align"> Manage Pending Debits <i
                            class="fa fa-plus-circle"></i>
                </a>
                <table class="table table-responsive table-bordered" id="table_list">
                    <thead>
                    <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                        <th>SL.</th>
                        <th>Debit Title</th>
                        <th>Debit Amount</th>
                        <th>Installment/month</th>
                        <th>Final Payment Date</th>
                        <th>Remarks</th>
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
                            <td><?php echo $rows['debit_title']; ?></td>
                            <td><?php echo $rows['debit_amount']; ?></td>
                            <td><?php echo $rows['installment_per_month']; ?></td>
                            <td><?php echo $rows['final_date']; ?></td>
                            <td><?php echo $rows['remarks']; ?></td>
                            <td>
                                <a href="edit_pending_debits.php?id=<?php echo $rows['debit_id']; ?>"
                                   class="btn btn-success btn-sm"><i
                                            class="fa fa-edit"></i> Edit</a> |
                                <button type="submit" class="btn btn-danger btn-sm"
                                        value="<?php echo $rows['debit_id']; ?>"
                                        name="delete"
                                        onclick="return confirm('Do you want to Delete?')"><i
                                            class="fa fa-trash"></i> Delete
                                </button>
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