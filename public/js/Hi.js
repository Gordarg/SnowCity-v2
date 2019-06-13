Hi = {
    message: function(text, error = false){
        // TODO: If was error change theme to red
        $(".message").html('<span class="' + (error? 'error' : 'confirm') + '">' + text + '</span>');
        $(".message").append("<a style=\"float: right; color:red; margin-right: 40px\" onclick=\"$('.message').hide();\">&times;</a>");
        $(".message").fadeIn('slow').delay(5000).fadeOut();
    },
    loginprotocol(){
        return "Userlogin=" + $.cookie("USERNAME")
        + "&Token=" + $.cookie("LOGINTOKEN");
    },
    baseurl(){
        return "http://localhost/SnowFramework/";
    },
    controller(){
        return Hi.baseurl() + "controller/";
    },
    modal: function(content)
    {
        // (document.getElementById('myModal')).style.display = "block";
        // $(".modal-content>p").html( content );
    },
    load: function(name, params = null){
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('.content').load(Hi.baseurl() + 'public/view/' + name + '.htm', function() {
            $.getScript(Hi.baseurl() + 'public/js/' + name + '.js', function() {
                // Change date inputs to persian format
                $("input[type=date]").attr('id', 'persianDate');
                $("input[type=date]").attr('type', 'text');
                $("input[id=persianDate]").persianDatepicker({
                    months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
                    dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
                    shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
                    showGregorianDate: true,
                    persianNumbers: !0,
                    formatDate: "YYYY/MM/DD",
                    selectedBefore: !1,
                    selectedDate: null,
                    startDate: null,
                    endDate: null,
                    prevArrow: '\u25c4',
                    nextArrow: '\u25ba',
                    theme: 'default',
                    alwaysShow: !1,
                    selectableYears: null,
                    selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    cellWidth: 40, // by px
                    cellHeight: 30, // by px
                    fontSize: 15, // by px                
                    isRTL: !1,
                    calendarPosition: {
                        x: 0,
                        y: 0,
                    },
                    onShow: function () { },
                    onHide: function () { },
                    onSelect: function () { 
                        // alert($(target).attr("data-gdate"));
                     }
                });
                
                // Construct
                if (jQuery.isFunction(window[name]))
                    window[name](params);
            });
        });
    },
    auth(role){
        if
        (
            (role != null)
            &&
            (
                ($.cookie("Type") == undefined) ||
                (role != 'USER' && role != 'EDTOR' && role != 'ADMIN') ||
                ($.cookie("Type") == 'USER' && role == 'EDTOR') ||
                (($.cookie("Type") == 'USER' || $.cookie("Type") == 'EDTOR') && role == 'ADMIN')
            )
        )
        {
            Hi.message('شما به این بخش دسترسی ندارید', true);
            Hi.load('login');
            return false;
        }
        return true;
    },
}