<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-xs btn-primary float-right add" id="createNewProduct" href="javascript:void(0)" >Tambah Barang</button>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">    
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>
         
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Details</label>
                            <div class="col-sm-12">
                                <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                            </div>
                        </div>
          
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
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

    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });

    
});
</script>
