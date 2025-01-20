(function ($) {
    'use strict';
    if (typeof Livewire !== 'undefined') {
        Livewire.on('showAlertMessage', showAlert);
        Livewire.on('showConfirm', ConfirmationBox);
        Livewire.on('initSummerNote', initSummerNote);

        Livewire.on('toggleModel', (event) => {
            jQuery(`#${event.id}`).modal(event.action);
        });

        Livewire.on('initSelect2', (event) => {
            const { target, timeOut = 500 } = event;
            setTimeout(() => {
                jQuery(event.target).each((index, item) => {
                    let _this = jQuery(item);
                    let searchable = _this.data('searchable');
                    let componentId = _this.data('componentid');
                    let modelInput = _this.data('wiremodel');
                    let live = _this.data('live') ?? false;
                    let component = eval(componentId);
                    let params = {
                        placeholder: _this.data('placeholder'),
                        allowClear: true,
                    };

                    let autoclose = _this.data('autoclose');
                    if (event.data?.length) {
                        params['data'] = event.data;
                    }
                    if (autoclose == false) {
                        params['closeOnSelect'] = false;
                    }

                    if (_this.data('hide_search_opt')) {
                        params['minimumResultsForSearch'] = -1;
                    }

                    if (_this.data('parent')) {
                        params['dropdownParent'] = jQuery(_this.data('parent'));
                    }

                    if (!searchable) {
                        params['minimumResultsForSearch'] = Infinity;
                    }
                    params['dropdownCssClass'] = _this.data('class');

                    if (_this.data('format') == 'custom') {
                        params['templateResult'] = formatSelect2Option;
                        params['templateSelection'] = formatSelect2Selection;
                        params['escapeMarkup'] = function (markup) {
                            return markup;
                        };
                    }
                    if (event.reset) {
                        if (_this.data('select2')) {
                            _this.val('').trigger('change');
                            _this.select2('destroy');
                        }
                    }
                    _this.select2(params);
                    if (event.reset) {
                        _this.val(event.value ?? '').trigger('change');
                    }
                    if (_this.data('disable_onchange') != 'true') {
                        _this.on('change', function (e) {
                            if (modelInput) {
                                let value = _this.select2('val');
                                component.set(modelInput, value, live);
                            }
                        });
                    }
                });
            }, timeOut);
        });
    }

    jQuery(document).on('click', '#confirm-popup .am-confirm-yes', function () {
        console.log(popupParams.action, popupParams);
        Livewire.dispatch(popupParams.action, { params: popupParams });
        jQuery('#confirm-popup').modal('hide');
    });

    jQuery(document).on('click', '.am-ordersummary_close', function () {
        jQuery('.am-ordersummary').slideUp('slow');
    });

    jQuery(document).on(
        'click',
        '.am-orderwrap > .am-header_user_noti',
        function () {
            jQuery('.am-ordersummary').slideDown();
        }
    );

    jQuery(document).on('click', '.am-header_user_menu > a', function () {
        jQuery('.am-header_user_menu > ul').slideToggle();
    });
})(jQuery);

let popupParams;

function ConfirmationBox(params) {
    popupParams = params;
    let {
        content,
        title,
        action,
        icon = 'delete',
        btnOk_title = '',
        btnCancel_title = '',
        overrideClass = '',
    } = params;
    jQuery('#confirm-popup .am-deletepopup_icon')
        .not(`.am-deletepopup_icon.${icon}-icon`)
        .remove();
    jQuery('#confirm-popup').modal('show');
    if (title) {
        jQuery('#confirm-popup .am-deletepopup_title h3').text(title);
    }
    if (content) {
        jQuery('#confirm-popup .am-deletepopup_title p').text(content);
    }
    if (btnOk_title) {
        jQuery('#confirm-popup .am-confirm-yes').text(btnOk_title);
    }
    if (btnCancel_title) {
        jQuery('#confirm-popup .am-cancel').text(btnCancel_title);
    }
    if (overrideClass) {
        jQuery('#confirm-popup')
            .removeClass('am-deletepopup')
            .addClass(overrideClass);
    }
}

