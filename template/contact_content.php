
<h2>Contact Us</h2>
<form id="contact-form" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="4" required></textarea>
    </div>
    <button type="submit">Send</button>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Uždaryti</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $("#contact-form").submit(function(event) {
        event.preventDefault(); // Sustabdyti formos įprastą siuntimo veikimą

        var formData = $(this).serialize(); // Surinkti visus formos duomenis

        // Siųsti formos duomenis naudojant AJAX
        $.ajax({
            type: "POST",
            url: "../../core/tools/send_contact_form.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    // Rodyti sėkmės pranešimą, pvz., naudodami modalą
                    alert(response.message);
                } else {
                    // Rodyti klaidos pranešimą, pvz., naudodami modalą
                    alert(response.message);
                }
            },
            error: function() {
                // Rodyti klaidos pranešimą, pvz., naudodami modalą
                alert("Įvyko klaida, bandykite dar kartą");
            }
        });
    });
});
</script>