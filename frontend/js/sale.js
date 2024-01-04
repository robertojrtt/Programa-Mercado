let table;
let edit = false;
let editing_id;
$(async function () {
  table = $("#saleid").DataTable({
    ajax: {
      url: "http://localhost:8080/api/sales",
      type: "GET",
      async: true,
      timeout: 30000,
      data: {},
      dataSrc: function (response) {
        return parseData(response); // Função para processar os dados
      },
    },
    columns: [
      { title: "Identificador" },
      { title: "Total" },
      { title: "Impostos" },
      { title: "Data" },
      { title: "Ação" },
    ],
    language: {
      search: "Pesquisar:",
      lengthMenu: "Mostrar _MENU_ por página",
    },
  });
});
function parseData(dados) {
  table.clear().draw();
  var lines = Array();
  dados.forEach(function (object, key) {
    //console.log(object);
    lines[key] = [
      object.id,
      object.amount,
      object.tax_amount,
      object.date,
      '<i class="bi bi-eye"></i> &nbsp; <i class="bi bi-trash"></i>',
    ];
  });
  return lines;
}
