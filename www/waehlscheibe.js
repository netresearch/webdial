function initWaehlscheibe()
{
   checkRegistrationStatus();
   prepareDialling();
   handleCall();
   $('#dial').submit(function() {
       indicateDialling();
   });
}

function getHandlerUrl()
{
    var loc = document.location.href;
    var url = loc.replace(/#.*/, '') + '?call=%s';
    return url;
}

function registerHandler()
{
    window.navigator.registerProtocolHandler(
        'tel', getHandlerUrl(), 'Telefonwählscheibe'
    );
    checkRegistrationStatus();
}

function isHandlerRegistered()
{
    if (!window.navigator.isProtocolHandlerRegistered) {
        return 'unknown';
    }

    var state = window.navigator.isProtocolHandlerRegistered('tel', getHandlerUrl());
    return state == 'registered';
}


function registerPhone()
{
    var def = 'abc.telefon.nr';
    if (isPhoneRegistered()) {
        def = localStorage.getItem('telUrl')
            .replace('http://', '')
            .replace(/\/$/, '');
    }
    var res = window.prompt(
        "IP deines Telefons (oder 'KUERZEL.telefon.nr')",
        def
    );
    if (res == '' || res == null) {
        return false;
    }

    var url = 'http://' + res.toLowerCase() + '/';
    localStorage.setItem('telUrl', url);

    checkRegistrationStatus();
    return true;
}

function isPhoneRegistered()
{
    return localStorage.getItem('telUrl') != null;
}

function checkRegistrationStatus()
{
    if (window.navigator.registerProtocolHandler) {
        $('#register-handler-support-error').hide();
    }

    var hState = isHandlerRegistered();
    if (hState == 'unknown') {
        $('#register-handler-error').hide();
        $('#register-handler-ok').hide();
        $('#register-handler-unknown').show();
    } else if (hState) {
        $('#register-handler-error').hide();
        $('#register-handler-ok').show();
        $('#register-handler-unknown').hide();
    } else {
        $('#register-handler-error').show();
        $('#register-handler-ok').hide();
        $('#register-handler-unknown').hide();
    }

    if (isPhoneRegistered()) {
        $('#register-phone-error').hide();
        $('#register-phone-ok').show();
    } else {
        $('#register-phone-error').show();
        $('#register-phone-ok').hide();
    }
}

function handleCall()
{
    if (!isPhoneRegistered()) {
        return false;
    }

    var oGetVars = {};
    if (window.location.search.length < 1) {
        return false;
    }
    for (var aItKey, nKeyId = 0, aCouples = window.location.search.substr(1).split("&"); nKeyId < aCouples.length; nKeyId++) {
        aItKey = aCouples[nKeyId].split("=");
        oGetVars[unescape(aItKey[0])] = aItKey.length > 1 ? unescape(aItKey[1]) : "";
    }

    if (!oGetVars.call || oGetVars.call == '') {
        return false;
    }

    var number = oGetVars.call.replace('tel:', '');

    prepareDialling();
    $('#number').val(number);
    $('#dial').submit();
    indicateDialling();
}

function prepareDialling()
{
    $('#dial').attr('action', localStorage.getItem('telUrl'));
}

function indicateDialling()
{
    $('#dialling').show('slow');
    window.setTimeout(
        function() {
            $('#dialling').hide('slow');
        },
        5000
    );
}
