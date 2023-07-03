
<header id="header" class="no-header">
<?php require_once 'menu-horizontal.php';?>
</header>
<main class="main">
 <div class="container spacer">
    <div class="row">
        <div class="col-sm-7">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-left-7');
            } else {
                print "";
            }
            ?>
        </div>
        <div class="col-sm-5">
            <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-right-5');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5"> 
        <?php
                if (isset($_SESSION['success_message'])) {
                    echo "<div class='alert alert-success alert-dismissible fade show slow-fade'>
                        " . htmlspecialchars($_SESSION['success_message']) . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    unset($_SESSION['success_message']);
                }

                if (isset($_SESSION['error_message'])) {
                    echo "<div class='alert alert-danger alert-dismissible fade show slow-fade'>
                        " . htmlspecialchars($_SESSION['error_message']) . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    unset($_SESSION['error_message']);
                }
                ?>
        <?php require_once 'contact_content.php';?>

        </div>
        <div class="col-sm-7">
        <?php foreach ($posts as &$post): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
       <?php endforeach; ?>
       <?php echo createPagination($url, $total_urls); ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 text-center"> 
        <?php 
            $page_url = getCurrentPageUrl($db, $prefix);
            if ($page_url) {
                displayPlace($db, $prefix, $page_url, 'contact-fluid-12');
            } else {
                print "";
            }
            ?>
        </div>
    </div>
</div>
</main>
<div class="modal high-z-index" tabindex="-1" id="responseModal">
  <div class="modal-dialog">
    <div class="modal-content">
   
        <button type="button" class="btn-close uniqueCloseButton"  data-bs-dismiss="modal" aria-label="Close"></button>
      
      <div class="modal-body">
        <i class="fas fa-check-circle fa-3x"></i>
        <p id="responseMessage"></p>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    var num1 = Math.floor(Math.random() * 10);
    var num2 = Math.floor(Math.random() * 10);


    $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");

    $("#contact-form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize(); 

        var captcha = $("#captcha").val();

        if (parseInt(captcha) === num1 + num2) {
            $.ajax({
                type: "POST",
                url: "../../core/tools/send_contact_form.php",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $("#responseMessage").text(response.message);
                    if (response.status === "success") {
                        $("#responseModal .modal-body").addClass("text-success");
                        $("#responseModal .modal-body i").addClass("fa-check-circle").removeClass("fa-times-circle");
                    } else {
                        $("#responseModal .modal-body").addClass("text-danger");
                        $("#responseModal .modal-body i").addClass("fa-times-circle").removeClass("fa-check-circle");
                    }
                    $("#responseModal").modal("show");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                    alert("An error occurred, please try again");
                }
            });
        } else {
            
            $("#responseMessage").text('Klaida: neteisingai įvestas patikrinimo atsakymas');
            $("#responseModal .modal-body").addClass("text-danger");
            $("#responseModal .modal-body i").addClass("fa-times-circle").removeClass("fa-check-circle");
            $('#responseModal').modal('show');
        }

        num1 = Math.floor(Math.random() * 10);
        num2 = Math.floor(Math.random() * 10);
        $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");
        $("#captcha").val("");
    });
});
</script>
