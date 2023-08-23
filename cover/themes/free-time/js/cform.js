// Flusity cform js script
$(document).ready(function() {
    function generateUniqueAnswers(result) {
        var answers = [result];

        while(answers.length < 5) { // Atsakymų Variantų skaičius 
            var randomAnswer = result + Math.floor(Math.random() * 10) - 5;
            if(!answers.includes(randomAnswer)) {
                answers.push(randomAnswer);
            }
        }

        return answers.sort(() => Math.random() - 0.5);
    }

    function generateNewQuestion() {
        num1 = Math.floor(Math.random() * 10);
        num2 = Math.floor(Math.random() * 10);
        result = num1 + num2;
        answers = generateUniqueAnswers(result);
        $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");

        // Clear previous answers and generate new ones
        $("#possibleAnswers").empty();
        $.each(answers, function(index, value){
            $("<div>", {
                text: value,
                class: "answer-option m-2 p-2 border rounded"
            }).appendTo("#possibleAnswers");
        });

        $(".answer-option").draggable({
            revert: "invalid",
            cursor: "move"
        });

        $("#chosenAnswer").html("Drag answer here");
    }




    var num1 = Math.floor(Math.random() * 10);
    var num2 = Math.floor(Math.random() * 10);
    var result = num1 + num2;

    var answers = generateUniqueAnswers(result);

    $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");
    $("#possibleAnswers").empty();

    $.each(answers, function(index, value){
        $("<div>", {
            text: value,
            class: "answer-option m-2 p-2 border rounded"
        }).appendTo("#possibleAnswers");
    });

    $(".answer-option").draggable({
        revert: "invalid"
    });

    $("#chosenAnswer").droppable({
    accept: ".answer-option",
    drop: function(event, ui){
        $(this).html(ui.draggable.text());
        ui.draggable.remove();

        // Check if all answers have been used
        if($("#possibleAnswers").is(':empty')) {
            // Generate a 'Next Question' button
            var nextButton = $("<button>", {
                text: "Repeat ?",
                class: "answer-option m-2 p-2 border rounded"
            });

            nextButton.on("click", function() {
                // Generate new question and answers
                num1 = Math.floor(Math.random() * 10);
                num2 = Math.floor(Math.random() * 10);
                result = num1 + num2;
                answers = generateUniqueAnswers(result);
                $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");

                // Clear previous answers and generate new ones
                $("#possibleAnswers").empty();
                $.each(answers, function(index, value){
                    $("<div>", {
                        text: value,
                        class: "answer-option m-2 p-2 border rounded"
                    }).appendTo("#possibleAnswers");
                });

                $(".answer-option").draggable({
                    revert: "invalid"
                });

                $("#chosenAnswer").html("Drag answer here");

                $(this).remove();
            });
            $("#possibleAnswers").append(nextButton);
        }
    }
    });


    $("#contact-form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize(); 
        var captcha = $("#chosenAnswer").text();

        if (parseInt(captcha) === result) {
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
                         // Clear the form fields
                        $("#contact-form")[0].reset();

                    // Then call the new question generation function
                    generateNewQuestion();
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
        result = num1 + num2;
        answers = [result, result + Math.floor(Math.random() * 5), result - Math.floor(Math.random() * 5)];
        answers = answers.sort(() => Math.random() - 0.5);
        $("#captchaQuestion").text(num1 + " + " + num2 + " = ?");
        $("#possibleAnswers").empty();

        $.each(answers, function(index, value){
            $("<div>", {
                text: value,
                class: "answer-option m-2 p-2 border rounded"
            }).appendTo("#possibleAnswers");
        });

        $(".answer-option").draggable({
            revert: "invalid"
        });

        $("#chosenAnswer").droppable({
            accept: ".answer-option",
            drop: function(event, ui){
                $(this).html(ui.draggable.text());
                ui.draggable.remove();
            }
        });

        $("#chosenAnswer").html("Drag answer here");
    });

    $('#responseModal').on('hidden.bs.modal', function (e) {
      //  location.reload();
      generateNewQuestion();
    });
});