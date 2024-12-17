(function () {
    const topProducts = $("#topSoldProducts");
    if (topProducts.length > 0) {
        initializeDataTable(topProducts)

        $('#applyDates').on('click', () => {
            initializeDataTable(topProducts)
        })
    }
})()

function initializeDataTable(topProducts) {
    if ($.fn.dataTable.isDataTable('#topSoldProducts')) {
        topProducts.fnDestroy();
    }
    topProducts.dataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/dashboard/reports/top-products",
            type: "GET",
            data: {
                from: $("#start-date").val(),
                to: $("#end-date").val()
            }
        },
        columns: [
            {data: "index"},
            {data: "title"},
            {data: "slug"},
            {data: "total_amount"},
        ],
        aoColumns: [
            {"mDataProp": "index"},
            {"mDataProp": "title"},
            {"mDataProp": "slug"},
            { "mDataProp": (data) => ('$' + data.total_amount.toFixed(2))},
        ],
        ordering: false,
        searching: false,
        paging: false,
        destroy: true,
        info: false
    })
}