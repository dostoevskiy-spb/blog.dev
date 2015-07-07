$(document).ready(function () {
    $("select, input:checkbox, input:radio, input:file").uniform();

    $('[type=checkbox]').bind('change', function () {
        clearCheckboxError($(this));
    });

    function validateCheckRadio() {
        var err = {};

        $('.radio-group, .checkbox-group').each(function () {
            if ($(this).hasClass('required'))
                if (!$(this).find('input:checked').length)
                    err[$(this).find('input:first').attr('name')] = 'Пожалуйста, заполните это поле.';
        });

        if (!$.isEmptyObject(err)) {
            validator.invalidate(err);
            return false
        }
        else return true;

    }

    function clearCheckboxError(input) {
        var parentDiv = input.parents('.field');

        if (parentDiv.hasClass('required'))
            if (parentDiv.find('input:checked').length > 0) {
                validator.reset(parentDiv.find('input:first'));
                parentDiv.find('.error').remove();
            }
    }

    $.tools.validator.addEffect("labelMate", function (errors, event) {
        $.each(errors, function (index, error) {
            error.input.first().parents('.field').find('.error').remove().end().find('label').after('<span class="error">' + error.messages[0] + '</span>');
        });

    }, function (inputs) {
        inputs.each(function () {
            $(this).parents('.field').find('.error').remove();
        });

    });

    $(".TTWForm").validator({effect: 'labelMate'}).submit(function (e) {
        var form = $(this), checkRadioValidation = validateCheckRadio();

        if (!e.isDefaultPrevented() && checkRadioValidation) {
            $.post(form.attr('action'), form.serialize(), function (data) {
                console.log(data);
                data = $.parseJSON(data);

                if (data.status == 'success') {
                    form.fadeOut('fast', function () {
                        $('.TTWForm-container').append('<h2 class="success-message">Спасибо!</h2>');
                    });
                    document.location.href = data.redirect;
                }
                else validator.invalidate(data.errors);

            });
        }

        return false;
    });

    var validator = $('.TTWForm').data('validator');


});
