
$(function () {
    "use strict";
    var mainApp = {
        initFunction: function () {
            var month= new Array();
            $("#pic-month tr:gt(0)").each(function(){
                var tr=$(this);
                var Info={
                    period:tr.find("td").eq(0).text(),
                    num:tr.find("td").eq(1).text(),
                    run:tr.find("td").eq(2).text()
                };
                month.push(Info);
            });
            var day= new Array();
            $("#pic-day tr:gt(0)").each(function(){
                var tr=$(this);
                var Info={
                    period:tr.find("td").eq(0).text(),
                    num:tr.find("td").eq(1).text(),
                    run:tr.find("td").eq(2).text()
                };
                day.push(Info);
            });
            /* MORRIS AREA CHART
             ----------------------------------------*/
            Morris.Area({
                element: 'morris-area-chart-month',
                data:month,
                xkey: 'period',
                ykeys:  ['num','run'],
                labels: ['打卡人数','此月跑量'],
                lineColors:[ '#9440ed','#edc240'],
                smooth:true,
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                parseTime: false
            });
            /* MORRIS LINE CHART
			----------------------------------------*/
            Morris.Line({
                element: 'morris-line-chart-day',
                data:  day,
                xkey: 'period',
                ykeys: ['num','run'],
                labels: ['打卡人数','今日跑量'],
                hideHover: 'auto',
                resize: true,
                smooth:true,
                pointSize: 2,
                parseTime: false,
                lineColors:['#7A92A3','#4da74d']

            });
        },

        initialization: function () {
            mainApp.initFunction();

        }
    };
    // Initializing ///
    $(document).ready(function () {
        mainApp.initFunction();
    });

});
