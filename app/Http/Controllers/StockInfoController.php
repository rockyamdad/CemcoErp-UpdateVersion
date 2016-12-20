<?php namespace App\Http\Controllers;

use App\Branch;
use App\StockInfo;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockInfoController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $stockInfos = StockInfo::orderBy('id','DESC')->paginate(15);
        return view('StockInfos.list',compact('stockInfos'));
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('StockInfos.add',compact('branchAll'));
    }
    public function postSaveStockInfo()
    {

        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('stockInfos/create/')
                ->withErrors($validate);
        }
        else{
            $stockInfo = new StockInfo();
            $this->setStockInfoData($stockInfo);
            $stockInfo->save();
            Session::flash('message', 'Stock Info has been Successfully Created.');
            return Redirect::to('stockInfos/index');
        }
    }
    public function getEdit($id)
    {
        $stockInfo = StockInfo::find($id);
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('StockInfos.edit',compact('stockInfo'))
            ->with('branchAll',$branchAll);
    }
    public function postUpdate($id)
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',

        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('stockInfos/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $stockInfo = StockInfo::find($id);
            $this->setStockInfoData($stockInfo);
            $stockInfo->save();
            Session::flash('message', 'Stock Infos has been Successfully Updated.');
            return Redirect::to('stockInfos/index');
        }
    }
    public function getChangeStatus($status,$id)
    {
        $stockInfo = StockInfo::find($id);
        if($stockInfo['status'] == $status) {
            $stockInfo->status = ($status == 'Activate' ? 'Deactivate': 'Activate');
            $stockInfo->save();

        }
        return new JsonResponse(array(
            'id' => $stockInfo['id'],
            'status' => $stockInfo['status']
        ));
    }
    private function setStockInfoData($party)
    {
        $party->name = Input::get('name');
        $party->branch_id = Input::get('branch_id');
        $party->location = Input::get('location');
        $party->user_id = Session::get('user_id');
        $party->status = "Activate";
    }

}