<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\Auth;
use App\Models\StockAdjustmentDetail;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StockAdjustmentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StockAdjustmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StockAdjustmentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\StockAdjustment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stock-adjustment');
        CRUD::setEntityNameStrings('Penyesuaian Stok', 'penyesuaian stok');
    }

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
        CRUD::setValidation(StockAdjustmentRequest::class);

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
                'name'      => 'stock_adjustment_detail',
                'label'     => 'Product',
                'type'      => 'repeatable_stock_adjustment_detail',
                'init_rows' => 0,
                'fields'    => [
                    [
                        'name'     => 'idx',
                        'label' => 'No',
                        'attributes' =>  [
                            'readonly'=>'readonly',
                        ],
                        'wrapperAttributes' => [
                            'class' => 'increment-detail form-group col-md-2',
                        ],
                    ],
                    [
                        'label' => 'Product',
                        'type'  => 'select2',
                        'name' => 'id_product',
                        'entity' => 'stockadjustmentdetail.product',
                        'model' => "App\Models\Product",
                        'attribute' => 'full_name',
                        'placeholder' => 'Select a Product',
                        'options' => (function($input){
                            return $input->select(DB::raw('CONCAT(product_code," :: ",product_name) as full_name'),'products.id','products.product_price')
                                    ->get();
                        }),
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-5'
                        ]
                    ],
                    [
                        'label' => 'Qty',
                        'type'  => 'number',
                        'name'  => 'qty',
                        'attributes' => [
                            'class' => 'form-control qty'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-2'
                        ]
                    ],
                    [
                        'label' => 'Harga',
                        'type'  => 'number',
                        'name'  => 'price',
                        'default' => 0,
                        'attributes' => [
                            'class' => 'form-control harga_unit'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-2'
                        ]
                    ],
                    [  
                        'label' => 'Total Harga',
                        'name'  => 'total_price',
                        'type'  => 'number',
						'default' => 0,
                        'attributes' => [
                            'class' => 'form-control total_harga'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-2'
                        ],
                    ],
                    [  
                        'label' => 'Keterangan',
                        'name'  => 'keterangan',
                        'type'  => 'text',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ],
                ],
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
                'name'      => 'pi_details',
                'label'     => 'Product',
                'type'      => 'repeatable_pi_detail',
                'init_rows' => 0,
                'fields'    => [
                    [
                        'name'     => 'idx',
                        'label' => 'No',
                        'attributes' =>  [
                            'readonly'=>'readonly',
                        ],
                        'wrapperAttributes' => [
                            'class' => 'increment-detail form-group col-md-2',
                        ],
                    ],
                    [
                        'label' => 'Product',
                        'type'  => 'select2_pi_detail',
                        'name' => 'id_product',
                        'entity' => 'stockadjustmentdetail.product',
                        'model' => "App\Models\Product",
                        'attribute' => 'full_name',
                        'placeholder' => 'Select a Product',
                        'options' => (function($input){
                            return $input->select(DB::raw('CONCAT(product_code," :: ",product_name) as full_name'),'products.id','products.product_price')
                                    ->get();
                        }),
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-5'
                        ]
                    ],
                    [
                        'label' => 'Qty',
                        'type'  => 'number',
                        'name'  => 'qty',
                        'attributes' => [
                            'class' => 'form-control qty'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-2'
                        ]
                    ],
                    [
                        'label' => 'Harga',
                        'type'  => 'number',
                        'name'  => 'price',
                        'default' => 0,
                        'attributes' => [
                            'class' => 'form-control harga_unit'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-2'
                        ]
                    ],
                    [  
                        'label' => 'Total Harga',
                        'name'  => 'total_price',
                        'type'  => 'number',
                        'default' => 0,
                        'attributes' => [
                            'class' => 'form-control total_harga'
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-2'
                        ],
                        // 'attributes' =>  [
                        //     'readonly'=>'readonly',
                        // ],
                    ],
                    [  
                        'label' => 'Keterangan',
                        'name'  => 'keterangan',
                        'type'  => 'text',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ],
                    [  
                        'label' => 'id',
                        'name'  => 'id',
                        'type'  => 'hidden',
                    ],
                ],
            ],
         ]);
    }

    
    public function store(StockAdjustmentRequest $request)
    {
        $input = $request->all();
        $pi_detail = json_decode($input['pi_details']);

        $user = Auth::user();
        $PI = new StockAdjustment();
        $PI->user_id = $user->id;
        $PI->no_header = $input['no_header'];
        $PI->date_header = $input['date_header'];
        $PI->location_id = $input['location'];
        $PI->save();

        if($pi_detail!=''){
            foreach($pi_detail as $pi_details){
                $details = new StockAdjustmentDetail();
                $details->id_product = $pi_details->id_product;
                $details->id_header = $PI->id;
                $details->qty =  $pi_details->qty;
                $details->price =  $pi_details->price;
                $details->keterangan = $pi_details->keterangan;
                $details->total_price = $pi_details->total_price;
                $details->save();
            }
        }
        return redirect('stock-adjustment');
        // return redirect('member/'.$member->id.'/edit');
    }
    
    public function update(StockAdjustmentRequest $request, $id)
    {
        $input = $request->all();
        $pi_detail = json_decode($input['pi_details']);
        // dd($pi_detail);
        $user = Auth::user();
        $PI = StockAdjustment::where('id', $id)->first();
        $PI->date_header = $input['date_header'];
        $PI->location_id = $input['location'];
        $PI->save();

        if(empty($pi_detail)){
            StockAdjustmentDetail::where('id_header',$PI->id)->delete();
        }
		
        if($pi_detail!=''){
			$lengthoption=count($pi_detail);
			$j=0;
			$pidetail_id = array();
			while($j<$lengthoption){
				$pidetail_id[]=$pi_detail[$j]->id;
				$j++;
			}
            foreach($pi_detail as $pi_details){
				$delete = StockAdjustmentDetail::whereNotIn('id',$pidetail_id)->where('id_header',$PI->id)->delete();
				if($pi_details->id==0){
					$details = new StockAdjustmentDetail();
                    $details->id_product = $pi_details->id_product;
                    $details->id_header = $PI->id;
                    $details->qty =  $pi_details->qty;
                    $details->price =  $pi_details->price;
                    $details->keterangan = $pi_details->keterangan;
                    $details->total_price = $pi_details->total_price;
                	$details->save();
				}else{
				    $details = StockAdjustmentDetail::where('id_header',$PI->id)->where('id',$pi_details->id)
					->update([
						'id_product' => $pi_details->id_product,
                        'id_header'  => $PI->id,
                        'qty'   => $pi_details->qty,
                        'price'   => $pi_details->price,
                        'keterangan'   => $pi_details->keterangan,
                        'total_price'   => $pi_details->total_price
					]);
				}
            }
        }

        return redirect('stock-adjustment');
        // return redirect('member/'.$member->id.'/edit');
    }

    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');
        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        $pi_details=DB::table('stock_adjustment_d as a')
                ->Join('stock_adjustment_h as b','a.id_header','b.id')
                ->Join('products as c','a.id_product','c.id')
                ->select('a.*') 
                ->where('b.id','=',$id)
                ->orderBy('a.id','ASC')
                ->get();    
        $u=$this->crud->getUpdateFields();
        $u['pi_details']['value'] = json_encode($pi_details);
        $this->data['entry'] = $this->crud->getEntry($id);
        // $u['contents']['fields'][1]['data_source'] = url('getcompany?company_id=' . $this->data['entry']->company_id);
        $this->crud->setOperationSetting('fields', $u);
        // get the info for that entry

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        // return url('getcompany?company_id=' . $this->data['entry']->company_id);
		return view($this->crud->getEditView(),$this->data);
    }   
}
