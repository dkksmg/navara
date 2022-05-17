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
<script src="<?= base_url('assets/admin/') ?>plugins/function.js"></script>

<!-- AdminLTE App -->
<script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= base_url('assets/admin/') ?>dist/js/demo.js"></script> -->
<script>
$(function() {
    $('.example').DataTable({
        stateSave: true,
        "scrollX": true,
        "paging": true,
        "pageLength": 50,
        "lengthMenu": [10, 25, 50, 100, 150, 200, 300],

    });
    $('.example2').DataTable({});
});
</script>
<script>
// window.print();
</script>

</body>

</html>