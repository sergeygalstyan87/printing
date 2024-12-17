window.onload = function () {
    if ($("#chartContainer").length > 0) {
        initializeMonthlyChart()

        $('#year').on('change', function() {
            initializeMonthlyChart()
        })
    }

    if ($("#chartContainerTax").length > 0) {
        initializeMonthlyChartForTax()

        $('#year_tax').on('change', function() {
            initializeMonthlyChartForTax()
        })
    }
}

function initializeMonthlyChart () {
    $("#chartContainer").html('Loading...');
    $.ajax({
        url:"/dashboard/reports/monthly",
        type: "GET",
        data: {
            year: $('#year').val()
        },
        success: function(data) {
            const chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Monthly Sales"
                },
                axisY: {
                    title: "Payment (in $)",
                    suffix: "$"
                },
                axisX: {
                    title: "Months"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.0#\"$\"",
                    dataPoints: data
                }]
            });
            chart.render();
        }
    })
}
function initializeMonthlyChartForTax () {
    $("#chartContainerTax").html('Loading...');
    $.ajax({
        url:"/dashboard/reports/monthly-tax",
        type: "GET",
        data: {
            year: $('#year_tax').val()
        },
        success: function(data) {
            const chart = new CanvasJS.Chart("chartContainerTax", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Monthly Tax"
                },
                axisY: {
                    title: "Tax (in $)",
                    suffix: "$"
                },
                axisX: {
                    title: "Months"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.0#\"$\"",
                    dataPoints: data
                }]
            });
            chart.render();
        }
    })
}