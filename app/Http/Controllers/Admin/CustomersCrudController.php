<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomersRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomersCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Customers::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customers');
        CRUD::setEntityNameStrings('customers', 'customers');
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
        // CRUD::column('customer_name');
        // CRUD::column('customer_contact');
        // CRUD::column('customer_address');
        CRUD::addColumns([
            [
                'label' =>  'Nama Pembeli',
                'name'  =>  'customer_name',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Kontak Pembeli',
                'name'  =>  'customer_contact',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Alamat Pembeli',
                'name'  =>  'customer_address',
                'type'  =>  'text'
            ],

        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomersRequest::class);

        // CRUD::field('id');
        // CRUD::field('customer_name');
        // CRUD::field('customer_contact');
        // CRUD::field('customer_address');
        CRUD::addFields([
            [
                'label' =>  'Nama Pembeli',
                'name'  =>  'customer_name',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Kontak Pembeli',
                'name'  =>  'customer_contact',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Alamat Pembeli',
                'name'  =>  'customer_address',
                'type'  =>  'text'
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
}
