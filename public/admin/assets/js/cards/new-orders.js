(function() {
    const newOrders = $("#newOrders");
    if (newOrders.length > 0) {
        newOrders.dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/dashboard/orders/new",
                type: "GET"
            },
            columns: [
                {data: "product"},
                {data: "created_at"},
            ],
            aoColumns: [
                {"mDataProp": "product"},
                {"mDataProp": (data) => {
                        return moment(data.created_at).format('YYYY/MM/DD hh:mm:ss a')
                    }
                },
            ],
            language: {
                infoFiltered: ''
            },
            searching: false,
            ordering: false,
            destroy: true,
            fnDrawCallback: function () {
                const rows = $('#newOrders tbody tr');
                rows.css({'cursor': 'pointer'})
                rows.click(function () {
                    const position = newOrders.fnGetPosition(this)
                    const id = newOrders.fnGetData(position)['id']

                    document.location.href = '/dashboard/orders/edit/' + id
                })
            }
        })
    }
})()