// initialize time picker
function initializeTimePicker() {
    jQuery('.flat-time').each(function (index, item) {
        let _this = jQuery(this);
        let time_24hr = _this.data('time_24hr');
        let config = { dateFormat: 'H:i', noCalendar: true, enableTime: true };

        if (time_24hr != '') {
            config.time_24hr = time_24hr;
        }
        jQuery(item).flatpickr(config);
    });
}

// initialize date picker
function initializeDatePicker() {
    jQuery('.flat-date').each(function (index, item) {
        let _this = jQuery(this);
        let dateFormat = _this.data('format');
        let enableTime = _this.data('enable_time');
        let time_24hr = _this.data('time_24hr');
        let mode = _this.data('mode');
        let disable = _this.data('disable_dates');
        let defaultDate = _this.data('default_date');
        let minDate = _this.data('min_date');
        let config = { dateFormat: dateFormat };
        if (enableTime) {
            config.enableTime = enableTime ?? false;
        }
        if (mode) {
            config.mode = mode;
        }
        if (time_24hr) {
            config.time_24hr = time_24hr;
        }
        if (defaultDate) {
            config.defaultDate = defaultDate;
        }
        if (disable) {
            config.disable = disable;
        }
        if (minDate) {
            config.minDate = minDate;
        }
        jQuery(item).flatpickr(config);
    });
}

function showAlert(data) {
    let { message, type, autoclose = 2000 } = data;

    jQuery('.am-themetoast').addClass('show');
    jQuery('.am-themetoast').removeClass('hide');
    jQuery('.am-themetoast h6').text(message);
    let successIcon = `
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M3 9.75L6.75 13.5L15 4.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    `;
    let errorIcon = `
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
        <path d="M0 16C0 7.16344 7.16344 0 16 0V0C24.8366 0 32 7.16344 32 16V16C32 24.8366 24.8366 32 16 32V32C7.16344 32 0 24.8366 0 16V16Z" fill="#F04438"/>
        <path d="M11.5 20.5L20.5 11.5M11.5 11.5L20.5 20.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>`;
    jQuery('.am-themetoast .am-toast-icon').html(
        type == 'success' ? successIcon : errorIcon
    );
    setTimeout(() => {
        jQuery('.am-themetoast').removeClass('show');
        jQuery('.am-themetoast').addClass('hide');
    }, autoclose);
}

function initSummerNote(params) {
    const { target, wiremodel, conetent, componentId } = params;
    jQuery(target).summernote('destroy');
    jQuery(target).summernote(summernoteConfigs(target, jQuery(target).next()));
    let component = eval(componentId);
    jQuery(target).summernote('code', conetent?.length ? conetent : '');
    jQuery(target).on('summernote.change', function (we, contents, $editable) {
        component.set(wiremodel, contents, false);
    });
}

function formatSelect2Option(option) {
    if (!option.id) {
        return option.text;
    }

    var $option = jQuery(
        '<span>' +
            option.text +
            ' <span class="price">' +
            jQuery(option.element).data('price') +
            '</span></span>'
    );

    return $option;
}

function formatSelect2Selection(option) {
    if (!option.id) {
        return option.text;
    }

    var $selection = jQuery(
        '<span>' +
            option.text +
            ' <span class="price">' +
            jQuery(option.element).data('price') +
            '</span></span>'
    );

    return $selection;
}

