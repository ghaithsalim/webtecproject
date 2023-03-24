<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

$user_id= $_SESSION['id'];

if (isset($_POST['delete'])){
    $id = $_POST['delete'];

    $sql = "update `td_user` set status='N' WHERE `id`='$id'";
    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}

//sql query for fetching class information
    $sql = mysqli_query($conn, "SELECT `id`, `user_name`, `full_name`, `dob`, `mobile_no`,
 IF(`user_type`='1', 'Main  User',  'Sub User') as user_type, `status` FROM `td_user` WHERE user_type!='3';");

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success" id="s_message">
            <strong>Success!</strong> User Status Changed Successfully!!!.
        </div>
        <?php
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) { ?>

        <div class="alert alert-danger" id="e_message">
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php  unset($_SESSION['error']);
    } ?>

    <h5><strong> :::Family Members Information::: </strong></h5>
    <hr />
    <div class="row margin_a">
        <form method="post" action="" enctype="multipart/form-data">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
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
                            <td><?php echo $rows['user_name']; ?></td>
                            <td><?php echo $rows['full_name']; ?></td>
                            <td><?php echo $rows['dob']; ?></td>
                            <td><?php echo $rows['mobile_no']; ?></td>
                            <td><?php echo $rows['user_type']; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $rows['id']; ?>" class="btn btn-success btn-sm"><i
                                            class="fa fa-edit"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm" value="<?php echo $rows['id']; ?>"
                                        name="delete" onclick="return confirm('Are you sure?')"><i
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