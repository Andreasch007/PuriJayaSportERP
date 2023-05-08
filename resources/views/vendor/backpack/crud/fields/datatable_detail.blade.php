<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-xs btn-primary float-right add">Tambah Barang</button>
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    @foreach($field['columns'] as $col)
                        <th>{!! $col['label'] !!}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" defer></script>
<script type="text/javascript">
$(function () {
    var id = <?php echo json_encode($field['id']); ?>;
    var columns = <?php echo json_encode($field['columns']); ?>;
   
    if(id>0) // bukan tipe create
    {
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "http://localhost/PuriJayaSportERP/public/purchase-invoice/list/"+id,
            columns: columns
            // columns: [
            //     {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //     {data: 'id', name: 'id'},
            //     {data: 'id_header', name: 'id_header'},
            //     {data: 'qty', name: 'qty'},
            //     {data: 'id_barang', name: 'id_barang'},
            //     {data: 'keterangan', name: 'keterangan'},
            //     {
            //         data: 'action', 
            //         name: 'action', 
            //         orderable: true, 
            //         searchable: true
            //     },
            // ],
        });
    }
});
</script>