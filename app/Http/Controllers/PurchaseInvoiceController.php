<?php namespace App\Http\Controllers;

use App\AccountCategory;


use App\Branch;
use App\NameOfAccount;
use App\Party;
use App\Product;
use App\PurchaseInvoice;
use App\PurchaseInvoiceDetail;
use App\StockCount;
use App\StockInfo;
use App\SubCategory;
use App\Transaction;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PurchaseInvoiceController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
       $purchases = PurchaseInvoice::orderBy('id','DESC')->paginate(15);
        $purchase = new PurchaseInvoice();
        $allInvoices = $purchase->getPurchaseInvoiceDropDown();
        $invoice = Input::get('invoice_id');
        $purchaseInvoice = PurchaseInvoice::where('invoice_id',$invoice)->get();
        return view('PurchaseInvoice.list',compact('purchases'))
            ->with('allInvoices',$allInvoices)
            ->with('purchaseInvoice',$purchaseInvoice);
    }
    public function getCreate()
    {
        $suppliers = new Party();
        $suppliersAll = $suppliers->getSuppliersDropDown();
        $products = new Product();
        $localProducts = $products->getLocalProductsDropDown();
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();

        // Invoice Id Generation Starts
        $invoiceid =$this->generateInvoiceId();
        //var_dump($invoiceid);
        // Invoice Id Generation Starts

        return view('PurchaseInvoice.add',compact('suppliersAll'))
            ->with('localProducts',$localProducts)
            ->with('branchAll',$branchAll)
            ->with('invoiceid',$invoiceid)
            ->with('allStockInfos',$allStockInfos);
    }
    public function postSavePurchaseInvoice()
    {
        $ruless = array(
            'branch_id' => 'required',
            'stock_info_id' => 'required',
            'product_type' => 'required',
            'party_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('purchases/index/')
                ->withErrors($validate);
        }
        else{
            $list = $this->setPurchaseInvoiceData();
            return new JsonResponse($list);

        }
    }

    private function generateInvoiceId()
    {
        $invdesc = PurchaseInvoice::orderBy('id', 'DESC')->first();
        if ($invdesc != null) {
            $invDescId = $invdesc->invoice_id;
            $invDescIdNo = substr($invDescId, 8);

            $subinv1 = substr($invDescId, 6);
            $dd = substr($invDescId, 1, 2);
            $mm = substr($invDescId, 3,2);
            $yy = substr($invDescId, 5, 2);
            //var_dump($invDescId." ".$dd." ".$mm." ".$yy);
            //echo "d1 ".$yy;


            $tz = 'Asia/Dhaka';
            $timestamp = time();
            $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $Today = $dt->format('d.m.Y');

            $explodToday = explode(".", $Today);
            $dd2 = $explodToday[0];
            $mm2 = $explodToday[1];
            $yy1 = $explodToday[2];
            $yy2 = substr($yy1, 2);
            //var_dump($dd2." ".$mm2." ".$yy2);


            if ($dd == $dd2 && $yy == $yy2 && $mm == $mm2) {
                $invoiceidd = "P".$dd2 . $mm2 . $yy2 . "-".($invDescIdNo + 1);
                //var_dump($invoiceidd);
                return $invoiceidd;
            } else {
                $invoiceidd = "P".$dd2 . $mm2 . $yy2 . "-1";
                return $invoiceidd;
            }
        } else {
            $tz = 'Asia/Dhaka';
            $timestamp = time();
            $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $Today = $dt->format('d.m.Y');

            $explodToday = explode(".", $Today);
            $mm2 = $explodToday[1];
            $dd2 = $explodToday[0];
            $yy1 = $explodToday[2];
            $yy2 = substr($yy1, 2);


            $invoiceidd = "P".$dd2 . $mm2 . $yy2 . "-1";
            //var_dump($invoiceidd);
            return $invoiceidd;
        }
    }

    public function postUpdate($id)
    {

        $ruless = array(
            'branch_id' => 'required',
            'stock_info_id' => 'required',
            'product_type' => 'required',
            'party_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('purchases/index/')
                ->withErrors($validate);
        }
        else{
            $list = $this->setPurchaseInvoiceData();
            return new JsonResponse($list);

        }
    }
    private function setPurchaseInvoiceData()
    {
        $purchases = new PurchaseInvoice();
        $purchaseDetails = new PurchaseInvoiceDetail();
        $purchaseDetails->quantity = Input::get('quantity');
        $purchaseDetails->price = Input::get('price');
        $purchaseDetails->detail_invoice_id = Input::get('invoice_id');
        $purchaseDetails->product_id = Input::get('product_id');
        $purchaseDetails->branch_id = Input::get('branch_id');
        $purchaseDetails->stock_info_id = Input::get('stock_info_id');
        $purchaseDetails->product_type = Input::get('product_type');
        $purchaseDetails->remarks = Input::get('remarks');
        $purchaseDetails->save();
        $hasInvoice = PurchaseInvoice::where('invoice_id','=',Input::get('invoice_id'))->get();
        if(empty($hasInvoice[0])){
            $purchases->party_id = Input::get('party_id');
            $purchases->status = "Activate";
            $purchases->invoice_id = \Input::get('invoice_id');
            $purchases->user_id = Session::get('user_id');
            $purchases->save();
        }

        $purchaseInvoiceDetails = PurchaseInvoiceDetail::find($purchaseDetails->id);
        $list = $this->purchaseInvoiceDetailConvertToArray($purchaseInvoiceDetails);
        return $list;
    }
    private function purchaseInvoiceDetailConvertToArray($purchaseInvoiceDetails)
    {
        $array = array();
        $stockName = StockInfo::find($purchaseInvoiceDetails->stock_info_id);
        $branchName = Branch::find($purchaseInvoiceDetails->branch_id);
        $array['id'] = $purchaseInvoiceDetails->id;
        $array['branch_id'] = $branchName->name;
        $array['stock_info_id'] = $stockName->name;
        $array['product_type'] = $purchaseInvoiceDetails->product_type;

        $categoryName = \App\Category::find($purchaseInvoiceDetails->product->category_id);
        $subCategoryName = \App\SubCategory::find($purchaseInvoiceDetails->product->sub_category_id);

        $array['product_id'] = $purchaseInvoiceDetails->product->name.'('.$categoryName->name.')'.'('.$subCategoryName->name.')';
        $array['price'] = $purchaseInvoiceDetails->price;
        $array['quantity']   = $purchaseInvoiceDetails->quantity;
        $array['remarks'] = $purchaseInvoiceDetails->remarks;
        return $array;
    }
    public function getDetails($invoiceId)
    {
        $purchaseInvoiceDetails = PurchaseInvoiceDetail::where('detail_invoice_id','=',$invoiceId)->get();
        $purchaseInvoiceTransactions = Transaction::where('invoice_id','=',$invoiceId)->get();
        $purchase = PurchaseInvoice::where('invoice_id','=',$invoiceId)->first();
        return view('PurchaseInvoice.details',compact('purchaseInvoiceDetails'))
            ->with('purchase',$purchase)
            ->with('purchaseInvoiceTransactions',$purchaseInvoiceTransactions);

    }
    public function getMake($invoice_id)
    {
        $accountCategories = new AccountCategory();
        $accountCategoriesAll = $accountCategories->getAccountCategoriesDropDown();
        $purchaseDetails = new PurchaseInvoiceDetail();
        $transactions = new Transaction();
        $purchaseDetailsAmount = $purchaseDetails->getTotalAmount($invoice_id);
        $transactionsPaid = $transactions->getTotalPaidPurchase($invoice_id);
        $due = $purchaseDetails->getPurchasedue($invoice_id);
        $purchaseDetailsBranch = PurchaseInvoiceDetail::where('detail_invoice_id','=',$invoice_id)->first();
        return view('PurchaseInvoice.paymentAdd',compact('accountCategoriesAll', 'due'))
            ->with('purchaseDetailsAmount',$purchaseDetailsAmount)
            ->with('invoice_id',$invoice_id)
            ->with('purchaseDetailsBranch',$purchaseDetailsBranch->branch_id)
            ->with('transactionsPaid',$transactionsPaid);
    }
    public function postSaveMake()
    {
        $ruless = array(
            'account_category_id' => 'required',
            'account_name_id' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('purchases/index/')
                ->withErrors($validate);
        }
        else{

            $transactionId = $this->setPurchasePayment();
            if ($transactionId > 0)
                return Redirect::to('purchases/voucher/'.$transactionId);
            else
                return Redirect::to('purchases/index');

        }
    }
    private function setPurchasePayment()
    {
        $accountPayment = NameOfAccount::find(Input::get('account_name_id'));
        if($accountPayment->opening_balance >= Input::get('amount')){


            $purchases = PurchaseInvoice::where('invoice_id','=',Input::get('invoice_id'))->first();
            $purchaseTransaction = new Transaction();
            $purchaseTransaction->account_category_id = Input::get('account_category_id');
            $purchaseTransaction->account_name_id = Input::get('account_name_id');
            $purchaseTransaction->amount = Input::get('amount');
            $purchaseTransaction->remarks = Input::get('remarks');
            $purchaseTransaction->user_id = Session::get('user_id');
            $purchaseTransaction->type = "Payment";
            $purchaseTransaction->payment_method = Input::get('payment_method');
            $purchaseTransaction->invoice_id = Input::get('invoice_id');
            $purchaseTransaction->cheque_no = Input::get('cheque_no');
            $purchaseTransaction->cheque_date=Input::get('cheque_date');
            $purchaseTransaction->cheque_bank=Input::get('cheque_bank');


            $totalAmount = 0;
            $totalPrice = 0;
            $purchaseDetails = PurchaseInvoiceDetail::where('detail_invoice_id','=',$purchaseTransaction->invoice_id)->get();
            $transactions = Transaction::where('invoice_id','=',$purchaseTransaction->invoice_id)->get();
            foreach($purchaseDetails as $purchaseDetail)
            {
                $totalPrice =$totalPrice + ($purchaseDetail->price * $purchaseDetail->quantity);
            }
            foreach($transactions as $transaction)
            {
                $totalAmount =$totalAmount + ($transaction->amount);
            }
            $purchaseInvoice = PurchaseInvoice::find( $purchases->id);
            if($totalAmount == $totalPrice)
            {
                $purchaseInvoice->status = "Completed";
            }else{
                $purchaseInvoice->status = "Partial";
            }


            if($purchaseTransaction->payment_method != "Check") {
                $accountPayment->opening_balance = $accountPayment->opening_balance - Input::get('amount');
                $accountPayment->save();
            }

            $purchaseInvoice->save();
            $purchaseTransaction->save();
                Session::flash('message', 'Payment has been Successfully Cleared.');
            return $purchaseTransaction->id;
        }else{
            Session::flash('message', 'You dont have Enough Balance');
            return 0;
        }


    }

    public function getEdit($id)
    {
        $suppliers = new Party();
        $suppliersAll = $suppliers->getSuppliersDropDown();
        $products = new Product();
        $localProducts = $products->getLocalProductsDropDown();
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $purchase[0] = PurchaseInvoice::where('invoice_id','=',$id)->get();
        $var = $purchase[0];
        $purchaseDetails = PurchaseInvoiceDetail::where('detail_invoice_id','=',$id)->get();
        if(count($purchaseDetails) < 1){
            return Redirect::to('purchases/index');
        }
        return view('PurchaseInvoice.edit',compact('suppliersAll'))
            ->with('localProducts',$localProducts)
            ->with('purchaseDetails',$purchaseDetails)
            ->with('purchase',$var)
            ->with('branchAll',$branchAll)
            ->with('allStockInfos',$allStockInfos);

    }
    public function getDelete($id)
    {
        $purchase = PurchaseInvoiceDetail::find($id);
        $purchase->delete();

        $message = array('Purchase Invoice  Successfully Deleted');
        return new JsonResponse($message);
    }
    public function getDeletepurchasedetail($id)
    {
        $purchaseDetail = PurchaseInvoiceDetail::find($id);
        $purchaseDetail->delete();
        Session::flash('message', 'Purchase Detail  Successfully Deleted');
        return Redirect::to('purchases/index');
    }
    public function getDeleteTransaction($id)
    {
        $transaction = Transaction::find($id);
        $account_id = Input::get('data');
        $accounts = NameOfAccount::find($account_id);
        $accounts->opening_balance = $accounts->opening_balance + $transaction->amount;
        $accounts->save();
        $transaction->delete();
        $message = array('Transaction Successfully Deleted');
        return new JsonResponse($message);
    }
    public function getDel($id)
    {
       /* Sale::where('invoice_id','=',$id)->delete();
        SAleDetail::where('invoice_id','=',$id)->delete();

        Session::flash('message', 'Sale has been Successfully Deleted.');
        return Redirect::to('sales/index');*/

        PurchaseInvoice::where('invoice_id','=',$id)->delete();
        PurchaseInvoiceDetail::where('detail_invoice_id','=',$id)->delete();

        Session::flash('message', 'Purchase Invoice has been Successfully Deleted.');

        return Redirect::to('purchases/index');
    }
    /*public function getCategories($category_id)
    {
        $categoriesName = NameOfAccount::where('account_category_id','=',$category_id)
            ->get();
        foreach ($categoriesName as $categoryName) {
            echo "<option value = $categoryName->id > $categoryName->name</option> ";
        }
    }*/
    public function getProducts($branch_id)
    {

        $poductsNames = Product::where('branch_id','=',$branch_id)
            ->get();

        foreach ($poductsNames as $product) {

            echo "<option value = $product->id > $product->name</option> ";

        }
    }
    public  function getProduct($type)
    {
        $branch= Input::get('data');
        $productsName = Product::where('product_type','=',$type)
            ->where('branch_id','=',$branch)
            ->get();

        foreach ($productsName as $productName) {

            $category = $productName->category->name;
            if($productName->sub_category_id){
                $subCategory = SubCategory::find($productName->sub_category_id);
                $subCategoryName = '('.$subCategory->name.')';
            }else{
                $subCategoryName = '';
            }

            echo "<option value = $productName->id > $productName->name ($category) $subCategoryName</option> ";

        }
    }
    public function getProductbalance($product_id)
    {
        $stockCount = StockCount::where('product_id','=',$product_id)
            ->where('stock_info_id','=',Input::get('data'))
            ->first();
        if($stockCount){
            echo "<p3 class='msg' style='color: blue;font-size: 100%; margin-left: 32px;'>Your product Balance This Stock is $stockCount->product_quantity</p3>";

        }else{
            echo "<p3 class='msg' style='color: blue;font-size: 100%; margin-left: 32px; '>You Dont have this Product In this Stock</p3>";

        }

    }
    public function getAccountbalance($account_id)
    {
        $accountBalance = NameOfAccount::find($account_id);
        echo "<p3 style='color: blue;font-size: 130%'>Your Current Balance $accountBalance->opening_balance</p3>";
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
    public function getProductprice($id){
        $product = Product::find($id);
        return new JsonResponse($product->price);
    }


    public function getMakeall()
    {
        $accountCategories = new AccountCategory();
        $accountCategoriesAll = $accountCategories->getAccountCategoriesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $buyers = new Party();
        $partyAll = $buyers->getSuppliersDropDown();
        return view('PurchaseInvoice.paymentAddAll',compact('accountCategoriesAll'))
            ->with('branchAll',$branchAll)
            ->with('partyAll',$partyAll);
    }

    public function postSaveReceiveAll()
    {
        $transactionId = 0;

        $ruless = array(
            'party_id' => 'required',
            //'cus_ref_no' => 'required',
            'branch_id' => 'required',
            'account_category_id' => 'required',
            'account_name_id' => 'required',
            'payment_method' => 'required',
            'amount' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            var_dump($validate); die();
            return Redirect::to('sales/index/')
                ->withErrors($validate);
        }
        else{

            //$this->setReceiveSalePaymentAll();

            //return Redirect::to('sales/index');



            //$salesreturn = new SalesReturn();

            //$this->setSalesReturnData($salesreturn);

            //automatically reduce sales payment starts
            $return_amount=Input::get('amount');
            $remaining_amount=$return_amount;
            //var_dump($remaining_amount);
            $partyId=Input::get('party_id');
            if($remaining_amount>0)
            {

                $invoiceId = PurchaseInvoice::where('party_id','=',$partyId)
                    ->get();
                foreach($invoiceId as $invid)
                {


                    $detailsPrice = 0;
                    $paid = 0;
                    $saleDetails = PurchaseInvoiceDetail::where('detail_invoice_id','=',$invid->invoice_id)->get();
                    $transactions = Transaction::where('invoice_id','=',$invid->invoice_id)
                        ->where('payment_method', '=', 'Check')
                        ->where('type', '=', 'Payment')
                        ->where('cheque_status', '=', 1)->get();
                    foreach($saleDetails as $saleDetail)
                    {
                        $detailsPrice = $detailsPrice + ($saleDetail->price * $saleDetail->quantity);
                    }
                    foreach($transactions as $transaction)
                    {
                        $paid =$paid + ($transaction->amount);
                    }
                    $transactions2 = Transaction::where('invoice_id','=',$invid->invoice_id)
                        ->where('type', '=', 'Payment')
                        ->where('payment_method', '!=', 'Check')->get();
                    foreach($transactions2 as $transaction)
                    {
                        $paid =$paid + ($transaction->amount);
                    }

                    $difference=$detailsPrice-$paid;
                    //echo $difference; die();
                    if($difference>0)
                    {

                        //echo 'greater than 0 difference';
                        if($remaining_amount<=$difference)
                        {
                            if($remaining_amount>0) {
                                $sale = PurchaseInvoice::find( $invid->id);
                                if($remaining_amount<$difference)
                                {
                                    $sale->status = "Partial";
                                }
                                elseif($remaining_amount==$difference)
                                {
                                    $sale->status = "Completed";
                                }

                                $transaction = new Transaction();

                                $transaction->invoice_id = $invid->invoice_id;
                                $transaction->amount = $remaining_amount;
                                $transaction->type = 'Payment';
                                $transaction->payment_method = Input::get('payment_method');
                                $transaction->account_category_id = Input::get('account_category_id');
                                $transaction->remarks = Input::get('remarks');
                                $transaction->account_name_id = Input::get('account_name_id');
                                $transaction->user_id = Session::get('user_id');
                                $transaction->cheque_no = Input::get('cheque_no');
                                $branch = PurchaseInvoiceDetail::where('detail_invoice_id', '=', $invid->invoice_id)->first();
                                $transaction->branch_id = $branch->branch_id;
                                $transaction->cheque_date = Input::get('cheque_date');
                                $transaction->cheque_bank = Input::get('cheque_bank');

                                if ($transaction->payment_method != "Check") {
                                    $accountPayment = NameOfAccount::find(Input::get('account_name_id'));
                                    $accountPayment->opening_balance = $accountPayment->opening_balance - $remaining_amount;
                                    $accountPayment->save();
                                }
                                $transaction->save();
                                $transactionId = $transaction->id;
                                $remaining_amount = 0;

                            }

                        }
                        elseif($remaining_amount>$difference)
                        {
                            if($remaining_amount>0) {
                                $sale = PurchaseInvoice::find( $invid->id);

                                $sale->status = "Completed";

                                $toBePaid=$remaining_amount-$difference;


                                $transaction = new Transaction();

                                $transaction->invoice_id = $invid->invoice_id;
                                $transaction->amount = $difference;
                                $transaction->type = 'Payment';
                                $transaction->payment_method = Input::get('payment_method');
                                $transaction->account_category_id = Input::get('account_category_id');
                                $transaction->remarks = Input::get('remarks');
                                $transaction->account_name_id = Input::get('account_name_id');
                                $transaction->user_id = Session::get('user_id');
                                $transaction->cheque_no = Input::get('cheque_no');
                                $branch = PurchaseInvoiceDetail::where('detail_invoice_id', '=', $invid->invoice_id)->first();
                                $transaction->branch_id = $branch->branch_id;
                                $transaction->cheque_date = Input::get('cheque_date');
                                $transaction->cheque_bank = Input::get('cheque_bank');

                                if ($transaction->payment_method != "Check") {
                                    $accountPayment = NameOfAccount::find(Input::get('account_name_id'));
                                    $accountPayment->opening_balance = $accountPayment->opening_balance - $difference;
                                    $accountPayment->save();
                                }
                                $transaction->save();
                                $transactionId = $transaction->id;
                                $remaining_amount = $toBePaid;
                            }



                        }
                        $sale->save();
                    }
                }
            }
            /*if($remaining_amount>0)
            {
                echo "How come its possible! Consult with DEVELOPERS!!!";
            }*/
            //automatically reduce sales payment ends

            return Redirect::to('purchases/voucher/'.$transactionId);
        }
    }

    public function getPartydue($party_id)
    {
        $partySales = PurchaseInvoice::where('party_id','=',$party_id)
            ->where('status','!=','Completed')
            ->get();
        if(count($partySales)>0){
            $totalAmount = 0;
            $totalPrice = 0;
            foreach ($partySales as $sale) {

                $saleDetails = PurchaseInvoiceDetail::where('detail_invoice_id','=',$sale->invoice_id)->get();
                $transactions = Transaction::where('invoice_id','=',$sale->invoice_id)
                    ->where('payment_method', '=', 'Check')
                    ->where('type', '=', 'Payment')
                    ->where('cheque_status', '=', 1)->get();
                foreach($saleDetails as $saleDetail)
                {
                    $totalPrice = $totalPrice + ($saleDetail->price * $saleDetail->quantity);
                }

                foreach($transactions as $transaction)
                {
                    $totalAmount =$totalAmount + ($transaction->amount);
                }

                $transactions2 = Transaction::where('invoice_id','=',$sale->invoice_id)
                    ->where('type', '=', 'Payment')
                    ->where('payment_method', '!=', 'Check')->get();
                foreach($transactions2 as $transaction)
                {
                    $totalAmount =$totalAmount + ($transaction->amount);
                }

            }
            $due = $totalPrice - $totalAmount;
            echo "<p3 style='color: red;font-size: 114%; margin-left: 32px;'>Due is $due</p3>";

        }else{
            echo "<p3 style='color: blue;font-size: 114%; margin-left: 32px; '>No Due</p3>";

        }

    }

    public function getVoucher($transactionId){
        $transaction = Transaction::find($transactionId);
        return view('Sales.voucher',compact('transaction'));

    }


}