(function () {
    if ($("#categoriesChartContainer").length > 0) {
        initializePieChart()

        $('#applyDates').on('click', () => {
            initializePieChart()
        })
    }
})()

function initializePieChart() {
    $("#categoriesChartContainer").html('Loading...');
    $.ajax({
        url:"/dashboard/reports/top-categories",
        type: "GET",
        data: {
            from: $("#start-date").val(),
            to: $("#end-date").val()
        },
        success: function (response, status) {
            const dataPoints = response.data.map(el => ({
                label: el.name,
                y: el.amount ? (el.amount * 100 / response.total_amount).toFixed(2) : 0
            }));

            const chart = new CanvasJS.Chart("categoriesChartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                data: [{
                    type: "pie",
                    startAngle: 240,
                    yValueFormatString: "##0.00\"%\"",
                    indexLabel: "{label} {y}",
                    dataPoints
                }]
            });
            chart.render();
        }
    })
}