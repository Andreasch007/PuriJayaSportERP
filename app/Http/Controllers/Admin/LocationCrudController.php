<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LocationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;

/**
 * Class LocationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LocationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Location::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/location');
        CRUD::setEntityNameStrings('location', 'locations');
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
                'label' =>  'Name',
                'name'  =>  'loc_name',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Address',
                'name'  =>  'loc_address',
                'type'  =>  'textarea'
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
		CRUD::addColumns([
            [
                'label' =>  'Name',
                'name'  =>  'loc_name',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Address',
                'name'  =>  'loc_address',
                'type'  =>  'textarea'
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
        CRUD::setValidation(LocationRequest::class);

        CRUD::addFields([
            [
                'label' =>  'Name',
                'name'  =>  'loc_name',
                'type'  =>  'text'
            ],
            [
                'label' =>  'Address',
                'name'  =>  'loc_address',
                'type'  =>  'textarea'
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
    public function store(LocationRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $location = new Location();
        $location->loc_name = $input['loc_name'];
        $location->loc_address = $input['loc_address'];
        $location->user_id = $user->id;
        $location->save();

 
        return redirect('location/'.$location->id.'/show');
    }

    public function update(LocationRequest $request,  $id)
    {
        $input = $request->all();
        $user = Auth::user();
        $location = Location::where('id',$id)->first();
        // $exam->exam_no = $input['exam_no'];
        $location->loc_name = $input['loc_name'];
        $location->loc_address = $input['loc_address'];
        $location->user_id = $user->id;
        $location->save(); 

        return redirect('location/'.$location->id.'/show');
    }
}
