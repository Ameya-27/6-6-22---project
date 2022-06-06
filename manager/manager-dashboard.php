<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user_master_id'])) {
    $page_title = "Manger";
    $Dashboard = "MANAGER";
    $Dashboard_link = "manager-dashboard.php";
    //$Department = "DEPARTMENT";
    $My_Evaluation = "My Evaluation";
    $MyEvaluation_link = "../evaluation_form/view_manager_task.php";
    //$Department_link = "../department/create_dept.php";
    //$All_Employee = "ALL EMPLOYEES";
    $My_Team = "MY TEAM";
    //$AllEmployee_link = "allEmployee.php";
    $MyTeam_link = "manager_myteam.php";
    $user_icon = "../assets/images/others/user-default.png";
	$Session_name = $_SESSION['name'];
	$name = "$Session_name";
	$logout = "../logout.php";
    include "../master/db_conn.php";
    include "../master/pre-header.php";
    include "../master/header.php";
    include "../master/navbar_manager.php";
    include "../master/breadcrumbs.php";
?>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 30vh">
        <div class="card" style="width: 18rem;">
            <img src="../assets/images/others/user-default.png" class="card-img-top" alt="admin image">
            <div class="card-body text-center">
                <h5 class="card-title">
                    <?= $_SESSION['name'] ?>
                </h5>
            </div>
        </div>
    </div>

    <?php
    // content end
    include "../master/footer.php";
    include "../master/after-footer.php";
    ?>
<?php } else {
    header("Location:../login.php");
}
