<?php namespace App\Http\Controllers;

use App\Party;
use App\ProformaInvoice;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class PartyController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
       $parties = Party::orderBy('id','DESC')->paginate(15);
        return view('Parties.list',compact('parties'));
    }
    public function getCreate()
    {
        return view('Parties.add');
    }
    public function postSaveParty()
    {
        $ruless = array(
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('parties/create/')
                ->withErrors($validate);
        }
        else{
            $party = new Party();
            $this->setPartyData($party);
            $party->save();
            Session::flash('message', 'Party has been Successfully Created.');
            return Redirect::to('parties/index');
        }
    }
    public function getEdit($id)
    {
        $party = Party::find($id);
        return view('Parties.edit',compact('party'));
    }
    public function postUpdate($id)
    {
        $ruless = array(
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('parties/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $party = Party::find($id);
            $this->setPartyData($party);
            $party->save();
            Session::flash('message', 'Party has been Successfully Updated.');
            return Redirect::to('parties/index');
        }
    }
    public function getChangeStatus($status,$id)
    {
        $party = Party::find($id);
        if($party['status'] == $status) {
            $party->status = ($status == 'Activate' ? 'Deactivate': 'Activate');
            $party->save();

        }
        return new JsonResponse(array(
            'id' => $party['id'],
            'status' => $party['status']
        ));
    }
    private function setPartyData($party)
    {
        $party->name = Input::get('name');
        $party->type = Input::get('type');
        $party->contact_person_name = Input::get('contact_person_name');
        $party->email = Input::get('email');
        $party->phone = Input::get('phone');
        $party->address = Input::get('address');
        $party->user_id = Session::get('user_id');
        $party->status = "Activate";
    }

}