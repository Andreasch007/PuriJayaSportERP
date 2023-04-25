<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubCategoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SubCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sub-category');
        CRUD::setEntityNameStrings('sub category', 'sub categories');
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
        // CRUD::column('category_id');
        // CRUD::column('sub_category_name');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        CRUD::addColumns(
            [
                [
                    'label' => 'Category',
                    'type'  => 'relationship',
                    'name'  => 'category',


                ],
                [
                    'label' => 'Sub Category',
                    'type'  => 'text',
                    'name'  => 'sub_category_name'
                ],

            ]
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubCategoryRequest::class);

        // CRUD::field('id');
        CRUD::addFields(
            [
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
                    'label' =>  'Sub Category',
                    'name'  =>  'sub_category_name',
                    'type'  =>  'text'
                ],
            ]

        );
        // CRUD::field('sub_category_name');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');

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
