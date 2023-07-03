
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
