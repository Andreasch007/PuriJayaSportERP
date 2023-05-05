<div class="container mt-5">
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Header</th>
                <th>Qty</th>
                <th>ID Barang</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('purchase.detail') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'id_header', name: 'id_header'},
            {data: 'qty', name: 'qty'},
            {data: 'id_barang', name: 'id_barang'},
            {data: 'keterangan', name: 'keterangan'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
});
</script>