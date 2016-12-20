<?php namespace App\Http\Controllers;

use App\AccountCategory;
use App\BalanceTransfer;
use App\Branch;
use App\NameOfAccount;
use App\Party;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BalanceTransferController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
       $balanceTransfers = BalanceTransfer::orderBy('id','DESC')->paginate(15);
        return view('BalanceTransfers.list',compact('balanceTransfers'));
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $accountCategories = new AccountCategory();
        $accountCategoriesAll = $accountCategories->getAccountCategoriesDropDown();
        return view('BalanceTransfers.add')
            ->with('branchAll',$branchAll)
            ->with('accountCategoriesAll',$accountCategoriesAll);
    }
    public function getCategories($category_id)
    {
        $categoriesName = NameOfAccount::where('account_category_id','=',$category_id)
            ->where('branch_id','=',Input::get('data'))
            ->get();
        foreach ($categoriesName as $categoryName) {
            echo "<option value = $categoryName->id > $categoryName->name</option> ";
        }
    }
    public function getAccountbalance($account_id)
    {
        $accountBalance = NameOfAccount::find($account_id);
        echo "<p3 style='color: blue;font-size: 150%'>Your Current Balance $accountBalance->opening_balance</p3>";
    }
    public function postSaveTransfer()
    {
        $ruless = array(
            'from_branch_id' => 'required',
            'from_account_category_id' => 'required',
            'from_account_name_id' => 'required',
            'to_branch_id' => 'required',
            'to_account_category_id' => 'required',
            'to_account_name_id' => 'required',
            'amount' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('balancetransfers/create/')
                ->withErrors($validate);
        }
        else{
            $transfer = new BalanceTransfer();
            $this->setTransferData($transfer);

            Session::flash('message', 'Balance Transfer has been Successfully Done.');
            return Redirect::to('balancetransfers/index');
        }
    }

    private function setTransferData($transfer)
    {
        $transfer->from_branch_id = Input::get('from_branch_id');
        $transfer->from_account_category_id = Input::get('from_account_category_id');
        $transfer->from_account_name_id = Input::get('from_account_name_id');
        $transfer->to_branch_id = Input::get('to_branch_id');
        $transfer->to_account_category_id = Input::get('to_account_category_id');
        $transfer->to_account_name_id = Input::get('to_account_name_id');
        $transfer->amount = Input::get('amount');
        $transfer->remarks = Input::get('remarks');
        $transfer->user_id = Session::get('user_id');

        $fromAccount = NameOfAccount::find(Input::get('from_account_name_id'));
        $fromAccount->opening_balance = $fromAccount->opening_balance - Input::get('amount');
        $toAccount = NameOfAccount::find(Input::get('to_account_name_id'));
        $toAccount->opening_balance = $toAccount->opening_balance + Input::get('amount');
        $fromAccount->save();
        $toAccount->save();
        $transfer->save();
    }
    public function getDelete($id)
    {
        $transfer = BalanceTransfer::find($id);
        $accountsFrom = NameOfAccount::find($transfer->from_account_name_id);
        $accountsFrom->opening_balance = $accountsFrom->opening_balance + $transfer->amount;

        $accountsTo = NameOfAccount::find($transfer->to_account_name_id);
        $accountsTo->opening_balance = $accountsTo->opening_balance - $transfer->amount;
        $accountsTo->save();
        $accountsFrom->save();
        $transfer->delete();

        Session::flash('message', 'Balance Transfer has been Successfully Deleted.');
        return Redirect::to('balancetransfers/index');
    }
}