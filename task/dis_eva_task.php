<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user_master_id'])) {
    $page_title = "admin_team";
    $Dashboard = "ADMIN";
    $Department = "DEPARTMENT";
    $Employee = "EMPLOYEE";
    $Dashboard_link = "../admin/admin-dashboard.php";
    $Department_link = "../department/create_dept.php";
    $All_Employee = "ALL EMPLOYEES";
    $My_Team = "MY TEAM";
    $AllEmployee_link = "../admin/allEmployee.php";
    $MyTeam_link = "../admin/admin_myteam.php";
    $Parameter = "PARAMETER";
    $Parameter_link = "../parameter/view_para.php";
    $Evaluation_link = "../evaluation_form/view_admin_task.php";
    $Evaluation =  "Evaluation";
    $user_icon = "../assets/images/others/admin-default.png";
	$Session_name = $_SESSION['name'];
	$name = "$Session_name";
	$logout = "../logout.php";
    include "../master/db_conn.php";
    include "../master/pre-header.php";
    include "../master/close_header.php";
?>

    <?php
    include "../master/header.php";
    include "../master/navbar_admin.php";
    include "../master/breadcrumbs.php";
    ?>
    <!-- main content starts here -->



    <?php
    if (($_SESSION['role'] == 'employee' && $_SESSION['is_manager'] == 1) || ($_SESSION['role'] == 'employee' && $_SESSION['is_manager'] == 0) || ($_SESSION['role'] == 'admin')) { ?>
        <?php
        $form_id = $_GET['vmt_form_id'];
        //echo $form_id;
        $task_id = $_GET['vmt_task_id'];
        $task_title = $_GET['vmt_task_title'];
        $manager_id = $_GET['vmt_manager_id'];
        $for_id = $_GET['vmt_for_id'];
        $sql_1 = "SELECT name from user_master where user_master_id='$manager_id' AND is_deleted=0";
        $result_1 = mysqli_query($conn,$sql_1);
        $fetch_1 = $result_1->fetch_assoc();
        $sql_2 = "SELECT name from user_master where user_master_id='$for_id' AND is_deleted=0";
        $result_2 = mysqli_query($conn,$sql_2);
        $fetch_2 = $result_2->fetch_assoc();

        ?>
        <div class="row">
            <div class="span6">
                <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
                    <div class="d-flex flex-column justify-content-between w-100">
                        <div class="container d-flex h-100">
                            <div class="row align-items-center w-150">
                                <div class="col-md-7 col-lg-12 m-h-auto">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between m-b-30">
                                                <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                            </div>
                                            <!-- manager form starts here -->
                                            <h2 style="text-align:center; color:rgb(52, 140, 181);"> Evaluation of <?php echo $fetch_2['name'];?> By <?php echo $fetch_1['name'];?></h2>
                                            <form action="employee_manager_insert.php" method="POST">
                                                <input type='hidden' id='mt_form_id' name='form_id' value='<?php echo " $form_id"; ?>'>
                                                <input type='hidden' id='manager_id' name='manager_id' value='<?php echo "$manager_id"; ?>'>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" id="myDate_1" name="myDate" disabled />
                                                    </div>
                                                </div>
                                                <?php if (isset($_GET['error'])) { ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <?= $_GET['error'] ?>
                                                    </div>
                                                <?php } ?>
                                                <!-- form-task-start -->
                                                <div class="form-group">
                                                    <label class="font-weight-semibold" for="title">Task Title:</label>
                                                    <div class="input-affix">
                                                        <select class="form-control" id="title" name="title" disabled>
                                                            <?php
                                                            //$id = $_SESSION['user_master_id'];
                                                            $sql = "SELECT task_id,task_title FROM task_master WHERE task_id='$task_id' AND is_deleted=0 ";
                                                            $result = mysqli_query($conn, $sql);
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <option value="<?php echo $row['task_id']; ?>"> <?php echo $row['task_title']; ?></option>
                                                            <?php
                                                            endwhile;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- form-task-end -->
                                                <!-- form-evaluation-start -->
                                                <div class="form-group">
                                                    <label class="font-weight-semibold" for="desc">Evaluation:</label>
                                                    <div class="input-affix">
                                                        <!--<i class="prefix-icon anticon anticon-user"></i>-->
                                                        <input type="text" class="form-control" style="text-align:left" id="desc" name="desc" placeholder="task_eval" required readonly value="
                                                    <?php
                                                    $query_1 = "SELECT desc_manager from form_master where form_id = '$form_id'";
                                                    $r_1 = mysqli_query($conn, $query_1);
                                                    while ($row_1 = $r_1->fetch_assoc()) :
                                                        echo $row_1['desc_manager'];
                                                    endwhile;
                                                    ?> 
                                                    ">
                                                    </div>
                                                </div>
                                                <!-- form-evaluation-end -->


                                                <!-- form-checkbox -start -->
                                                <div class="form-group">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"><label>parameters</label></th>
                                                                <th scope="col"><label>Min-Rate</label></th>
                                                                <th scope="col"><label>Your-Rate</label></th>
                                                                <th scope="col"><label>Max-Rate</label></th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $sql = "SELECT para_id,para_title,min_rating,max_rating FROM para_master WHERE is_deleted = 0 ";
                                                        $result = mysqli_query($conn, $sql);
                                                        $query_2 = "SELECT rating_manager FROM form_isto_para WHERE form_id ='$form_id' ";
                                                        $r_2 = mysqli_query($conn, $query_2);
                                                        $para = array(); ?>
                                                        <tbody>
                                                            <?php
                                                            while ($row = $result->fetch_assoc()) : ?>

                                                                <tr>
                                                                    <?php

                                                                    $id = $row['para_id'];
                                                                    ?>
                                                                    <td><input type="checkbox" checked disabled name="parameter_<?php echo $row['para_id']; ?>" value="<?php echo $row['para_id']; ?>">
                                                                        <label><?php echo $row['para_title']; ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" disabled maxlength="2" size='3' name=" min_rating" value="<?php echo $row['min_rating']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" disabled maxlength="2" size='3' name="rating_
                                                                    <?php echo $row['para_id']; ?>" value="<?php
                                                                                                            $row_2 = $r_2->fetch_assoc();
                                                                                                            echo $row_2['rating_manager']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" disabled maxlength="2" size='3' name="max_rating" value="<?php echo $row['max_rating']; ?>">
                                                                    </td>

                                                                </tr>


                                                            <?php
                                                            endwhile;
                                                            ?>
                                                        </tbody>
                                                    </table>


                                                </div>
                                                <!-- form-checkbox end------->
                                                <!-----------------------form-employee -start -->

                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" for="employee">Employee</label>
                                                    <select class="form-control" id="employee" name="employee" disabled>

                                                        <?php
                                                        $uid = $_GET['Id'];
                                                        $id = $_SESSION['user_master_id'];
                                                        $sql = "SELECT user_master.name,form_master.form_id,user_master.user_master_id FROM user_master INNER JOIN form_master ON form_master.for_id = user_master.user_master_id WHERE user_master.is_deleted=0 AND form_master.form_id='$form_id' ";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = $result->fetch_assoc()) :
                                                        ?>
                                                            <option value="<?php echo $row['user_master_id']; ?>"> <?php echo $row['name']; ?></option>
                                                        <?php
                                                        endwhile;
                                                        ?>
                                                    </select>
                                                </div>
                                                <!--form-employee -end -->
                                                <!-- form-submit -start -->
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <button class="btn btn-primary" name="submit" value='submit' id='submit' disabled>Submit</button>
                                                    </div>
                                                </div>
                                                <!-- form-submit -end -->
                                            </form>

                                            <!-- manager form ends here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
                    <div class="d-flex flex-column justify-content-between w-100">
                        <div class="container d-flex h-100">
                            <div class="row align-items-center w-150">
                                <div class="col-md-7 col-lg-12 m-h-auto">
                                    <div class="card shadow-lg">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between m-b-30">
                                                <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                            </div>

                                            <!-- emp form starts here -->
                                            <h2 style="text-align:center; color:rgb(52, 140, 181);"> <?php echo $fetch_2['name'];?>'s Evaluation</h2>
                                            <div>
                                                <form action="employee_manager_insert.php" method="POST" class="text-start">
                                                    <input type='hidden' id='mt_form_id' name='form_id' value='
                                                <?php echo " $form_id"; ?>'>

                                                    <input type='hidden' id='manager_id' name='manager_id' value='
                                                <?php echo "$manager_id"; ?>'>


                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" id="myDate" name="myDate" disabled />
                                                        </div>
                                                    </div>
                                                    <?php if (isset($_GET['error'])) { ?>
                                                        <div class="alert alert-danger" role="alert">
                                                            <?= $_GET['error'] ?>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- form-task-start -->
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold" for="title">Task Title:</label>
                                                        <div class="input-affix">
                                                            <select class="form-control" id="title" name="title" disabled>
                                                                <?php
                                                                //$id = $_SESSION['user_master_id'];
                                                                $sql = "SELECT task_id,task_title FROM task_master WHERE task_id='$task_id' AND is_deleted=0 ";
                                                                $result = mysqli_query($conn, $sql);
                                                                while ($row = $result->fetch_assoc()) :
                                                                ?>
                                                                    <option value="<?php echo $row['task_id']; ?>"> <?php echo $row['task_title']; ?></option>
                                                                <?php
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- form-task-end -->
                                                    <!-- form-evaluation-start -->
                                                    <div class="form-group">
                                                        <label class="font-weight-semibold" for="desc">Evaluation:</label>
                                                        <div class="input-affix">
                                                            <!--<i class="prefix-icon anticon anticon-user"></i>-->
                                                            <input type="text" class="form-control" style="text-align:left" id="desc" name="desc" placeholder="task_eval" required readonly value="
                                                    <?php
                                                    $query_1 = "SELECT desc_emp from form_master where form_id = '$form_id'";
                                                    $r_1 = mysqli_query($conn, $query_1);
                                                    while ($row_1 = $r_1->fetch_assoc()) :
                                                        echo $row_1['desc_emp'];
                                                    endwhile;
                                                    ?> 
                                                    ">
                                                        </div>
                                                    </div>
                                                    <!-- form-evaluation-end -->


                                                    <!-- form-checkbox -start -->
                                                    <div class="form-group">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"><label>parameters</label></th>
                                                                    <th scope="col"><label>Min-Rate</label></th>
                                                                    <th scope="col"><label>Your-Rate</label></th>
                                                                    <th scope="col"><label>Max-Rate</label></th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            $sql = "SELECT para_id,para_title,min_rating,max_rating FROM para_master WHERE is_deleted = 0 ";
                                                            $result = mysqli_query($conn, $sql);
                                                            $query_2 = "SELECT rating_emp FROM form_isto_para WHERE form_id ='$form_id' ";
                                                            $r_2 = mysqli_query($conn, $query_2);
                                                            $para = array(); ?>
                                                            <tbody>
                                                                <?php
                                                                while ($row = $result->fetch_assoc()) : ?>

                                                                    <tr>
                                                                        <?php

                                                                        $id = $row['para_id'];
                                                                        ?>
                                                                        <td><input type="checkbox" checked disabled name="parameter_<?php echo $row['para_id']; ?>" value="<?php echo $row['para_id']; ?>">
                                                                            <label><?php echo $row['para_title']; ?></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" disabled maxlength="2" size='3' name=" min_rating" value="<?php echo $row['min_rating']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" disabled maxlength="2" size='3' name="rating_
                                                                    <?php echo $row['para_id']; ?>" value="<?php
                                                                                                            $row_2 = $r_2->fetch_assoc();
                                                                                                            echo $row_2['rating_emp']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" disabled maxlength="2" size='3' name="max_rating" value="<?php echo $row['max_rating']; ?>">
                                                                        </td>

                                                                    </tr>


                                                                <?php
                                                                endwhile;
                                                                ?>
                                                            </tbody>
                                                        </table>


                                                    </div>
                                                    <!-- form-checkbox end------->
                                                    <!----------------------------------------------
                                                form-employee -start 

                                                <div class="form-group">
                                                <label for="exampleFormControlSelect1" for="employee">Employee</label>
                                                <select class="form-control" id="employee" name="employee">
                                                    <option value="" disabled selected hidden>Please Select</option>
                                                    <?php /*
                                                    $id = $_SESSION['user_master_id'];
                                                    $sql = "SELECT user_master_id,name FROM user_master WHERE is_deleted=0 AND manager_id = $id ORDER BY user_master_id ASC ";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = $result->fetch_assoc()) :
                                                    ?>
                                                        <option value="<?php echo $row['user_master_id']; ?>"> <?php echo $row['name']; ?></option>
                                                    <?php
                                                    endwhile;
                                                    */ ?>
                                                </select>
                                                </div>
                                             form-employee -end -->
                                                    <!-- form-submit -start -->
                                                    <div class="form-group">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <button class="btn btn-primary" name="submit" value='submit' id='submit' disabled>Submit</button>
                                                        </div>
                                                    </div>
                                                    <!-- form-submit -end -->
                                                </form>
                                            </div>
                                            <!-- emp form ends here -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function SetDate() {
                var date = new Date();

                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                if (month < 10) month = "0" + month;
                if (day < 10) day = "0" + day;

                var today = year + "-" + month + "-" + day;


                document.getElementById('myDate').value = today;
            }
        </script>

        <script type="text/javascript">
            function SetDate_1() {
                var date = new Date();

                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                if (month < 10) month = "0" + month;
                if (day < 10) day = "0" + day;

                var today = year + "-" + month + "-" + day;


                document.getElementById('myDate_1').value = today;
            }
        </script>

        <body onload="SetDate(); SetDate_1(); ">

        <?php
    } else {
        header('Location:../login.php');
    }
        ?>












        <!-- main content ends here -->
    <?php

    include "../master/footer.php";
    include "../master/after-footer.php";
} else {
    header("Location:../login.php");
}
