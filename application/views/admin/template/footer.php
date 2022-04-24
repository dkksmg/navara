  <style type="text/css">
footer {
    clear: both;
    position: relative;
    height: 50px;
    margin-top: 20px;
}
  </style>
  <!-- Main Footer -->
  <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
          CATDKK
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; <script>
          document.write(new Date().getFullYear())
          </script> <a href="#">DINAS KESEHATAN KOTA
              SEMARANG</a>.</strong> All rights reserved.
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="<?= base_url('assets/admin/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('assets/admin/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/admin/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- InputMask -->
  <script src="<?= base_url('assets/admin/') ?>plugins/moment/moment.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?= base_url('assets/admin/') ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url('assets/admin/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

  <!-- jquery-validation -->
  <script src="<?= base_url('assets/admin/') ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url('assets/admin/') ?>plugins/jquery-validation/additional-methods.min.js"></script>

  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?= base_url('assets/admin/') ?>dist/js/demo.js"></script> -->
  <script type="text/javascript">
$(document).ready(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    <?php if ($this->session->flashdata('success') != '') { ?>
    pesansukses('success', ' <?= $this->session->flashdata('success') ?>');
    <?php } ?>
    <?php if ($this->session->flashdata('warning') != '') { ?>
    pesansukses('warning', ' <?= $this->session->flashdata('warning') ?>');
    <?php } ?>
    <?php if ($this->session->flashdata('danger') != '') { ?>
    pesansukses('error', ' <?= $this->session->flashdata('danger') ?>');
    <?php } ?>

    function pesansukses(status, message) {
        console.log(status)
        Toast.fire({
            icon: status,
            title: message
        })
    }
});
  </script>
  <script>
$(function() {
    $('.example').DataTable({
        "scrollX": true,
        "paging": true,
        "pageLength": 25,
        "lengthMenu": [10, 25, 50, 100, 150, 200],
    });
    $('.example2').DataTable({});
});
  </script>
  <script>
$(document).ready(function() {
    $('.pilihtanggal').datepicker({
        dateFormat: 'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        yearRange: '1970:+20'
    });
});
  </script>
  <script type="text/javascript">
var rupiah = document.getElementById('rupiah');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, 'Rp. ');
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
  </script>
  <script>
$(".container-foto").css({
    'position': 'absolute',
    'top': '0px',
    'display': 'none',
    'width': '100%',
    'height': 'auto',
    // 'background': 'rgba(0,0,0,0.1)',
});

$(".popup").css({
    'position': 'relative',
    'top': '-250px',
    'left': '150px',
    'bottom': '150px',
    'width': '500px',
    'margin': 'auto',
    'border': '10px solid grey',
    'z-index': '10000',
    'background': 'white'
});

$("#close").css({
    'position': 'absolute',
    'top': '-15px',
    'right': '-15px',
    'font-size': '20px'
});
// Show

$(".gallery img").click(function() {

    $(".container-foto").fadeIn("slow");

    var url = $(this).attr('src');

    $(".imageShow").html('<img src="' + url + '">');

    $(".imageShow img").css({
        'width': '100%'
    });
})
// Close

$("#close").click(function() {
    $(".container-foto").fadeOut("slow");
})
  </script>
  </body>

  </html>