$(function () {
    "use strict";
    var mainApp = {
        initFunction: function () {
            var run= new Array();
                $("#pic-month tr:gt(0)").each(function(){
                    var tr=$(this);
                    var Info={
                        period:tr.find("td").eq(0).text(),
                        num:tr.find("td").eq(1).text(),
                        run:tr.find("td").eq(2).text()
                    };
                    run.push(Info);
                });

            /* MORRIS AREA CHART
             ----------------------------------------*/
            Morris.Area({
                element: 'morris-line-chart-month',
                data:run,
                xkey: 'period',
                ykeys:  ['num','run'],
                labels: ['打卡次数','此月跑量'],
                lineColors:[ '#9440ed','#edc240'],
                smooth:true,
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                parseTime: false
            });
        },

        initialization: function () {
            mainApp.initFunction();

        }
    };
    // Initializing
    $(document).ready(function () {
        mainApp.initFunction();
    });


});
