<script>
$(document).ready(function() {
  // Setup - add a text input to each footer cell
  $('#peralatan thead th').each(function() {
    var title = $(this).text();
    if (title != 'No' && title != 'Aksi' && title != '') {
      $(this).html(title + '<input type="text" style="width:120px;" placeholder=" ' + title +
        '" />');
    }
  });

  // DataTable
  var table = $('#peralatan').DataTable({
    "scrollX": true,
    "paging": true,
    // "stateSave": true,
    "pageLength": 25,
    "order": [
      [0, 'asc']
    ],
    "lengthMenu": [
      [10, 25, 50, 100, 200, -1],
      ['10', '25', '50', '100', '200', 'Show all']
    ],
    "ajax": {
      "url": "<?php echo site_url('ajax/peralatanall') ?>",
      "type": "POST"
    },
    "columnDefs": [{
      "targets": [0, 1, 2, ], //first column / numbering column
      "orderable": false, //set not orderable
    }, ],
  });
  table.columns().every(function() {
    var that = this;

    $('input', this.header()).on('keyup change', function() {
      if (that.search() !== this.value) {
        that
          .search(this.value)
          .draw();
      }
    });
  });
});
</script>