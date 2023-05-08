<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('id');
        // CRUD::column('barcode');
        // CRUD::column('product_code');
        // CRUD::column('product_name');
        // CRUD::column('category_id');
        // CRUD::column('sub_category_id');
        // CRUD::column('product_price');
        // CRUD::column('unit');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');
        CRUD::addColumns([
            [
                'label' =>  'ID',
                'name'  =>  'id',
                'type'  =>  'number'
            ],
            [
                'label' =>  'Barcode',
                'name'  =>  'barcode',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Product Code',
                'name'  =>  'product_code',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Name',
                'name'  =>  'product_name',
                'type'  =>  'text'
            ],
            [
                'label' => 'Category',
                'type'  => 'relationship',
                'name'  => 'category',
            ],
            [
                'label' => 'Sub Category',
                'type'  => 'relationship',
                'name'  => 'subCategory',
            ],
            [
                'label' =>  'Price',
                'name'  =>  'product_price',
                'type'  =>  'number'
            ],

        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::addColumns([
            [
                'label' =>  'ID',
                'name'  =>  'id',
                'type'  =>  'number'
            ],
            [
                'label' =>  'Barcode',
                'name'  =>  'barcode',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Product Code',
                'name'  =>  'product_code',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Name',
                'name'  =>  'product_name',
                'type'  =>  'text'
            ],
            [
                'label' => 'Category',
                'type'  => 'relationship',
                'name'  => 'category',
            ],
            [
                'label' => 'Sub Category',
                'type'  => 'relationship',
                'name'  => 'subCategory',
            ],
            [
                'label' =>  'Price',
                'name'  =>  'product_price',
                'type'  =>  'number'
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
        CRUD::setValidation(ProductRequest::class);

        // CRUD::field('id');
        // CRUD::field('barcode');
        // CRUD::field('product_code');
        // CRUD::field('product_name');
        // CRUD::field('category_id');
        // CRUD::field('sub_category_id');
        // CRUD::field('product_price');
        // CRUD::field('unit');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');
        CRUD::addFields([
            [
                'label' =>  'Barcode',
                'name'  =>  'barcode',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Product Code',
                'name'  =>  'product_code',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Name',
                'name'  =>  'product_name',
                'type'  =>  'text'
            ],
            [
                'label'     => "Category",
                'type'      => 'select2',
                'name'      => 'category_id', // the db column for the foreign key

                // optional
                'entity'    => 'category', // the method that defines the relationship in your Model
                'model'     => "App\Models\Category", // foreign key model
                'attribute' => 'category_name', // foreign key attribute that is shown to user
            ],
            [
                'label'     => "Sub Category",
                'type'      => 'select2',
                'name'      => 'sub_category_id', // the db column for the foreign key

                // optional
                'entity'    => 'subCategory', // the method that defines the relationship in your Model
                'model'     => "App\Models\SubCategory", // foreign key model
                'attribute' => 'sub_category_name', // foreign key attribute that is shown to user
            ],
            [
                'label' =>  'Price',
                'name'  =>  'product_price',
                'type'  =>  'number'
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
        $this->setupCreateOperation();
    }

    public function picker(Request $request)
    {
        // dd($request->searchTerm);

        $product_all = Product::select('id',DB::RAW("CONCAT(product_code,' :: ',product_name) as text"))
        ->where('product_name','like','%'.$request->searchTerm.'%')
        ->get();

        // dd($product_all);

        return json_encode($product_all);
    }
}
