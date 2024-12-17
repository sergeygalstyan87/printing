// Title: Demo code for jQuery Datatables
// Location: tables.data.html
// Dependency File(s):
// assets/vendor/datatables.net/js/jquery.dataTables.js
// assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js
// assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css
// -----------------------------------------------------------------------------

(function(window, document, $, undefined) {
  "use strict";
    $(function() {
      if($('#bs4-table').length > 0){
          $('#bs4-table').DataTable({ "ordering": false});
      }
      if($('#bs4-table_employees').length > 0){
          $('#bs4-table_employees').DataTable({ "ordering": false});
      }

    });

})(window, document, window.jQuery);
