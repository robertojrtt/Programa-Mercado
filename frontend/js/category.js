let table;
let edit = false;
let editing_id;
$(async function () {
  table = $("#categoyTable").DataTable({
    ajax: {
      url: "http://localhost:8080/api/categories",
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
      { title: "Nome" },
      { title: "Impostos" },
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
      object.title,
      object.tax + "%",
      '<i class="bi bi-pen" onclick="edit_it(this)"></i> &nbsp; <i class="bi bi-trash" onclick="delete_it(this)"></i>',
    ];
  });
  return lines;
}

function edit_it(caller) {
  edit = true;
  let data = table.row($(caller).closest("tr")).data();

  console.log(caller, data);

  // limpaModal();
  // $("#vendedor_nome").val(data[1]);
  // $("#vendedor_equipe").val(data[2]);

  // editing_id = data[0];

  // $("#modal").modal();
}

function save() {
  let obj = {};
  obj.title = $("#title").val();
  obj.tax = $("#tax").val();

  if (edit) {
    update(obj);
  } else {
    create(obj);
  }
}

function create(obj) {
  removeAlerts();
  $.ajax({
    type: "POST",
    url: "http://localhost:8080/api/categories",
    async: true,
    timeout: 30000,
    data: JSON.stringify(obj),
    success: function (response) {
      console.info(response);
      setSuccessAlert(response.message);
      table.ajax.reload();
    },
    error: function (xhr, status, error) {
      console.error(xhr, status, error);
      setErrorAlert("Não foi possivel criar categoria.");
    },
    complete: function () {
      $("#categoryModal").modal("hide");
      removeAlerts();
    },
  });
}

function limpaModal() {
  $("#vendedor_nome").val("");
  $("#vendedor_equipe").val("");
}
