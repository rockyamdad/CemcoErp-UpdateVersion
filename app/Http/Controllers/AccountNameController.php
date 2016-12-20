<?php namespace App\Http\Controllers;

use App\AccountCategory;

use App\Branch;
use App\NameOfAccount;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccountNameController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
       $accountNames = NameOfAccount::orderBy('id','DESC')->paginate(15);

        return view('AccountName.list',compact('accountNames'));
    }
    public function getCreate()
    {
        $accountCategories = new AccountCategory();
        $accountCategoriesAll = $accountCategories->getAccountCategoriesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('AccountName.add',compact('accountCategoriesAll'))
            ->with('branchAll',$branchAll);
    }
    public function postSaveAccountName()
    {
        $ruless = array(
            'name' => 'required',
            'account_category_id' => 'required',
            'branch_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('accountnames/index/')
                ->withErrors($validate);
        }
        else{
            $accountNames = new NameOfAccount();
            $this->setAccountNameData($accountNames);
            $accountNames->save();
            Session::flash('message', 'Account Name has been Successfully Created.');
            return Redirect::to('accountnames/index');
        }
    }
    public function getEdit($id)
    {
        $account = NameOfAccount::find($id);
        $accountCategories = new AccountCategory();
        $accountCategoriesAll = $accountCategories->getAccountCategoriesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('AccountName.edit',compact('account'))
            ->with('accountCategoriesAll',$accountCategoriesAll)
            ->with('branchAll',$branchAll);

    }
    public function postUpdate($id)
    {
        $ruless = array(
            'name' => 'required',
            'account_category_id' => 'required',
            'branch_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('accountnames/index/')
                ->withErrors($validate);
        }
        else{
            $accountNames = NameOfAccount::find($id);
            $this->setAccountNameData($accountNames);
            $accountNames->save();
            Session::flash('message', 'Account Name  has been Successfully Updated.');
            return Redirect::to('accountnames/index');
        }
    }

    private function setAccountNameData($accountNames)
    {
        $accountNames->name = Input::get('name');
        $accountNames->branch_id = Input::get('branch_id');
        $accountNames->account_category_id = Input::get('account_category_id');
        $accountNames->opening_balance = Input::get('opening_balance');
        $accountNames->user_id = Session::get('user_id');
    }
    public function getDelete($id)
    {
        $accountNames = NameOfAccount::find($id);
        $accountNames->delete();
        Session::flash('message', 'Account Name  has been Successfully Deleted.');
        return Redirect::to('accountnames/index');
    }

}