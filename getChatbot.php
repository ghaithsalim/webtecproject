<?php
include_once 'common/session.php';
include_once 'db/config.php';
$text = strtolower($_POST['text']);
//$text = strtolower("show me my past transactions");
if ($text == "tell me available balance"){
    $row= mysqli_fetch_array(mysqli_query($conn, "SELECT `action` FROM `chatbot` WHERE `text` LIKE '%$text%'"));
    $sql = $row['action']."'".$_SESSION['id']."'";

    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    $data = array();
    $data['balance'] = "Your available balance is - ". $result['balance'];

    echo json_encode($data);

}else if($text == "tell me today expense?"){
    $row= mysqli_fetch_array(mysqli_query($conn, "SELECT `action` FROM `chatbot` WHERE `text` LIKE '%$text%'"));
    $sql = $row['action']."'".$_SESSION['id']."'";

    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    $data = array();
    $data['balance'] = "Your today's expense is - ". $result['t_amnt'];

    echo json_encode($data);
}else if ($text == "show me my past transactions"){
    $row= mysqli_fetch_array(mysqli_query($conn, "SELECT `action` FROM `chatbot` WHERE `text` LIKE '%$text%'"));
    //$sql = $row['action']."'".$_SESSION['id']."'";

    //$result = mysqli_fetch_array(mysqli_query($conn, $sql));

    $data = array();
    $data['balance'] = "Your can check your transaction from these link - <a type='_blank' href='". $row['action']."'>".$row['action']."</a>";

    echo json_encode($data);
}else if ($text == "i’d like to add a family member to my account"){
    $row= mysqli_fetch_array(mysqli_query($conn, "SELECT `action` FROM `chatbot` WHERE `text` LIKE '%$text%'"));
    //$sql = $row['action']."'".$_SESSION['id']."'";

    //$result = mysqli_fetch_array(mysqli_query($conn, $sql));

    $data = array();
    $data['balance'] = "Your can add family members from these link - <a type='_blank' href='". $row['action']."'>".$row['action']."</a>";

    echo json_encode($data);
}else{
    $data = array();
    $data['balance'] = "No data found. Please try again!!!";

    echo json_encode($data);
}


?>