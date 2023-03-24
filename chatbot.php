<?php
include_once 'common/session.php';
include_once 'common/header.php';
//database connection
include_once 'db/config.php';
$id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    //remarks date payment_option amount bill_type
    $user_name = $_POST['user_name'];
    $amount = $_POST['amount'];
    $date = date("Y-m-d");
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO `transactions`(`user_id`, `transaction_date`, `transaction_type`, `amount`, `description`) VALUES ('$user_name', '$date',
 'Credit', '$amount', '$remarks')";

    $isSuccess = mysqli_query($conn, $sql);
    if ($isSuccess) {
        $l_id = mysqli_insert_id($conn);
        mysqli_query($conn, "UPDATE `td_account` SET balance = balance + $amount WHERE user_id='$id'");
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['error'] = 2;
    }
}
?>
<style>
    .user_profile{border: 1px solid black; border-radius: 15px; padding: 3px;}
</style>
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

        <div class="alert alert-danger" id="e_message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> Something Went Wrong. Please try again!!!.
        </div>
        <?php unset($_SESSION['error']);
    } ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #f8f8f8; border-radius: 5px; border: 1px solid black;
         width: 60%; margin-left: 20%; height: calc(100vh - 80px); overflow-y: auto;">
            <h4><strong> ::: Chatbot ::: </strong></h4>
            <hr/>
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height:450px; overflow-y: scroll; ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div_1">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;" id="message_div">
                        <p class="text-left" id="chatbot"><i class="fa fa-smile-o" style="font-size: 20px;"></i> Hi!!!, how can I help you ?</p>
                    </div>
                </div>
            </div>
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 20px;position: absolute; bottom: 0px; height: 50px; ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-md-10 col-sm-10 col-xs-6" style="margin-top: 10px;">
                        <input type="text" name="message" class="form-control" id="message" placeholder="How Can I help you... " />
                    </div>

                    <div class="col-md-2 col-sm-2 col-xs-2" style="margin-top: 10px;">
                        <button type="button" class="btn btn-success" name="send" onclick="getResponse()">Send <i class="fa fa-send"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function getResponse() {
        var text = $("#message").val();
        console.log(text);

        $.ajax({
            url: "getChatbot.php",
            type: "post",
            data: {
                text: text
            },
            success: function (json_data) {
                var data = $.parseJSON(json_data);
                console.log(data['balance']);
                var u_mes = '<p class="text-right" id="user_sec">'+ text +' <i class="fa fa-user user_profile" style=""></i> </p>';
                var r_response = '<p class="text-left" id="chatbot"><i class="fa fa-smile-o" style="font-size: 20px;"></i> '+ data['balance'] +'</p>';

                $("#message_div").append(u_mes);
                $("#message_div").append(r_response);

                $("#message").val("");

            }

        });
    }
</script>

</body>
</html>