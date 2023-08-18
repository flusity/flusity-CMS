
<h2><?php echo t("Contact Us"); ?></h2>
<form id="contact-form" method="post">


<div class="control-group">
        <div class="form-floating controls mb-3"><input class="form-control" type="text" id="name" required="" placeholder="Name"><label class="form-label" for="name">Name</label><small class="form-text text-danger help-block"></small></div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><input class="form-control" type="email" id="email" required="" placeholder="Email Address"><label class="form-label">Email Address</label><small class="form-text text-danger help-block"></small></div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><small class="form-text text-danger help-block"></small></div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><textarea class="form-control" id="message" data-validation-required-message="Please enter a message." required="" placeholder="Message" style="height: 150px;"></textarea><label class="form-label">Message</label><small class="form-text text-danger help-block"></small></div>
    </div>

    <div class="form-group">
    <label for="captcha"><?php echo t("Human Check"); ?>: <span id="captchaQuestion"></span></label>
    <div class="d-flex justify-content-between">
        <div id="possibleAnswers" class="d-flex flex-wrap"></div>
        <div id="chosenAnswer" class="mt-2 border rounded p-2 flex-grow-1 ml-3" style="height: 42px">Įtempti atsakymą čia</div>
    </div>
</div>


    <button  class="w-100 btn btn-lg btn-primary mb-3 mt-5" type="submit"><?php echo t("Send"); ?></button>
</form>
