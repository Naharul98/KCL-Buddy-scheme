<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Staff_Area\CRUDContoller;
use App\Session as Session;
use App\AdminSession;
use App\Interest;
use App\SessionInterests;
use Auth;
/*
|-----------------------------------------------------------------------------------
| Sessions Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for managing CRUD operations of Sessions
|
*/
class SessionsController extends CRUDController
{
    //path of the view for create operations
    protected $createView='staff_area/sessions/create';
    //path of the view for update operations
    protected $updateView='staff_area/sessions/update';
    //path of the view for delete operations
    protected $deleteView='staff_area/sessions/delete';    
    //path of the view for redirections after CRUD operations
    protected $redirectView='/staff_area/sessions/index';
    //primary key attribute name
    protected $primaryKey = 'session_id';

    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
    public function __construct(Session $session)
    {
        $this->middleware(['auth', 'admin']);
    }
   /**
    * returns view for browsing a list of sessions
    * If superadmin - then he gets access to all sessions
    * if regular admin - then he gets access to sessions on which he is allocated
    *
    * @param Request $request
    * @return view
    */
    public function index(Request $request)
    {   
        $data = [];
        if(Auth::user()->role === "super_admin")
        {
            $data['sessions']= $this->getSessionFilteredForSuperAdmin($request);
        }
        else
        {
            $data['sessions']=$this->getSessionsListSpecificToAdminWithFilter(Auth::user()->id, $request);
        }

        ($request->isMethod('post')) ? $data['session_name_prepopulate']=$request->input('session_name') : $data['session_name_prepopulate'] = "";
        
        return view('staff_area/sessions/index',$data);
    }  

   /**
    * Get filtered Session list according to search query
    *
    * @param Request $request
    * @return collection of Session Objects
    */
    private function getSessionFilteredForSuperAdmin($request)
    {
        return ($request->input('session_name') != "") ? $this->getModel()->getSessionCollectionAccordingToNameFilter($request->input('session_name')) : Session::all();
    }

   /**
    * Create an instance of the AdminSession model and returns it
    *
    * @return AdminSession
    */
    protected function getAdminSessionModel()
    {
        return new AdminSession;
    }

   /**
    * Get only those sessions which are allocated to currently signed in admin
    * In addition, filter is applied according to the search query
    * @param Request $filterRequest, int $admin_id
    * @return collection of AdminSession Objects
    */
    private function getSessionsListSpecificToAdminWithFilter($admin_id, $filterRequest)
    {
        return $this->getAdminSessionModel()->getSessionsListSpecificToAdminWithFilter($admin_id, $filterRequest);
    }

   /**
    * Return custom registration link for a particular session
    * @param Request $request, int $session_id
    * @return custom registration link for the session id (String)
    */
    public function generateLink(Request $request, $session_id)
    {    
        return view('staff_area/sessions/generateLink')->with('session_id','/id='.$session_id);
    }

   /**
    * Create an instance of the Session model and returns it
    *
    * @return Session
    */
    protected function getModel()
    {
        return new Session;
    }

   /**
    * validates form data upon submission
    * @param Request $request
    */
    protected function validateForm($request)
    {
        $this->validate($request,['session_name' => 'required',]);
    }

   /**
    * Override
    * Executes CREATE operations for a Session in database
    * @param Request $request
    */ 
    protected function createEntry($request)
    {
        $session = new Session;
        $session->session_name = $request->input('session_name');
        $session->is_locked = $request->input('is_locked');
        $session->save();
        $this->addSessionInterestsToDatabase($request->input('interest_choices'),$session->session_id);
    }

   /**
    * Override
    * Executes Update operations for a Session in database
    * takes the primary key of the session on which the operation is to be done
    * @param Request $request int $id
    * @return void
    */ 
    protected function updateEntry($request, $id)
    {
        $this->clearSessionInterests($id);
        $this->getModel()
        ->find($id)
        ->update(['session_name' => $request->input('session_name'),'is_locked' => $request->input('is_locked')]);
        $this->addSessionInterestsToDatabase($request->input('interest_choices'),$id);
    }

   /**
    * Create an instance of the SessionInterests model and returns it
    *
    * @return SessionInterests
    */
    protected function getSessionInterestsModel()
    {
        return new SessionInterests;
    }

   /**
    * Takes an array of interest ids and allocates interests to a particular session
    * based on session id provided
    * @param array $arr, int $session_id
    * @return void
    */ 
    private function addSessionInterestsToDatabase($arr,$session_id)
    {
        $this->getSessionInterestsModel()->addSessionInterestsToDatabase($arr,$session_id);
    }

   /**
    * Takes a session id and clears all interests allocated to that session
    * @param int $session_id
    * @return void
    */ 
    private function clearSessionInterests($session_id)
    {
        $this->getSessionInterestsModel()->clearSessionInterests($session_id);
    }
    
   /**
    * Override
    * Takes primary key of the Session and adds data to pass into the views for the GET request
    * @return void
    * @param int $id
    */
    protected function handleUpdateGetRequest($id)
    {
        $this->data['entry']=$this->getModel()->find($id);        
        $this->data['interests']=Interest::all();  
        $this->data['interestsChosen']=$this->getPrepopulateSessionInterests($id);
    }
    
   /**
    * Override
    * Passes data in Session Create View
    * @return void
    */
    protected function handleCreateGetRequest()
    {     
        $this->data['interests']=Interest::all();  
    }

   /**
    * returns an array of integers containing interest ids allocated to session
    * based on the session id provided
    * @param int $id
    * @return array of interest ids
    */ 
    private function getPrepopulateSessionInterests($id)
    {
        return $this->getSessionInterestsModel()->getArrayOfInterestIdsAllocatedToSession($id);
    }

}
