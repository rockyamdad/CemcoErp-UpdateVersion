<?php namespace App\Http\Controllers;

use App\AccountCategory;


use App\Branch;
use App\Expense;
use App\NameOfAccount;
use App\Party;
use App\Product;
use App\PurchaseInvoice;
use App\PurchaseInvoiceDetail;
use App\Transaction;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChequeRegisterController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $register = Transaction::where('payment_method','=','check')
            ->where('type','=','Receive')
            ->orderBy('id', 'desc')
            ->paginate(15);
        $type = 'Payee';
        return view('ChequeRegister.list',compact('register', 'type'));
    }

    public function getPurchase()
    {
        $register = Transaction::where('payment_method','=','check')
            ->where('type','=','Payment')
            ->orwhere('type','=','Expense')
            ->where('payment_method','=','check')
            ->orderBy('id', 'desc')
            ->paginate(15);
        $type = 'Payer';
        return view('ChequeRegister.purchaselist',compact('register', 'type'));
    }

    public function getComplete($id)
    {
        $register2 = Transaction::find($id);
        $register2->cheque_status = 1;
        $register2->save();

        $register = Transaction::where('payment_method','=','check')
            ->where('type','=','Receive')
            ->orderBy('id', 'desc')
            ->get();
        return view('ChequeRegister.list',compact('register'));
    }
    public function getComplete2($id)
    {
        $register2 = Transaction::find($id);
        $register2->cheque_status = 1;

        if ($register2->payment_method == "Check") {
            if($register2->cheque_date == '') {
                $register2->cheque_date = date("m/d/Y", time());
            }
            $accountPayment = NameOfAccount::find($register2->account_name_id);
            $accountPayment->opening_balance = $accountPayment->opening_balance + $register2->amount;
            $accountPayment->save();
        }

        $register2->save();

        return  Redirect::to('dashboard');
    }

    public function getComplete3($id)
    {
        $register2 = Transaction::find($id);
        $register2->cheque_status = 1;

        if ($register2->payment_method == "Check") {
            if($register2->cheque_date == '') {
                $register2->cheque_date = date("m/d/Y", time());
            }
            $accountPayment = NameOfAccount::find($register2->account_name_id);
            $accountPayment->opening_balance = $accountPayment->opening_balance - $register2->amount;
            $accountPayment->save();
        }

        $register2->save();

        return  Redirect::to('dashboard');
    }

}