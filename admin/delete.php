<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['user_master_id'])){
    $id_1=$_SESSION['user_master_id'];
   // while inserting any department, adding the values in created_by_id,and created_time
        date_default_timezone_set("asia/kolkata");
        $timestamp = date('Y-m-d H:i:s');
include "../master/db_conn.php";
if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $query = "UPDATE user_master SET is_deleted = 1,updated_date='$timestamp',updated_by_id='$id_1'  WHERE user_master_id='$id'  ";
    //$query = "DELETE FROM dept_master WHERE dept_id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        //echo '<script> alert("Data Deleted"); </script>';
        header("Location:allEmployee.php");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}else{
    echo 1;
}
}


?>