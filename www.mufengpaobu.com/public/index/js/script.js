$(function(){
    //锚点链接
    $('#top').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({
                        scrollTop: targetOffset
                    },
                    600);
                return false;
            }
        }
    });
    $(".link").click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({
                        scrollTop: targetOffset
                    },
                    600);
                return false;
            }
        }
    });
    //滚动条
    $(window).scroll(function () {

        if($(window).scrollTop() >= $("#service").offset().top-$("#index").height()){
            $("#service").animate({
                opacity: 1
            }, 2000 );
            // $("#service").slideUp(0);
            // $("#service").slideDown(3000);

        }
        if($(window).scrollTop() >= $("#moving").offset().top-$("#index").height()-$("#service").height()){
            $("#moving").animate({
                opacity: 1
            }, 4000 );
        }
        if($(window).scrollTop() >= $("#about").offset().top-$("#index").height()-$("#service").height()-$("#moving").height()){
            $("#about").animate({
                opacity: 1
            }, 4000 );
        }
        if($(window).scrollTop() >= $("#contact").offset().top-$("#index").height()-$("#service").height()-$("#moving").height()-$("#about").height()){
            $("#contact").animate({
                opacity: 1
            }, 4000 );
        }

    });
    //弹出二维码
    $("#QRV_out").click(function () {
        $("#QRV").css("display","block");
    });
    $("#QRV").click(function () {
        $("#QRV").css("display","none");
    })
});