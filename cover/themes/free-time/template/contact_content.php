
<h2><?php echo $translations['contact_us']; ?></h2>
<form id="contact-form" method="post">

<div class="control-group">
        <div class="form-floating controls mb-3">
            <input class="form-control" type="text" id="name" required placeholder="<?php echo $translations['interesting_theme']; ?>">
            <label class="form-label" for="name"><?php echo $translations['interesting_theme']; ?></label>
            <small class="form-text text-danger help-block"></small>
        </div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><input class="form-control" type="email" id="email" required placeholder="<?php echo $translations['your_email']; ?>"><label class="form-label"><?php echo $translations['your_email']; ?></label><small class="form-text text-danger help-block"></small></div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><small class="form-text text-danger help-block"></small></div>
    </div>
    <div class="control-group">
        <div class="form-floating controls mb-3"><textarea class="form-control" id="message" data-validation-required-message="Please enter a message." required placeholder="<?php echo $translations['message']; ?>" style="height: 150px;"></textarea><label class="form-label"><?php echo $translations['message']; ?></label><small class="form-text text-danger help-block"></small></div>
    </div>

    <div class="form-group">
    <label for="captcha"><?php echo $translations['human_check']; ?>: <span id="captchaQuestion"></span></label>
    <div class="d-flex justify-content-between">
        <div id="possibleAnswers" class="d-flex flex-wrap"></div>
        <div id="chosenAnswer" class="mt-2 border rounded p-2 flex-grow-1 ml-3" style="height: 42px"><?php echo $translations['drag_answer']; ?></div>
    </div>
</div>
    <button  class="w-100 btn btn-lg btn-primary mb-3 mt-5" type="submit"><?php echo $translations['send']; ?></button>
</form>