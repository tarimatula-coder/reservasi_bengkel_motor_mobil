<!-- JQUERY (WAJIB PERTAMA) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="../../templates_admin/assets/js/popper.min.js"></script>
<script src="../../templates_admin/assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<script src="../../templates_admin/assets/plugins/simplebar/js/simplebar.js"></script>
<script src="../../templates_admin/assets/js/sidebar-menu.js"></script>
<script src="../../templates_admin/assets/js/app-script.js"></script>

<!-- DataTables JS (HARUS SETELAH jQuery) -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        console.log("DataTable loaded:", $.fn.dataTable); // cek
        $('#datatable').DataTable();
    });
</script>