// Language
var tnum = 'en';

$(document).ready(function () {

    if (localStorage.getItem("primary") != null) {
        var primary_val = localStorage.getItem("primary");
        $("#ColorPicker1").val(primary_val);
        var secondary_val = localStorage.getItem("secondary");
        $("#ColorPicker2").val(secondary_val);
    }


    $(document).click(function (e) {
        $('.translate_wrapper, .more_lang').removeClass('active');
    });
    $('.translate_wrapper .current_lang').click(function (e) {
        e.stopPropagation();
        $(this).parent().toggleClass('active');

        setTimeout(function () {
            $('.more_lang').toggleClass('active');
        }, 5);
    });


    /*TRANSLATE*/
    translate(tnum);

    $('.more_lang .lang').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.more_lang').removeClass('active');

        var i = $(this).find('i').attr('class');
        var lang = $(this).attr('data-value');
        var tnum = lang;
        translate(tnum);

        $('.current_lang .lang-txt').text(lang);
        $('.current_lang i').attr('class', i);
        if (lang === 'ae'){
            $("body").attr("class", 'rtl');
            $("html").attr("dir", 'rtl');
            localStorage.setItem('rtl', true)
        }else{
            $("body").removeClass('rtl')
            $("html").attr("dir", '');
            localStorage.removeItem("rtl");
        }


    });
});

function translate(tnum) {
    $('.trans_leave_manager').text(trans['trans_leave_manager'][tnum]);
    $('.trans_leave_policy').text(trans['trans_leave_policy'][tnum]);
    $('.trans_leave_entitlements').text(trans['trans_leave_entitlements'][tnum]);
}

var trans = {
    trans_leave_manager : {
        en: 'Leave Manager',
        ae: 'إعدادات الاجازات'
    },
    trans_leave_policy : {
        en: 'Leave Policies',
        ae: 'سياسات الاجازة'
    },
    trans_leave_entitlements : {
        en: 'Leave Entitlements',
        ae: 'استحقاقات الإجازة'
    },
};