var charLimit = 500;
function summernoteConfigs(
    selector = '.summernote',
    charSelector = '.total-characters'
) {
    return {
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol']],
        ],
        height: 300,
        spellCheck: true,
        dialogsInBody: true,
        disableDragAndDrop: true,
        disableResizeEditor: true,
        callbacks: {
            onInit: function () {
                if (jQuery(this).summernote('isEmpty')) {
                    jQuery(selector).summernote('code', '');
                    charLeft(0, charSelector);
                } else {
                    let characters = jQuery(selector)
                        .summernote('code')
                        .replace(/(<([^>]+)>)/gi, '');
                    charLeft(characters.length, charSelector);
                }
            },
            onKeydown: function (e) {
                var t = e.currentTarget.innerText;
                charLeft(t.trim().length, charSelector);
                if (charSelector != '.total-characters') {
                    return;
                }
                if (t.trim().length >= charLimit) {
                    if (
                        e.keyCode != 8 &&
                        !(e.keyCode >= 37 && e.keyCode <= 40) &&
                        e.keyCode != 46 &&
                        !(e.keyCode == 32 && e.spaceKey) &&
                        !(e.keyCode == 88 && e.ctrlKey) &&
                        !(e.keyCode == 67 && e.ctrlKey)
                    )
                        e.preventDefault();
                }
            },
            onKeyup: function (e) {
                if (charSelector != '.total-characters') {
                    return;
                }
                var t = e.currentTarget.innerText;
                jQuery(selector).text(charLimit - t.trim().length);
            },
            onPaste: function (e) {
                if (charSelector != '.total-characters') {
                    return;
                }
                let characters = jQuery(selector)
                    .summernote('code')
                    .replace(/(<([^>]+)>)/gi, '');
                let totalCharacters = characters.length;

                var t = e.currentTarget.innerText;
                var bufferText = (
                    (e.originalEvent || e).clipboardData || window.clipboardData
                ).getData('Text');
                e.preventDefault();

                var maxPaste = bufferText.length;
                if (t.length + bufferText.length > charLimit) {
                    maxPaste = charLimit - t.length;
                }
                let maxText = bufferText.substring(0, maxPaste);

                jQuery(charSelector).text(
                    charLimit -
                        (totalCharacters + maxText?.length) +
                        ' / ' +
                        charLimit
                );
                let remainingChar = totalCharacters + maxText?.length;
                charLeft(remainingChar, charSelector);
                if (maxPaste > 0) {
                    document.execCommand('insertText', false, maxText);
                }
                jQuery(selector).text(charLimit - t.length);
            },
            onCut: function (e) {
                console.log(
                    'e.currentTarget.innerText',
                    e.currentTarget.innerText
                );
            },
        },
    };
}

function charLeft(contentLength = 0, charSelector) {
    if (charSelector == '.total-characters') {
        let charShow = charLimit - contentLength;
        if (charShow < 0) {
            charShow = 0;
        }
        let charLeftHtml = `<div class='tu-input-counter'><span>Characters left:</span><b>${charShow}</b> / <em> ${charLimit}</em></div>`;
        jQuery(charSelector).html(charLeftHtml);
    } else {
        let charLeftHtml = `<div class='tu-input-counter'><span>Characters count:</span> ${contentLength}</div>`;
        jQuery(charSelector).html(charLeftHtml);
    }
}

function initVenobox() {
    let venobox = document.querySelector('.tu-themegallery');
    if (venobox !== null) {
        return jQuery('.tu-themegallery').venobox();
    }
}

function clearFormErrors(target) {
    jQuery(`${target} .am-invalid`).removeClass('am-invalid');
    jQuery(`${target} span.am-error-msg`).remove();
}

jQuery(document).on(
    'click',
    '.am-navigation .page-item-has-children > a',
    function () {
        jQuery(this).parent().children('.sub-menu').slideToggle('300');
        jQuery(this).parent('.page-item-has-children').toggleClass('active');
    }
);

function initJs(){
    setTimeout(() => {
            jQuery('.video-js').each((index, item) => {
                let _this = jQuery(item);
                item.onloadeddata =  function(){
                _this.closest('.am-revolutionize_video').removeClass('am-shimmer');
                videojs(item);
                }
            })
            initVenobox()
        }, 500);
}

initJs()

