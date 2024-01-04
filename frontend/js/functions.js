function removeAlerts() {
  window.setTimeout(function () {
    $(".alert").addClass("d-none").removeClass("alert-danger");
  }, 3000);
}

function setErrorAlert(message) {
  $(".alert").html(message).removeClass("d-none").addClass("alert-danger");
}

function setSuccessAlert(message) {
  $(".alert").html(message).removeClass("d-none").addClass("alert-success");
}
