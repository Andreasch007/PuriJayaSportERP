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
                        @if($col['type']!='hidden')
                            <th>{!! $col['label'] !!}</th>
                        @endif
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
                    <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">      
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="product_id form-control" style="width:100%" name="product_id" id="product_id"></select>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-12 control-label">Barang</label>
                            <div class="col-sm-12"> -->
                                <input type="hidden" class="form-control" style="width:100%" name="product_name" id="product_name">
                            <!-- </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Qty</label>
                            <div class="col-sm-6">
                                <input type="number" id="qty" name="qty" required="" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-sm-2 control-label">Harga</label>
                            <div class="col-sm-6">
                                <input type="text" id="harga" required="" class="form-control" name="harga"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Discount</label>
                            <div class="col-sm-12">
                                <input type="text" id="discount" name="discount" required="" class="form-control">
                            </div>
                        </div>
          
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea id="detail" name="keterangan" required="" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10" style="display: flex;">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                            <button type="cancel" class="btn btn-secondary" id="cancelBtn" value="cancel" style="margin-left:10px;">Cancel</button>
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
    var allColumns = <?php echo json_encode($field['columns']); ?>;
    console.log(allColumns);
    var columns = allColumns.filter((data) => {
        return data.type == 'show';
    });
    var harga = $('#harga')[0];
    var discount = $('#discount')[0];
    
    harga.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        harga.value = formatRupiah(this.value, 'Rp. ');
    });

    discount.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        discount.value = formatRupiah(this.value, 'Rp. ');
    });

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
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });

    $('#saveBtn').click((e) =>{
        
        let dataCreate = {}
        const modal = document.querySelector('.modal-body');
        const form = modal.querySelectorAll('input, textarea, select');
        
        form.forEach((el,index) => {
            dataCreate[el.name] = el.value
        });
        console.log(dataCreate);
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#productForm').serialize(),
            url: "",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#productForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');
            }
        });
    });

    //cancel button in modal
    $('#cancelBtn').click(function (e) {
        // e.preventDefault();
        $('#ajaxModel').modal('hide');
    });
    //emd of cancel button in modal

    //select option for product
    $('.product_id').select2({
        placeholder: 'Select an item',
        ajax: {
            url: "{{ url('picker-master-product') }}",
            dataType: 'json',
            delay: 250,
            data: function (data) {
                return {
                    searchTerm: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });

    $('#product_id').change(()=>{
        var selectedProductName = $(this).find('option:selected').text()
        $('#product_name').val(selectedProductName)
    });
    //end of select option product
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>
