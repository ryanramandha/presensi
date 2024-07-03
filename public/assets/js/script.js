$(document).ready(function () {
  let dt = $("#datatable").DataTable({
    responsive: true,
    lengthChange: true,
    info: true,
    oLanguage: {
      sSearch: "Cari : ",
      sLengthMenu: "_MENU_ &nbsp;&nbsp;data per halaman",
      sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
      sInfoEmpty: "",
      sInfoFiltered: "(difilter dari _MAX_ total data)",
      sZeroRecords: "Pencarian tidak ditemukan",
      sEmptyTable: "Tidak ada data",
    },
  });

  dt.on("order.dt search.dt", function () {
    dt.column(0, {
      search: "applied",
      order: "applied",
    })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
  }).draw();
});
