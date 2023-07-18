import './bootstrap';

import { Loading } from '../../public/plugins/custom/notiflix/build/notiflix-loading-aio';
import { Notify } from '../../public/plugins/custom/notiflix/build/notiflix-notify-aio';
import { Confirm } from '../../public/plugins/custom/notiflix/build/notiflix-confirm-aio';

const app_url = window.location.origin;

const openGlobalModal = (url, title, footer = null) => {
    $.ajax({
        type: 'GET',
        url: url,
        beforeSend: function () {
            toggleLoading(true, i18n.global.generate_view);
        },
        success: function (res) {
            toggleLoading(false);
            $('#globalModal .modal-body').html(res.data.view);
            $('#globalModal .modal-title').html(title);
            if (footer) {
                footerModal(footer);
            }
            $('#globalModal').modal('show');

            if ($('#globalModal .onlyNumber')) {
                runRegexNumber();
            }

            if ($('#globalModal .onlyWord')) {
                runRegexWord();
            }

            if ($('#globalModal .password')) {
                runElemPassword();
            }

            if ($('#globalModal .phoneFormat')) {
                runRegexPhone();
            }
        },
        error: function (err) {
            toggleLoading(false);
        }
    })
}

const footerModal = (data) => {
    let html = $('.' + data.target).html();
    $('.' + data.target).remove();

    $('#globalModal .modal-footer').html(html);
}

const closeGlobalModal = () => {
    $('#globalModal').modal('hide');
    $('#globalModal .modal-body').html('');
    $('#globalModal .modal-title').html('');
}

const toggleLoading = (isShow, text = 'Loading ...') => {
    if (isShow) {
        Loading.standard(text);
    } else {
        Loading.remove();
    }
}

const errorForm = (formElement, err) => {
    var f = formElement.find('div[class="invalid-feedback"]');
    if (typeof err.responseJSON.errors !== 'undefined') {
        for (var i = 0; i < f.length;) {
            var el = f[i].attributes['1'].nodeValue;
            if (typeof err.responseJSON.errors[el] !== 'undefined') {
                jQuery(`[id="${el}"]`).removeClass('is-valid')
                    .addClass('is-invalid');

                jQuery(`div[id="${el}"]`).html(err.responseJSON.errors[el][0]);
                jQuery(`div[id="${el}"]`).show();
            }
            i++;
        }
    }
}

const findFormElement = (formElement, _class = 'default') => {
    var borderInput = '';
    if (_class === 'success') {
        borderInput = 'is-valid';
    } else if (_class === 'error') {
        borderInput = 'is-invalid';
    }

    var inputs = formElement.find('input');
    if (inputs.length > 0) {
        for (var i = 0; i < inputs.length;) {
            if (inputs[i].id !== '') {
                var input = jQuery(`[id="${inputs[i].id}"]`);
                if (input.attr('type') !== 'checkbox' && input.attr('type') !== 'radio') {
                    input.removeClass('is-valid is-invalid')
                        .addClass(borderInput);
                    var cc = $(`div[data-error="${inputs[i].id}"]`).attr('style');
                    if (cc != undefined) {
                        $(`div[data-error="${inputs[i].id}"]`).removeAttr('style');
                    }
                }
            }
            i++;
        }
    }

    var textareas = formElement.find('textarea');
    if (textareas.length > 0) {
        for (var n = 0; n < textareas.length;) {
            if (textareas[n].id !== '') {
                jQuery(`[id="${textareas[n].id}"]`).removeClass('is-valid is-invalid')
                    .addClass(borderInput);
            }
            n++;
        }
    }

    var selects = formElement.find('select');
    if (selects.length > 0) {
        for (var x = 0; x < selects.length;) {
            if (selects[x].id !== '') {
                jQuery(`[id="${selects[x].id}"]`).removeClass('is-valid is-invalid')
                    .addClass(borderInput);
            }
            x++;
        }
    }
}

const handleSuccess = (message) => {
    Notify.success(message);
}

const handleError = (err, formId = null) => {
    if (err.status == 422) {
        return errorForm($('#' + formId), err);
    } else {
        return handleNormalError(err);
    }
}

const handleNormalError = (err) => {
    let error = err.responseJSON.message;
    Notify.failure(error);
}

window.app_url = app_url
window.errorForm = errorForm;
window.closeGlobalModal = closeGlobalModal;
window.openGlobalModal = openGlobalModal;
window.footerModal = footerModal;
window.toggleLoading = toggleLoading;
window.errorForm = errorForm;
window.findFormElement = findFormElement;
window.Confirm = Confirm;
window.handleSuccess = handleSuccess;
window.handleError = handleError;
window.handleNormalError = handleNormalError;
