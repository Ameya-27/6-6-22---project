<?php
//making a connection to our database
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user_master_id'])) {
    
    include "../master/db_conn.php";
    $id_1 = $_SESSION['user_master_id'];
    // while inserting any department, adding the values in created_by_id,and created_time
    date_default_timezone_set("asia/kolkata");
    $timestamp = date('Y-m-d H:i:s');
    if (isset($_POST['update'])) {
        $id = $_POST['update_id'];
        $username = $_POST['email'];
        $role = $_POST['role'];
        $name = $_POST['name'];

        $sql = "UPDATE `user_master` SET `email` = '$username', `name` = '$name', `role` = '$role'WHERE `user_master_id` = '$id'";
        $result = $conn->query($sql);

        if ($result) {
            header("Location: allEmployee.php");
        } else {
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        $sql_1="UPDATE user_master SET updated_date='$timestamp',updated_by_id='$id_1' WHERE user_master_id = '$id'";
        $res=$conn->query($sql_1);
    }
}
