<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$user_id= $_SESSION['id'];
$card_stauts= $_SESSION['card_stauts'];
if (isset($_POST['u_status'])) {
    $id = $_POST['u_status'];
    $isSuccess = mysqli_query($conn, "UPDATE `td_user` SET status = IF(status ='Y', 'N', 'Y') WHERE id='$id'");

    if ($isSuccess) {
        $_SESSION['delete'] = 1;
    } else {
        $_SESSION['delete'] = 2;
    }
}
//sql query for fetching class information
    $sql = mysqli_query($conn, "SELECT `member_id`, `user_id`, `username`, `full_name`, `date_of_birth`, `mobile_number`,
 `privilege_status`, `created_at`, `status` FROM `family_members` WHERE user_id='$user_id'");

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['delete']) == 1) { ?>
        <div class="alert alert-success" id="s_message">
            <strong>Success!</strong> User Status Changed Successfully!!!.
        </div>
        <?php
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['delete']) == 2) { ?>

        <div class="alert alert-danger" id="e_message">
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php  unset($_SESSION['delete']);
    } ?>

    <h5><strong> :::Family Members Information::: </strong></h5>
    <hr />
    <div class="row margin_a">
        <form method="post" action="" enctype="multipart/form-data">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                <?php if ($card_stauts == 'Y') { ?>
                    <a href="add_family_member.php" class="btn btn-success left_align">Add New <i class="fa fa-plus-circle"></i>
                    </a>
                <?php } ?>
                <table class="table table-responsive table-bordered" id="table_list">
                    <thead>
                    <tr style="background-color: #2b4570; color: white; font-size: 12px;">
                        <th>SL.</th>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Date of birth</th>
                        <th>Contact No</th>
                        <th>Previlege</th>
                        <th>status</th>
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
                            <td><?php echo $rows['username']; ?></td>
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['date_of_birth']; ?></td>
                            <td><?php echo $rows['mobile_number']; ?></td>
                            <td><?php echo $rows['privilege_status']; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td>
                                <a href="edit_family_member.php?id=<?php echo $rows['member_id']; ?>" class="btn btn-success btn-sm"><i
                                            class="fa fa-edit"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm" value="<?php echo $rows['member_id']; ?>"
                                        name="u_status" onclick="return confirm('Are you sure?')"><i
                                            class="fa fa-trash"></i> <?php if ($rows['status'] == "Y") { ?>Inactive <?php } else { ?> Active <?php } ?></button>
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