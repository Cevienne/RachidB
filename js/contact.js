$(document).ready(function() {
    (function($) {
        "use strict";

        jQuery.validator.addMethod('answercheck', function(value, element) {
            return this.optional(element) || /^\bcat\b$/.test(value);
        }, "type the correct answer -_-");

        // validate contactForm form
        $(function() {
            $('#contactForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    subject: {
                        required: true,
                        minlength: 4
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Bitte füge hier noch deinen Namen ein.",
                        minlength: "Dein Name muss mindestens aus zwei Buchstaben bestehen"
                    },
                    subject: {
                        required: "Um welche Veranstaltung handelt es sich?",
                        minlength: "Die Veranstaltung muss mindestens vier Buchstaben haben."
                    },
                    email: {
                        required: "Keine E-Mail? Ich benötige eine, um mich bei dir zu melden."
                    },
                    message: {
                        required: "Bitte beschreibe deine Art von Veranstaltung und ergänze Datum, Zeitraum, etc.",
                        minlength: "Dies sind zu wenig Informationen, bitte füge weitere hinzu."
                    }
                },
                submitHandler: function(form) {
                    console.log("Submit handler reached"); // Debugging
                    $(form).ajaxSubmit({
                        type: "POST",
                        data: $(form).serialize(),
                        url: "contact_process.php",
                        success: function(response) {
                            console.log("Form submitted successfully"); // Debugging
                            console.log("Server Response: " + response); // Protokollierung der Serverantwort
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor', 'default');
                                $('#success').fadeIn();
                                $('.modal').modal('hide');
                                $('#success').modal('show');
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("AJAX-Error: " + textStatus + ", " + errorThrown); // Fehlerprotokollierung
                            console.log("Response Text: " + jqXHR.responseText); // Protokollierung des vollständigen Antworttexts
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#error').fadeIn();
                                $('.modal').modal('hide');
                                $('#error').modal('show');
                            });
                        }
                    });
                }
            });
        });
    })(jQuery);
});