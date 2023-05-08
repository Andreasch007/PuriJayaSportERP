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

    <!--  -->
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="dob">DOB</label>
                            <input type="date" name="dob" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save">Save</button>
                        <button type="button" class="btn btn-primary btn-update">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<!--  -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" defer></script>
<script type="text/javascript">
$(function () {
    var id = <?php echo json_encode($field['id']); ?>;
    var columns = <?php echo json_encode($field['columns']); ?>;

    // $.noConflict();
    var token = '';
    var modal = $('.modal');
    var form = $('.form');
    var btnAdd = $('.add'),
        btnSave = $('.btn-save'),
        btnUpdate = $('.btn-update');
   
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
    };

    btnAdd.click(function(){
        modal.modal();
        form.trigger('reset');
        modal.find('.modal-title').text('Add New');
        btnSave.show();
        btnUpdate.hide();
    });

    
});
</script>
