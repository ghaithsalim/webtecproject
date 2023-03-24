<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$user_id = $_SESSION['id'];


if (isset($_POST['delete'])){
    $id = $_POST['delete'];

    $sql = "DELETE FROM `birthdays` WHERE `birthday_id`='$id'";
    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
//sql query for fetching class information

$sql = mysqli_query($conn, "SELECT t1.birthday_id, t2.full_name, t2.date_of_birth, t1.amount, t1.sending_type, date(t1.created_at) 
FROM `birthdays` t1 INNER JOIN family_members t2 ON t1.member_id=t2.member_id WHERE t1.user_id='$user_id'");

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

    <h5><strong> ::: Gift Voucher ::: </strong></h5>
    <hr/>
    <div class="row margin_a">
        <form method="post" action="" enctype="multipart/form-data">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">

                <a href="add_gift_voucher.php" class="btn btn-success left_align"> Add New Birthday Gift Voucher <i
                            class="fa fa-plus-circle"></i>
                </a>
                <table class="table table-responsive table-bordered" id="table_list">
                    <thead>
                    <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                        <th>SL.</th>
                        <th>Name</th>
                        <th>Gift Amount</th>
                        <th>Date of Birth</th>
                        <th>Sending Type</th>
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
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['amount']; ?></td>
                            <td><?php echo $rows['date_of_birth']; ?></td>
                            <td><?php echo $rows['sending_type']; ?></td>
                            <td>
                                <a href="edit_gift_voucher.php?id=<?php echo $rows['birthday_id']; ?>"
                                   class="btn btn-success btn-sm"><i
                                            class="fa fa-edit"></i> Edit</a> |
                                <button type="submit" class="btn btn-danger btn-sm"
                                        value="<?php echo $rows['birthday_id']; ?>"
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