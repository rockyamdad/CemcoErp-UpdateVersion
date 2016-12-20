<?php namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class BranchController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $branches = Branch::with('user')->paginate(10);
        return view('Branches.list',compact('branches'));
    }
    public function getAddbranch()
    {
        return view('Branches.add');
    }
    public function postSaveBranch()
    {
        $ruless = array(
            'name' => 'required',
            'location' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('branchAdd/')
                ->withErrors($validate);
        }
        else{
            $branch = new Branch();
            $this->setBranchData($branch);
            $branch->save();
            Session::flash('message', 'Branch has been Successfully Created.');
            return Redirect::to('branchList');
        }
    }
    public function getEdit($id)
    {
        $branch = Branch::find($id);
        return view('Branches.edit',compact('branch'));
    }
    public function postUpdate($id)
    {
        $ruless = array(
            'name' => 'required',
            'location' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('branch/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $branch = Branch::find($id);
            $this->setBranchData($branch);
            $branch->save();
            Session::flash('message', 'Branch has been Successfully Updated.');
            return Redirect::to('branchList/');
        }
    }
    public function getChangeStatus($status,$id)
    {
        $branch = Branch::find($id);
        if($branch['status'] == $status) {
            $branch->status = ($status == 'Activate' ? 'Deactivate': 'Activate');
            $branch->save();

        }
        return new JsonResponse(array(
            'id' => $branch['id'],
            'status' => $branch['status']
        ));
    }
    private function setBranchData($branch)
    {
        $branch->name = Input::get('name');
        $branch->location = Input::get('location');
        $branch->description = Input::get('description');
        $branch->user_id = Session::get('user_id');
        $branch->status = "Activate";
    }
}