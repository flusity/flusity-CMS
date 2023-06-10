
<h2><?php echo t("Contact Us"); ?></h2>
<form id="contact-form" method="post">
    <div class="form-group">
        <label for="name"><?php echo t("Name"); ?></label>
        <input type="text"  class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email"><?php echo t("Email"); ?></label>
        <input type="email"  class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message"><?php echo t("Message"); ?></label>
        <textarea  class="form-control" id="message" name="message" rows="4" required></textarea>
    </div>
    <button  class="w-100 btn btn-lg btn-primary mb-3" type="submit"><?php echo t("Send"); ?></button>
</form>
<div class="modal" tabindex="-1" id="responseModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pranešimas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="responseMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $("#contact-form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize(); 

        $.ajax({
    type: "POST",
    url: "../../core/tools/send_contact_form.php",
    data: formData,
    dataType: "json",
    success: function(response) {
        console.log(response);
        if (response.status === "success") {
            alert(response.message);
        } else {
            alert(response.message);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
        alert("An error occurred, please try again");
    }
});

    });
});
</script>