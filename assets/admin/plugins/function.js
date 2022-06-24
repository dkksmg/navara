function deleteConfirm(url) {
  $("#btn-delete").attr("href", url);
  $("#deleteModal").modal();
}

function editConfirm(url) {
  $("#btn-edit").attr("href", url);
  $("#editModal").modal();
}

function saveConfirm(url) {
  $("#btn-save").attr("href", url);
  $("#saveModal").modal();
}

function logoutConfirm(url) {
  $("#btn-logout").attr("href", url);
  $("#logoutModal").modal();
}
function cetakConfirm(url) {
  $("#btn-cetak").attr("href", url);
  $("#cetakModal").modal();
}
function approveConfirm(url) {
  $("#btn-approve").attr("href", url);
  $("#approveModal").modal();
}
function rejectConfirm(url) {
  $("#btn-reject").attr("href", url);
  $("#rejectModal").modal();
}
function waitConfirm(url) {
  $("#btn-wait").attr("href", url);
  $("#waitModal").modal();
}
function disableBtn() {
  const d = new Date();
  let year = d.getFullYear();
  alert("Pagu kendaraan dinas Anda tahun " + year + " masih kosong. Silakan hubungi Admin.");
}
