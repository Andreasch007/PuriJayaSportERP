<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\PurchaseInvoice;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseInvoiceDetail;
use App\Http\Requests\PurchaseInvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PurchaseInvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PurchaseInvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PurchaseInvoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase-invoice');
        CRUD::setEntityNameStrings('purchase invoice', 'purchase invoices');
    }

    // public function index(Request $reques){
    //     if ($request->ajax()) {
    //         $data = PurchaseInvoiceDetail::select('*');
    //         return Datatables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
     
    //                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
    //                         return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //     }
        
    //     return view('users');
    // }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */

         CRUD::addColumns([
            [
                'name'=>'no_header',
                'label'=>'No. Dokumen',
                'type'=>'text'
            ],
            [
                'name'=>'date_header',
                'label'=>'Tanggal',
                'type'=>'date'
            ],
            [
                'name'=>'location',
                'label'=>'Lokasi',
                'type'=>'select',
                'entity'=>'location',
                'attribute'=>'loc_name'
            ],
            [
                'name'=>'supplier',
                'label'=>'Supplier',
                'type'=>'select',
                'entity'=>'supplier',
                'attribute'=>'nama_supplier'
            ],
            [
                'name'=>'flow_seq',
                'label'=>'Status',
                'type'=>'select2',
                'type'    => 'select_from_array',
                'options' => ['1' => 'New Entry', '10' => 'Posted'],
            ],
            [
                'name'=>'user',
                'label'=>'Pembuat',
                'type'=>'select',
                'entity'=>'user',
                'attribute'=>'name'
            ],
         ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PurchaseInvoiceRequest::class);

        // Belum bisa: Default pembuat muncul nama, Default date today
        // Belum selesai: No dokumen otomatis, Posting Unposting, Item Detail
        $user = Auth::user();
        $date = Carbon::now()->toDateString();
        // dd($user->id);
        CRUD::addFields([
            [
                'name'=>'user',
                'label'=>'Pembuat',
                'type'=>'text',
                'attributes' => [
                   'readonly' => 'readonly',
                ],
                'default'   => $user->name,
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'no_header',
                'label'=>'No. Dokumen',
                'type'=>'text',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
                'attributes' => [
                   'readonly' => 'readonly',
                ],
            ],
            [
                'name'=>'date_header',
                'label'=>'Tanggal',
                'type'=>'date',
                'default'=>$date,
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],[   // Hidden
                'name'  => 'spacer',
                'type'  => 'hidden',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'location',
                'label'=>'Lokasi',
                'type'=>'select2',
                'entity'=>'location',
                'attribute'=>'loc_name',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'supplier',
                'label'=>'Supplier',
                'type'=>'select2',
                'entity'=>'supplier',
                'attribute'=>'nama_supplier',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'detail',
                'label'=>'Details Item',
                'type'=>'datatable_detail',
                'id'=>0,
                'wrapper' => [
                    'class' => 'form-group col-md-12',
                ],
                'columns' => [
                    [
                        'label'=>'No.',
                        'name'=>'no',
                        'type'=>'text',
                        'priority'=>0,
                        'orderable'=>true,
                    ],
                    [
                        'label'=>'name',
                        'name'=>'name',
                        'type'=>'text',
                        'priority'=>1,
                        'orderable'=>true,
                    ],
                    [
                        'label'=>'qty',
                        'name'=>'qty',
                        'type'=>'text',
                        'priority'=>2,
                        'orderable'=>true,
                    ],
                    [
                        'label'=>'keterangan',
                        'name'=>'keterangan',
                        'type'=>'text',
                        'priority'=>3,
                        'orderable'=>true,
                    ],
                ]
            ],
         ]);
        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        // $this->setupCreateOperation();

        $id = request()->route('id');
        $user = 

        CRUD::addFields([
            [
                'name'=>'user',
                'label'=>'Pembuat',
                'type'=>'select',
                'attributes' => [
                   'readonly' => 'readonly',
                ],
                'entity'=>'user',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'no_header',
                'label'=>'No. Dokumen',
                'type'=>'text',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
                'attributes' => [
                   'readonly' => 'readonly',
                ],
            ],
            [
                'name'=>'date_header',
                'label'=>'Tanggal',
                'type'=>'date',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],[   // Hidden
                'name'  => 'spacer',
                'type'  => 'hidden',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'location',
                'label'=>'Lokasi',
                'type'=>'select2',
                'entity'=>'location',
                'attribute'=>'loc_name',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ],
            [
                'name'=>'supplier',
                'label'=>'Supplier',
                'type'=>'select2',
                'entity'=>'supplier',
                'attribute'=>'nama_supplier',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'detail',
                'label'=>'Details Item',
                'type'=>'datatable_detail',
                'id'=>$id,
                'wrapper' => [
                    'class' => 'form-group col-md-12',
                ],
                'columns' => [
                    [
                        'label' => 'No',
                        'data'  => 'DT_RowIndex',
                        'name'  => 'DT_RowIndex'
                    ],
                    [
                        'label' => 'ID',
                        'data'  => 'id',
                        'name'  => 'id',
                    ],
                    [
                        'label' => 'ID Header',
                        'data'  => 'id_header',
                        'name'  => 'id_header'
                    ],
                    [
                        'label' => 'Qty',
                        'data'  => 'qty',
                        'name'  => 'qty'
                    ],
                    [
                        'label' => 'ID Barang',
                        'data'  => 'id_barang',
                        'name'  => 'id_barang'
                    ],
                    [
                        'label' => 'Keterangan',
                        'data'  => 'keterangan',
                        'name'  => 'keterangan'
                    ],
                    [
                        'label' => 'Action',
                        'data'  => 'action',
                        'name'  => 'action'
                    ],

                ]
            ]
         ]);
        
    }
    
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;

        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }
    
    
    public function store(PurchaseInvoiceRequest $request)
    {
        $input = $request->all();
        // dd($input);

        $user = Auth::user();
        $PI = new PurchaseInvoice();
        $PI->user_id = $user->id;
        $PI->no_header = $input['no_header'];
        $PI->date_header = $input['date_header'];
        $PI->supplier_id = $input['supplier'];
        $PI->location_id = $input['location'];
        $PI->save();

        return redirect('purchase-invoice');
        // return redirect('member/'.$member->id.'/edit');
    }
    
    public function update(PurchaseInvoiceRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);

        $user = Auth::user();
        $PI = PurchaseInvoice::where('id', $id)->first();
        $PI->date_header = $input['date_header'];
        $PI->supplier_id = $input['supplier'];
        $PI->location_id = $input['location'];
        
        $PI->save();

        return redirect('member');
        // return redirect('member/'.$member->id.'/edit');
    }

    public function purchase_detail(Request $request, $id)
    {
        // dd($request->columns);
        // dd($id);
        
        if ($request->ajax()) {
            $data = PurchaseInvoiceDetail::where('id_header',$id)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
}
