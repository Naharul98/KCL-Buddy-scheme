<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Staff_Area\CRUDContoller;
use App\Interest as Interest;

/*
|-----------------------------------------------------------------------------------
| Interests Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for managing CRUD operations of Interests
|
*/
class InterestsController extends CRUDController
{
    //path of the view for create operations
    protected $createView='staff_area/interests/create';
    //path of the view for update operations
    protected $updateView='staff_area/interests/update';
    //path of the view for delete operations
    protected $deleteView='staff_area/interests/delete';    
    //path of the view for redirections after CRUD operations
    protected $redirectView='/staff_area/interests/index';
    //primary key attribute name
    protected $primaryKey = 'interest_id';
    
    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * returns view for browsing a list of existing Interests
     * Passes in necessary data to the view
     * 
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        $data=[];
        $data['interests']=$this->getFilteredInterestsList($request);
        $data['filterFormData'] = $this->getFilterFormPrefillData($request);
        return view('staff_area/interests/index', $data);
    }

    /**
     * Create an instance of the Interest model and returns it
     *
     * @return Interest
     */
    protected function getModel()
    {
        return new Interest;
    }

    /**
     * Get filtered admin list according to search query
     *
     * @param Request $filterRequest
     * @return collection of Interest Objects
     */
    private function getFilteredInterestsList($filterRequest)
    {
        return ($filterRequest->input('interest_name') != "") ? 
        $this->getModel()->getInterestCollectionAccordingToNameFilter($filterRequest->input('interest_name')) 
        : 
        Interest::all();
    }

    /**
     * get data filter form prepopulation data for page reload
     * in the form of an associative array
     *
     * @param Request $request
     * @return array
     */
    private function getFilterFormPrefillData($request)
    {
        $formFilterSelections = array("interest_name"=>"");
        if($request->isMethod('post'))
        { 
          $formFilterSelections['interest_name'] = $request->input('interest_name');
        }
        return $formFilterSelections;
    }

    /**
     * Override
     * validates form data upon submission
     * @param Request $request
     */
    protected function validateForm($request){}

    /**
     * Override
     * Executes CREATE operations for the Interest model/table in database
     * @param Request $request
     */ 
    protected function createEntry($request)
    {
      $this->getModel()->create(['interest_name' => $request->input('interest_name')]);
    }

    /**
     * Override
     * Executes Update operations for a user in database
     * takes the primary key of the user data on which the operation is to be done
     * @param Request $request int $id
     * @return void
     */ 
    protected function updateEntry($request, $id)
    {
      $this->getModel()->find($id)->update(['interest_name' => $request->input('interest_name')]); 
    }


}
