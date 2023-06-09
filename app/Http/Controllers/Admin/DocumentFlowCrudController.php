<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DocumentFlowRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentFlowCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentFlowCrudController extends CrudController
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
        CRUD::setModel(\App\Models\DocumentFlow::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document-flow');
        CRUD::setEntityNameStrings('document flow', 'document flows');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'label' =>  'ID.',
                'name'  =>  'id',
                'type'  =>  'number'
            ],
            [
                'label' =>  'No.',
                'name'  =>  'doctype_no',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Deskripsi',
                'name'  =>  'doctype_desc',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Tgl. Pembuatan',
                'name'  =>  'created_at',
                'type'  =>  'date'
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
        CRUD::setValidation(DocumentFlowRequest::class);


        CRUD::addFields([
            [
                'label' =>  'ID.',
                'name'  =>  'id',
                'type'  =>  'number'
            ],
            [
                'label' =>  'No.',
                'name'  =>  'doctype_no',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Deskripsi',
                'name'  =>  'doctype_desc',
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
