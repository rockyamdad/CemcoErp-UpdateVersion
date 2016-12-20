<?php namespace App\Http\Controllers;

use App\Branch;
use App\Import;
use App\Product;
use App\Stock;
use App\StockInvoice;
use App\StockDetail;
use App\StockCount;
use App\StockInfo;
use App\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $stocks = StockInvoice::orderBy('id','DESC')
            ->paginate(15);
        return view('Stocks.all',compact('stocks'));
        //return view('Stocks.list',compact('stocks'));
    }

    public function getCreate()
    {
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('Stocks.addSubtract', compact('allStockInfos'))
            ->with('branchAll', $branchAll);
    }

    public function getCreate2()
    {
//        $productsName = Product::where('product_type','=','Finish Goods')
//            ->where('branch_id','=',1)
//            ->get();
//        echo '<pre>';
//        print_r($productsName);die();
        // get all branches
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();

        // get all stocks
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();

        $invoiceId = $this->generateInvoiceId();
        //$invoiceId = 's121513';
        $buyersAll = 0;

        return view('Stocks.adds',compact('buyersAll','invoiceId'))
            ->with('branchAll',$branchAll)
            ->with('allStockInfos',$allStockInfos);
    }


    public  function getProducts($type)
    {
        $productsName = Product::where('product_type','=',$type)
            ->where('branch_id','=',Input::get('data'))
            ->get();
        $product_id= Input::get('product_id');


        foreach ($productsName as $productName) {

            $category = $productName->category->name;
            if($productName->sub_category_id){
                $subCategory = SubCategory::find($productName->sub_category_id);
                $subCategoryName = '('.$subCategory->name.')';
            }else{
                $subCategoryName = '';
            }

            if($productName->id==$product_id)
            {
                echo '<option value = "'.$productName->id.'" selected> '.$productName->name.' ('.$category.') ('.$subCategoryName.')</option> ';
            }
            else
            {
                echo "<option value = $productName->id > $productName->name ($category) $subCategoryName</option> ";
            }

        }
    }
    public  function getStocks()
    {
        $stocks = StockInfo::where('status','=','Activate')
            ->get();
        $stock_id= Input::get('data');
        foreach ($stocks as $stock) {
            if($stock->id==$stock_id)
            {
                echo '<option value = "'.$stock->id.'" selected> '.$stock->name.' </option> ';
            }
            else
            {
                echo "<option value = $stock->id > $stock->name</option> ";
            }

        }
    }
    public  function getImports()
    {
        $imports = Import::where('status','=','Activate')
            ->get();
        echo "<option value ='N/A' >N/A </option>";
        foreach ($imports as $import) {
            echo "<option value = $import->consignment_name > $import->consignment_name</option> ";
        }
    }
    public  function getQuantity()
    {
        $stock_info_id = Input::get('stock_info_id');
        $product_id = Input::get('product_id');
        $productsQuantity = StockCount::where('product_id', '=', $product_id)
            ->where('stock_info_id', '=', $stock_info_id)
            ->first();
        if ($stock_info_id == '' || $product_id=='')
        {
            echo "<p3 style='color: red;font-size: 150%'>You have to Choose Both</p3>";
        }
        elseif(empty($productsQuantity))
        {
            echo "<p3 style='color: red;font-size: 150%'>Available 0</p3>";
        }elseif(!empty($productsQuantity)){
            echo "<p3 style='color: green;font-size: 150%'>Available $productsQuantity->product_quantity</p3>";
        }
    }

    public function postSaveStock()
    {
        $ruless = array(
            'product_id' => 'required',
            'branch_id' => 'required',
            'product_quantity' => 'required',
            'entry_type' => 'required',
            'stock_info_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('stocks/create')
                ->withErrors($validate);
        }
        else{
            $stock = new Stock();
            $stockCounts = new StockCount();
            $list = $this->setStockData($stock,$stockCounts);
            return new JsonResponse($list);
            //return Redirect::to('stocks/create');
        }
    }


    public function postSaveStock2()
    {
        $ruless = array(
            'stock_info_id' => 'required',
            'product_type' => 'required',
            'branch_id' => 'required',
            'product_id' => 'required',
            'product_quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('sales/index/')
                ->withErrors($validate);
        }
        else{
            $stockInvoces = new StockInvoice();
            $stockDetails = new StockDetail();

            $list = $this->setStockData($stockInvoces, $stockDetails);
            return new JsonResponse($list);

        }
    }


    private function generateInvoiceId()
    {
        //needs recheck
        $invdesc = StockInvoice::orderBy('id', 'DESC')->first();
        if ($invdesc != null) {
            $invDescId = $invdesc->invoice_id;
            $invDescIdNo = substr($invDescId, 7);

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
                $invoiceidd = "C".$dd2 . $mm2 . $yy2 . ($invDescIdNo + 1);
                //var_dump($invoiceidd);
                return $invoiceidd;
            } else {
                $invoiceidd = "C".$dd2 . $mm2 . $yy2 . "1";
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


            $invoiceidd = "C".$dd2 . $mm2 . $yy2 . "1";
            //var_dump($invoiceidd);
            return $invoiceidd;
        }
    }




    public function getEdit($id)
    {
        $stockInvoices = StockInvoice::find($id);
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();

        $stockDetails = StockDetail::where('invoice_id', '=', $stockInvoices->invoice_id)->first();
        $stockDetails2 = StockDetail::where('invoice_id', '=', $stockInvoices->invoice_id)->get();

        // get all stocks
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();

        $invoiceId = $stockInvoices->invoice_id;
        //$invoiceId = 's121513';
        $buyersAll = 0;

        $imports = Import::where('status','=','Activate')
            ->get();

        $productsName = Product::where('product_type','=',$stockDetails->product_type)
            ->where('branch_id','=',$stockDetails->branch_id)
            ->get();




        return view('Stocks.edit2',compact('buyersAll','invoiceId', 'stockInvoices', 'stockDetails', 'productsName', 'stockDetails2', 'imports'))
            ->with('branchAll',$branchAll)
            ->with('allStockInfos',$allStockInfos);

//        return view('Stocks.edit',compact('stock'))
//            ->with('allStockInfos',$allStockInfos)
//            ->with('branchAll',$branchAll);

    }
    public function postUpdateStock($id)
    {
        $ruless = array(
            'product_id' => 'required',
            'branch_id' => 'required',
            'product_quantity' => 'required',
            'entry_type' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('stocks/edit',$id)
                ->withErrors($validate);
        }
        else{
            $stock = Stock::find($id);
            $this->updateStockData($stock);
            return Redirect::to('stocks/index');
        }
    }
    private function setStockData($stockInvoces,$stockDetails)
    {
        $this->insertStockData($stockInvoces);
        $stock_invoices_check = StockInvoice::where('invoice_id','=',Input::get('invoice_id'))
            ->get();
        if(empty($stock_invoices_check[0]))
            $stockInvoces->save();



        $stock_Count = StockCount::where('product_id','=',Input::get('product_id'))
            ->where('stock_info_id','=',Input::get('stock_info_id'))
            ->get();

        $stockDetails->branch_id = Input::get('branch_id');
        $stockDetails->product_id = Input::get('product_id');
        $stockDetails->entry_type = Input::get('entry_type');
        $stockDetails->product_type = Input::get('product_type');
        $stockDetails->stock_info_id = Input::get('stock_info_id');
        $stockDetails->remarks = Input::get('remarks');
        $stockDetails->invoice_id = Input::get('invoice_id');
        $stockDetails->quantity = Input::get('product_quantity');

        if(Input::get('entry_type') == 'StockIn')
        {
            $stockDetails->consignment_name = Input::get('consignment_name');

            if(empty($stock_Count[0]))
            {
                $stock_Count = new StockCount();
                $stock_Count->product_id = Input::get('product_id');
                $stock_Count->stock_info_id = Input::get('stock_info_id');
                $stock_Count->product_quantity = Input::get('product_quantity');
                $stock_Count->save();
                $stockDetails->save();
                $stockDetails = StockDetail::find($stockDetails->id);
                return $this->stockDetailConvertToArray($stockDetails);
                //$stockCounts->save();
            }else{
                $stock_Count[0]->product_quantity = $stock_Count[0]->product_quantity + Input::get('product_quantity');
                //$stock->save();
                $stock_Count[0]->save();
                $stockDetails->save();
                $stockDetails = StockDetail::find($stockDetails->id);
                return $this->stockDetailConvertToArray($stockDetails);
            }
            //Session::flash('message', 'Stock has been Successfully Created && Product Quantity Added');
        }elseif(Input::get('entry_type') == 'StockOut'){
            if(!empty($stock_Count[0])) {
                if ($stock_Count[0]->product_quantity >= Input::get('product_quantity')) {
                    $stock_Count[0]->product_quantity = $stock_Count[0]->product_quantity - Input::get('product_quantity');
                    //$stock->save();
                    $stock_Count[0]->save();
                    $stockDetails->save();
                    $stockDetails = StockDetail::find($stockDetails->id);
                    return $this->stockDetailConvertToArray($stockDetails);
                    //Session::flash('message', 'Stock has been Successfully Created && Product Quantity Subtracted');
                } else {
                    return '0';
                    //Session::flash('message', 'You Dont have enough products in Stock');
                }
            }else{
                return '0';
                //Session::flash('message', 'You Dont have This products in This Stock');
            }


        }  elseif(Input::get('entry_type') == 'Transfer')
            {
                $stockDetails->to_stock_info_id = Input::get('to_stock_info_id') ;
                if(!empty($stock_Count[0])) {
                    if ($stock_Count[0]->product_quantity >= Input::get('product_quantity')) {
                        $stock_Count[0]->product_quantity = $stock_Count[0]->product_quantity - Input::get('product_quantity');
                        $stock_Count[0]->save();
                        $stockDetails->save();
                        $stockCountTo = StockCount::where('product_id','=',Input::get('product_id'))
                            ->where('stock_info_id','=',Input::get('to_stock_info_id'))
                            ->get();

                        if(!empty($stockCountTo[0])) {
                            $stockCountTo[0]->product_quantity = $stockCountTo[0]->product_quantity + Input::get('product_quantity');
                            //$stock->save();
                            $stockCountTo[0]->save();

                            $stockDetails = StockDetail::find($stockDetails->id);
                            return $this->stockDetailConvertToArray($stockDetails);
                        }else{
                            $new_stockCount = new StockCount();
                            $new_stockCount->product_id = Input::get('product_id');
                            $new_stockCount->stock_info_id = Input::get('to_stock_info_id');
                            $new_stockCount->product_quantity = Input::get('product_quantity');
                            $new_stockCount->save();
                            //$stockCounts->stock_info_id = Input::get('to_stock_info_id');
                            $stockDetails->quantity = Input::get('product_quantity');
                            //$stock->save();
                            $stockDetails->save();
                            $stockDetails = StockDetail::find($stockDetails->id);
                            return $this->stockDetailConvertToArray($stockDetails);
                        }

                        Session::flash('message', 'Product Has been successfully Transfered');
                    } else {
                        Session::flash('message', 'You Dont have enough products in Stock');
                    }
                }else{
                    Session::flash('message', 'You Dont have This products in This Stock');
                }


            }
        else{
                $stockDetails->save();
                $stockDetails = StockDetail::find($stockDetails->id);
                return $this->stockDetailConvertToArray($stockDetails);
                //Session::flash('message', 'Stock has been Successfully Created && Wastage Product saved');
        }

    }






    private function stockDetailConvertToArray($stockDetails)
    {
        $array = array();
        $stockName = StockInfo::find($stockDetails->stock_info_id);
        $tostockName = StockInfo::find($stockDetails->to_stock_info_id);
        //var_dump($stockDetails->to_stock_info_id); die();
        $branchName = Branch::find($stockDetails->branch_id);

        $array['id'] = $stockDetails->id;
        $array['branch_id'] = $branchName->name;
        $array['stock_info_id'] = $stockName->name;
        $array['product_type'] = $stockDetails->product_type;
        $productsName = Product::find($stockDetails->product_id);
        $category = $productsName->category->name;
        $subCategoryName = '';
        if($productsName->sub_category_id){
            $subCategory = SubCategory::find($productsName->sub_category_id);
            $subCategoryName = '('.$subCategory->name.')';
        }
        $array['product_id'] = $stockDetails->product->name.' ('.$category.') '.$subCategoryName;
        if($tostockName != null)
            $array['to_stock_info_id'] = $tostockName->name;
        $array['entry_type'] = $stockDetails->entry_type;
        $array['product_quantity']   = $stockDetails->quantity;
        $array['remarks'] = $stockDetails->remarks;
        $array['consignment_name'] = $stockDetails->consignment_name;
        return $array;
    }

    public function getDetails($invoice_id = null){
        if($invoice_id != null) {
            $stockDetails = StockDetail::where('invoice_id','=',$invoice_id)->get();

            //$saleTransactions = Transaction::where('invoice_id','=',$invoice_id)->get();
            $stock = StockInvoice::where('invoice_id','=',$invoice_id)->first();
            return view('Stocks.details',compact('stockDetails'))
                ->with('stock',$stock);
        }
    }


    private function updateStockData($stock)
    {

        $stockCount = StockCount::where('product_id','=',Input::get('product_id'))
            ->where('stock_info_id','=',Input::get('stock_info_id'))
            ->get();
        if(Input::get('entry_type') == 'StockIn')
        {
            $stock->consignment_name = Input::get('consignment_name');
            if(empty($stockCount[0]))
            {

                $stockCountOld = StockCount::where('product_id','=',$stock->product_id)
                    ->where('stock_info_id','=',$stock->stock_info_id)
                    ->get();
                $stockCountOld[0]->product_quantity = ($stockCountOld[0]->product_quantity - $stock->product_quantity);
                $stockCountOld[0]->save();

                $stockCounts = new StockCount();
                $stockCounts->product_id = Input::get('product_id');
                $stockCounts->stock_info_id = Input::get('stock_info_id');
                $stockCounts->product_quantity = Input::get('product_quantity');
                $stockCounts->save();
                $this->insertStockData($stock);
                $stock->save();
            }else{
                $stockCount[0]->product_quantity = ($stockCount[0]->product_quantity - $stock->product_quantity) + Input::get('product_quantity');
                $stockCount[0]->save();
                $this->insertStockData($stock);
                $stock->save();
            }
            Session::flash('message', 'Stock has been Successfully Updated && Product Quantity Updated');
        }elseif(Input::get('entry_type') == 'StockOut'){
            if(!empty($stockCount[0])) {
                if ($stockCount[0]->product_quantity >= Input::get('product_quantity')) {
                    $stockCount[0]->product_quantity = ($stockCount[0]->product_quantity+$stock->product_quantity) - Input::get('product_quantity');
                    $stockCount[0]->save();
                    $this->insertStockData($stock);
                    $stock->save();
                    Session::flash('message', 'Stock has been Successfully Updated && Product Quantity Updated');
                } else {
                    Session::flash('message', 'You Dont have enough products in Stock');
                }
            }else{
                Session::flash('message', 'You Dont have This products in This Stock');
            }

        }elseif(Input::get('entry_type') == 'Transfer')
        {
            if(!empty($stockCount[0])) {
                if ($stockCount[0]->product_quantity >= Input::get('product_quantity')) {
                    $stockCount[0]->product_quantity = ($stockCount[0]->product_quantity + $stock->product_quantity) - Input::get('product_quantity');
                    $stockCount[0]->save();

                    $stockCountTo = StockCount::where('product_id','=',Input::get('product_id'))
                        ->where('stock_info_id','=',Input::get('to_stock_info_id'))
                        ->get();

                    if(!empty($stockCountTo[0])) {
                        $stockCountTo[0]->product_quantity = ($stockCountTo[0]->product_quantity - $stock->product_quantity) + Input::get('product_quantity');
                        $stockCountTo[0]->save();
                        $this->insertStockData($stock);
                        $stock->save();
                    }else{
                        $stockCountToOld = StockCount::where('product_id','=',$stock->product_id)
                            ->where('stock_info_id','=',$stock->to_stock_info_id)
                            ->get();
                        $stockCountToOld[0]->product_quantity = ($stockCountToOld[0]->product_quantity - $stock->product_quantity);
                        $stockCountToOld[0]->save();

                        $stockCounts = new StockCount();
                        $stockCounts->product_id = Input::get('product_id');
                        $stockCounts->stock_info_id = Input::get('to_stock_info_id');
                        $stockCounts->product_quantity = Input::get('product_quantity');
                        $stockCounts->save();
                        $this->insertStockData($stock);
                        $stock->save();
                    }
                    Session::flash('message', 'Product Has been successfully Transfered and Updated');
                } else {
                    Session::flash('message', 'You Dont have enough products in Stock');
                }
            }else{
                Session::flash('message', 'You Dont have This products in This Stock');
            }

        }
        else{
            $this->insertStockData($stock);
            $stock->save();
            Session::flash('message', 'Stock has been Successfully Created && Wastage Product Updated');
        }
    }

    public function getDelete($id)
    {
        $stock = StockDetail::find($id);

        $stockCount = StockCount::where('product_id','=',$stock->product_id)
            ->where('stock_info_id','=',$stock->stock_info_id)
            ->get();

        if($stock->entry_type=='StockIn'){
            $stockCount[0]->product_quantity = $stockCount[0]->product_quantity - $stock->quantity;
            $stockCount[0]->save();
        }elseif($stock->entry_type=='StockOut')
        {
            $stockCount[0]->product_quantity = $stockCount[0]->product_quantity + $stock->quantity;
            $stockCount[0]->save();
        }elseif($stock->entry_type=='Transfer')
        {
            $stockCount[0]->product_quantity = $stockCount[0]->product_quantity + $stock->quantity;
            $stockCount[0]->save();

            $stockCountTo = StockCount::where('product_id','=',$stock->product_id)
                ->where('stock_info_id','=',$stock->to_stock_info_id)
                ->get();
            $stockCountTo[0]->product_quantity = $stockCountTo[0]->product_quantity - $stock->quantity;
            $stockCountTo[0]->save();
        }

        $invoice_id = $stock->invoice_id;

        $stock->delete();
        $checkStockDetailsRow = StockDetail::where('invoice_id','=',$invoice_id)
            ->get();
        if(empty($checkStockDetailsRow[0])) {
            $stock_invoice = StockInvoice::where('invoice_id','=',$invoice_id)
                ->get();

            if(!empty($stock_invoice[0])) {
                echo 'deleted';
                $stock_invoice[0]->delete();
            }
        }


        //Session::flash('message', 'Stock  has been Successfully Deleted.');
        //return Redirect::to('stocks/index');
    }


    public function delstock($stockInvoiceId){
        if($stockInvoiceId != null) {
            $stockInvoice = StockInvoice::find($stockInvoiceId);
            $stockDetails = StockDetail::where('invoice_id','=',$stockInvoice->invoice_id)
                ->get();
            foreach($stockDetails  as $row) {
                $this->getDelete($row->id);
            }
            return Redirect::to('stocks/index');
        }
    }

    /**
     * @param $stock
     */
    private function insertStockData($stockInvoces)
    {
        $stockInvoces->branch_id = Input::get('branch_id');
        $stockInvoces->status = 'Activate';
        $stockInvoces->remarks = '1. PAYMENT MUST BE MAID WITHIN 15 DAYS BY CHEQUE OR CASH
2. NO REPLACEMENT WARANTY';
        $stockInvoces->user_id = Session::get('user_id');
        $stockInvoces->invoice_id = Input::get('invoice_id');
    }


    public function getShowinvoice($invoiceId)
    {
        $stockDetails = StockDetail::where('invoice_id','=',$invoiceId)->get();
        $stock = StockInvoice::where('invoice_id','=',$invoiceId)->first();
        return view('Stocks.showInvoice',compact('stockDetails'))
            ->with('stock',$stock);

    }

    public function getConfirm($invoiceId){
        $stock = StockInvoice::where('invoice_id','=',$invoiceId)->first();
        $stock->confirmation = 1;
        $stock->save();
        return Redirect::to('stocks/index');
    }
}