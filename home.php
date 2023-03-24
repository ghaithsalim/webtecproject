<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';

?>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <h3 style="font-size: 20px; font-family: Roboto, Arial, sans-serif;"><strong> Welcome To Personal Banking Management System </strong></h3>
    <img src="image/task_management.png">
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