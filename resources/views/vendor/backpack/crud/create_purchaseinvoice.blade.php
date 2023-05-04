@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')

<div class="row">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif

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

	          @include('crud::inc.form_save_buttons')
		  </form>
	</div>
</div>

@endsection
