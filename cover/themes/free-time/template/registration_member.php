<?php if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    }
/*
 @Flusity 
 Author Darius Jakaitis, author web site https://www.flusity.com
 fix-content
*/
?>
<?php require_once 'menu-horizontal.php';  ?>
<header class="masthead register-header" style="background-image: url('/cover/themes/free-time/assets/img/pexels-pixabay-279810.jpg');height: 200px;padding-top: 0px;padding-bottom: 0px;margin-bottom: -16px;">
<div class="overlay register-head-ov" style="height: 200px;background: rgba(0,0,0,0.84);padding-bottom: 0px;"></div>
</header>
    <section class="py-4 py-xl-5" style="margin-top: -3px;">
        <div class="container">
            <div class="row mb-5" style="padding-bottom: 0px;padding-top: 0px;margin-bottom: 0px;">
                <div class="col-md-8 col-xl-6 text-center mx-auto" style="padding-bottom: 0px;">
                <h2><?php echo t("Event time Registration system");?></h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center" style="padding-top: 0px;">
                <div class="col-md-8 col-lg-8 col-xl-6" style="margin-top: -24px;padding-top: 0px;margin-right: 1px;">
                    
                <div class="col-md-12 text-center" style="padding-bottom: 0px;"> 
                   
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; 
                        if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show slow-fade">
                                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; 

                        $csrf_token = generateCSRFToken();
                        ?>
                </div>

                    <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $selectedTime = isset($_POST["selectedTime"]) ? $_POST["selectedTime"] : null;
                            $event_laboratory_id =  isset($_POST["event_laboratory_id"]) ? $_POST["event_laboratory_id"] : null;  // event_callendar_laboratories id
                            $event_item_id =  isset($_POST["event_item_id"]) ? $_POST["event_item_id"] : null; //event_callendar_item id
                            $event_laboratory_title = isset($_POST["event_laboratory_title"]) ? $_POST["event_laboratory_title"] : null; //pavadinimas iš event_callendar_laboratories
                            $event_item_title = isset($_POST["event_item_title"]) ? $_POST["event_item_title"] : null; //pavadinimas iš event_callendar_item
                            $reserve_date = isset($_POST["event_reserve_day"]) ? $_POST["event_reserve_day"] : null;
                            $event_target_audience = isset($_POST["event_target_audience"]) ? $_POST["event_target_audience"] : null;       
                        }
                        
                    if(isset($selectedTime) && $selectedTime != "") {  ?>
                    <form action="" method="POST" id="registrationForm" class="">
                    <div class="pb-3 row">
                            <div class="col-sm-12">
                                <h2 style="font-weight: 300;"><b><?php echo t("Location"); ?>: </b><?php echo $event_laboratory_title; ?></h2>
                            <input type="hidden" class="form-control disable" id="reserve_event_laboratory_id" name="reserve_event_laboratory_id" value="<?php echo $event_laboratory_id; ?>" readonly style="background-color: #f3f3f3;">
                        
                            <h4 style="font-weight: 300;"><b><?php echo t("Practice"); ?>: </b><?php echo $event_item_title; ?></h4>
                            <input type="hidden" class="form-control disable" id="event_item_id" name="event_item_id" value="<?php echo $event_item_id; ?>" readonly style="background-color: #f3f3f3;">
                            
                            <h4 style="font-weight: 300;"><b><?php echo t("Audience"); ?>: </b><?php echo $event_target_audience; ?></h4>
                            <input type="hidden" class="form-control disable" id="event_target_audience" name="event_target_audience" value="<?php echo $event_target_audience; ?>" readonly style="background-color: #f3f3f3;">
                            </div>
                        </div>
                    <div class="mb-6 row">
                            <div class="col-sm-4" style="min-width: 240px;">
                            <?php echo t("Event time and day selected"); ?>
                        </div>
                            <div class="col-sm-3">
                            <input type="time" class="form-control disable" id="selectedTime" name="reserve_event_time" value="<?php echo $selectedTime; ?>" readonly style="background-color: #f3f3f3; min-width: 80px;">
                            </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control disable" id="reserveDate" name="reserve_date" value="<?php echo $reserve_date; ?>" readonly style="background-color: #f3f3f3; min-width: 80px;">
                            </div>
                        </div>
                    
                        <div class="mb-3"><input type="text" class="form-control" id="member_login_name" name="member_login_name" placeholder="<?php echo htmlspecialchars(t("Login Name"));?>" required></div>
                       
                        <div class="mb-3"><input type="text" class="form-control" id="member_first_name" name="member_first_name" placeholder="<?php echo htmlspecialchars(t("First Name"));?>" required></div>
                       
                        <div class="mb-3"><input type="text" class="form-control" id="member_last_name" name="member_last_name" placeholder="<?php echo htmlspecialchars(t("Last Name"));?>" required></div>
                        
                        <div class="mb-3"><input type="text" class="form-control" id="member_telephone" name="member_telephone" placeholder="<?php echo htmlspecialchars(t("Telephone"));?>" required></div>
                      
                        <div class="mb-3"><input type="email" class="form-control" id="member_email" name="member_email" placeholder="<?php echo htmlspecialchars(t("Email"));?>" required></div>
                       
                        <div class="mb-3"><input type="text" class="form-control" id="member_institution" name="member_institution" placeholder="<?php echo htmlspecialchars(t("Institution"));?>"></div>
                       
                        <div class="mb-3"><input type="text" class="form-control" id="member_address_institution" name="member_address_institution" placeholder="<?php echo htmlspecialchars(t("Institution Address"));?>" required></div>
                       
                        <div class="mb-3 row">
                            <label for="member_invoice" class="col-sm-2 col-form-label"><?php echo t("Invoice"); ?></label>
                            <div class="col-sm-2">
                                <select class="form-control" id="member_invoice" name="member_invoice">
                                    <option value="0"><?php echo t("No"); ?></option>
                                    <option value="1"><?php echo t("Yes"); ?></option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="mb-3"><input type="text" class="form-control" id="member_employee_position" name="member_employee_position" placeholder="<?php echo htmlspecialchars(t("Employee Position"));?>" required></div>
                       
                        <div class="mb-3"><textarea class="form-control" id="member_description" name="member_description" placeholder="<?php echo htmlspecialchars(t("Additional information"));?>"></textarea></div>
                       
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        
                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100" type="submit" style="background: rgb(230,227,160);--bs-primary: #7faef2;--bs-primary-rgb: 127,174,242;border-style: none;color: rgb(136,132,132);"><?php echo t("Register event");?></button>
                        </div>
                    </form>

                <?php } else {
                echo "<p>" . t("You have not selected a event time. Registration is currently suspended. Please try again later.") . "</p>
                <div class='container mt-5 mb-3 no-register'></div>";
                }?>
                <p><?php echo t("Go to"); ?>&nbsp;<a href="/" class="btn-link"><?php echo strtolower(t("Home page")); ?></a>&nbsp;<?php echo t("or");?>&nbsp;
                <?php echo t("back to"); ?>&nbsp;<a href="/event-calendar" class="btn-link"><?php echo strtolower(t("Event calendar")); ?></a>&nbsp;<p>

                    </div>
                </div>
            </div>
    </section>