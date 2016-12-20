<?php namespace App\Http\Controllers;

use App\Branch;
use App\Report;
use App\StockRequisition;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $users = User::orderBy('id','DESC')->paginate(15);
        return view('Users.list',compact('users'));
    }
    public function getDashboard()
    {

        $reports = new Report();
        $totalProducts = $reports->getTotalProducts();

        $totalImports = $reports->getTotalImports();
        $totalSales = $reports->getTotalSalesToday();
        $totalPurchase = $reports->getTotalPurchaseToday();
        $accountsBalance = $reports->getAccountBalances();
        $accountBalanceTransfers = $reports->getBalanceTransferFullReport();
        $stocksBranch = $reports->getStocksBranch();
        $stockRequisitions = StockRequisition::orderBy('id','desc')->take(3)->get();
        $latestTransactions = Transaction::orderBy('id','desc')->take(5)->get();;
        $register = Transaction::where('payment_method','=','check')
            ->where('type','=','Receive')
            ->where('cheque_status','=',0)
            ->orderBy('id', 'desc')
            ->get();
        $purchaseregister = Transaction::where('payment_method','=','check')
            ->where('type','=','Payment')
            ->where('cheque_status','=',0)
            ->orwhere('type','=','Expense')
            ->where('payment_method','=','check')
            ->where('cheque_status','=',0)
            ->orderBy('id', 'desc')
            ->get();
        //var_dump($stockRequisitions);
        return view('Users.dashboard')
            ->with('latestTransactions',$latestTransactions)
            ->with('totalProducts',$totalProducts)
            ->with('totalSales',$totalSales)
            ->with('stockRequisitions',$stockRequisitions)
            ->with('stocksBranch',$stocksBranch)
            ->with('accountsBalance',$accountsBalance)
            ->with('accountBalanceTransfers',$accountBalanceTransfers)
            ->with('totalPurchase',$totalPurchase)
            ->with('totalImports',$totalImports)
            ->with('register',$register)
            ->with('purchaseregister',$purchaseregister);
    }
    public function getChangePassword()
    {
        return view('Users.changePassword');

    }
    public function postChangePassword()
    {
        $ruless = array(
            'oldPassword'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('users/change-password')
                ->withErrors($validate);
        }
        else{
            $oldpass  = Input::get('oldPassword');
            $newpass = Input::get('password');
            $userid=Session::get('user_id');
            $uerInfo = User::find($userid);
            $userpass=$uerInfo->password;
            if(crypt($oldpass, $userpass) === $userpass)
            {
                $passw= Hash::make($newpass);
                $uerInfo->password=$passw;
                $uerInfo->save();
                Session::flash('message', 'Password has been Updated Successfully.');
            }
            else
            {
                Session::flash('message2', 'Old Password Does Not Match.');
            }

            return Redirect::to('users/change-password');
        }
    }
    public function getuserAdd()
    {
        $branches = new Branch();
       $branchAll = $branches->getBranchesDropDown();
        return view('Users.add',compact('branchAll'));
    }
    public function postSaveUser()
    {
        $ruless = array(
            'username' => 'required|Unique:users',
            'role' => 'required',
            'email' =>  'required|email|unique:users|Unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'sex' => 'required',
            'branch_id' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('add')
                ->withErrors($validate);
        }
        else{
            $user = new User();
            $this->setUserData($user);
            $user->save();
            Session::flash('message', 'User has been Successfully Created.');
            return Redirect::to('list/');
        }
    }
    public function getProfile()
    {
        $user = Session::get('user_id');
        $profile = User::find($user);

        return view('Users.profile',compact('profile'));
    }
    public function getEdit($id)
    {
        $users = User::find($id);
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('Users.edit',compact('branchAll'))
            ->with('userdata',$users);

    }
    public function putCheckupdate($id)
    {
        $ruless = array(
            'username' => 'required',
            'email' =>  'required|email|Unique:users,email,'.$id,
            'sex' => 'required',
            'branch_id' => 'required'

        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $user = User::find($id);
            $this->updateUserData($user);
            $user->save();
            Session::flash('message', 'User has been Successfully Updated.');
            return Redirect::to('list/');
        }
    }
    public function getChangeStatus($status,$id)
    {
        $user = User::find($id);
        if($user['status'] == $status) {
            $user->status = ($status == 'Activate' ? 'Deactivate': 'Activate');
            $user->save();

        }
        return new JsonResponse(array(
            'id' => $user['id'],
            'status' => $user['status']
        ));
    }
    private function setUserData($user)
    {
        $user->name  = Input::get('name');
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->phone = Input::get('phone');
        $user->address = Input::get('address');
        $user->role = Input::get('role');
        $user->sex = Input::get('sex');
        //$user->created_by = Session::get('user_id');
        $user->branch_id = Input::get('branch_id');
        $user->status = "Activate";
    }
    private function updateUserData($user)
    {
        $user->name  = Input::get('name');
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->phone = Input::get('phone');
        $user->address = Input::get('address');
        if(Session::get('user_role') == 'admin'){
            $user->role = Input::get('role');
        }

        $user->sex = Input::get('sex');
        $user->branch_id = Input::get('branch_id');
        $user->status = "Activate";
    }

}