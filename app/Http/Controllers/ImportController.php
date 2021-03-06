<?php namespace App\Http\Controllers;

use App\BankCost;
use App\Branch;
use App\CnfCost;
use App\Import;
use App\ImportDetail;
use App\OtherCost;
use App\Product;
use App\ProformaInvoice;
use App\StockInfo;
use App\StockInvoice;
use App\StockDetail;
use App\StockCount;
use App\TTCharge;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImportController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $imports = Import::orderBy('id','DESC')->paginate(15);
        return view('Imports.list',compact('imports'));
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $products = new Product();
        $productAll = $products->getProductsDropDownForeign();
        $imports = new Import();
        $importAll = $imports->getImportsDropDown();

        return view('Imports.add',compact('branchAll'))
            ->with('productAll',$productAll)
            ->with('importAll',$importAll);
    }
    public function getDetail($id)
    {
        $imports = Import::find($id);
        $products = new Product();
        $productAll = $products->getProductsDropDownForeign();
        return view('Imports.addDetails',compact('productAll', 'id'))
            ->with('imports',$imports);
    }
    public function postSaveImport()
    {
        $ruless = array(
            'branch_id' => 'required',
            'consignment_name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/create')
                ->withErrors($validate);
        }
        else{
            $import = new Import();
            $import_num = $this->createAutoGeneratedImportNum();
            $this->setImportData($import,$import_num);
            $import->save();
            Session::flash('message', 'Import has been Successfully Created.');
            return Redirect::to('imports/index');
        }
    }
    public function postSaveImportDetail()
    {
        $ruless = array(
            'product_id' => 'required',
            'quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/create')
                ->withErrors($validate);
        }
        else{
            $importDetail = new ImportDetail();
            $id= Input::get('import_num');
            $this->setImportDetailsData($importDetail);
            $importDetail->save();
            Session::flash('message', 'Import Details has been Successfully Created.');
            return Redirect::to('imports/detail/'.$id);
        }
    }
    public function postSaveBankCost()
    {
        $ruless = array(
            'lc_no' => 'required',
            'bank_name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/list')
                ->withErrors($validate);
        }
        else{
            $bankCost = new BankCost();
            $id= Input::get('import_id');
            $this->setBankCostData($bankCost);
            $bankCost->save();
            Session::flash('message', 'Bank Cost has been Successfully Created.');
            return Redirect::to('imports/costs/'.$id);
        }
    }
    public function postUpdateBankCost($id)
    {
        $ruless = array(
            'lc_no' => 'required',
            'bank_name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/editCost',$id)
                ->withErrors($validate);
        }
        else{
            $bankCost =  BankCost::find($id);
            $this->setBankCostData($bankCost);
            $bankCost->save();
            Session::flash('message', 'Bank Cost has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }
    public function postSaveCnfCost()
    {
        $ruless = array(
            'clearing_agent_name' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/list')
                ->withErrors($validate);
        }
        else{
            $cnfCost = new CnfCost();
            $id= Input::get('import_id');
            $this->setCnfCostData($cnfCost);
            $cnfCost->save();
            Session::flash('message', 'CNF Cost has been Successfully Created.');
            return Redirect::to('imports/costs/'.$id);
        }
    }
    public function postUpdateCnfCost($id)
    {
        $ruless = array(
            'clearing_agent_name' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/editCost',$id)
                ->withErrors($validate);
        }
        else{
            $cnfCost = CnfCost::find($id);
            $this->setCnfCostData($cnfCost);
            $cnfCost->save();
            Session::flash('message', 'CNF Cost has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }
    public function postProformaInvoice()
    {
        $ruless = array(
            'invoice_no' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/index')
                ->withErrors($validate);
        }
        else{
            $pi = new ProformaInvoice();
            $id= Input::get('import_id');
            $this->setProformaInvoiceData($pi);
            $pi->save();
            Session::flash('message', 'Proforma Invoice has been Successfully Created.');
            return Redirect::to('imports/costs/'.$id);
        }
    }
    public function postUpdateProformaInvoice($id)
    {
        $ruless = array(
            'invoice_no' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/editCost',$id)
                ->withErrors($validate);
        }
        else{
            $pi = ProformaInvoice::find($id);
            $this->setProformaInvoiceData($pi);
            $pi->save();
            Session::flash('message', 'Proforma Invoice has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }
    public function postOtherCost()
    {
        $ruless = array(
            'tt_charge' => 'required',
            'dollar_rate_per_tt' => 'required',
            'dollar_to_bd_rate' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/list')
                ->withErrors($validate);
        }
        else{
            $counter = 0;
            $tt_charges = TTCharge::where('import_id', '=', Input::get("import_id"))->get();
            foreach($tt_charges as $row){
                $row->delete();
            }
            $total = 0;
            foreach(Input::get("tt_charge") as $tt){
                $tt_charge = new TTCharge();
                $tt_charge->tt_amount = $tt;
                $tt_charge->dollar_rate = Input::get("dollar_rate_per_tt")[$counter++];
                $total_tt = $tt_charge->tt_amount * $tt_charge->dollar_rate.'_';
                $total_tt2 = $tt_charge->tt_amount * Input::get("dollar_to_bd_rate").'_';
                $subTotal = $total_tt - $total_tt2;
                $total += $subTotal;
                $tt_charge->import_id = Input::get("import_id");
                $tt_charge->save();

            }

            $otherCost = new OtherCost();
            $otherCost->dollar_to_bd_rate = Input::get('dollar_to_bd_rate');
            $otherCost->tt_charge = $total;
            $otherCost->import_id = Input::get("import_id");
            $otherCost->save();


            Session::flash('message', 'Others Cost has been Successfully Created.');
            return Redirect::to('imports/index');
        }
    }
    public function postUpdateOtherCost($id)
    {
        $ruless = array(
            'tt_charge' => 'required',
            'dollar_rate_per_tt' => 'required',
            'dollar_to_bd_rate' => 'required'
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/editCost',$id)
                ->withErrors($validate);
        }
        else{
            $counter = 0;
            $tt_charges = TTCharge::where('import_id', '=', $id)->get();
            foreach($tt_charges as $row){
                $row->delete();
            }
            $total = 0;
            foreach(Input::get("tt_charge") as $tt){
                $tt_charge = new TTCharge();
                $tt_charge->tt_amount = $tt;
                $tt_charge->dollar_rate = Input::get("dollar_rate_per_tt")[$counter++];
                echo $total_tt = $tt_charge->tt_amount * $tt_charge->dollar_rate.'_';
                echo $total_tt2 = $tt_charge->tt_amount * Input::get("dollar_to_bd_rate").'_';
                echo $subTotal = $total_tt - $total_tt2;
                $total += $subTotal;
                $tt_charge->import_id = $id;
                $tt_charge->save();

            }

            $otherCost = OtherCost::find($id);
            $otherCost->dollar_to_bd_rate = Input::get('dollar_to_bd_rate');
            $otherCost->tt_charge = $total;
            $otherCost->import_id = $id;
            $otherCost->save();
            Session::flash('message', 'Others Cost has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }

    public function getDetails($id)
    {
        $imports  = ImportDetail::where('import_num','=',$id)->get();
        $bankCost = BankCost::where('import_id','=',$id)->get();
        $cnfCost  = CnfCost::where('import_id','=',$id)->get();
        $pi       =  ProformaInvoice::where('import_id','=',$id)->get();
        $otherCost     = OtherCost::where('import_id','=',$id)->get();
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();

        return view('Imports.details',compact('imports', 'id'))
            ->with('bankCost',$bankCost)
            ->with('pi',$pi)
            ->with('otherCost',$otherCost)
            ->with('cnfCost',$cnfCost)
            ->with('allStockInfos',$allStockInfos);
    }
    public function getLandingcost($id)
    {
        $importDetails = new ImportDetail();

        $imports = $importDetails->getLandingCostData($id);
       // var_dump($imports);exit;
        $detailsQuantity = ImportDetail::where('import_num','=',$id)->get();
        $totalQuantitySum = $detailsQuantity->sum('quantity');
        $totalBankCost = BankCost::where('import_id','=',$id)->get();
        $totalCnfCost  = CnfCost::where('import_id','=',$id)->get();
        $ttCharge      = OtherCost::where('import_id','=',$id)->get();
        return view('Imports.landingCost',compact('imports'))
            ->with('totalBankCost',$totalBankCost)
            ->with('totalCnfCost',$totalCnfCost)
            ->with('id',$id)
            ->with('totalQuantitySum',$totalQuantitySum)
            ->with('ttCharge',$ttCharge);
    }
    public function getLandingcostprint($id)
    {
        $importDetails = new ImportDetail();

        $imports = $importDetails->getLandingCostData($id);
        $detailsQuantity = ImportDetail::where('import_num','=',$id)->get();
        $totalQuantitySum = $detailsQuantity->sum('quantity');
        $totalBankCost   = BankCost::where('import_id','=',$id)->get();
        $totalCnfCost    = CnfCost::where('import_id','=',$id)->get();
        $ttCharge        = OtherCost::where('import_id','=',$id)->get();
        $benificiaryName = ProformaInvoice::where('import_id','=',$id)->get();
        return view('Imports.landingCostPrint',compact('imports'))
            ->with('totalBankCost',$totalBankCost)
            ->with('totalCnfCost',$totalCnfCost)
            ->with('id',$id)
            ->with('ttCharge',$ttCharge)
            ->with('totalQuantitySum',$totalQuantitySum)
            ->with('benificiaryName',$benificiaryName);
    }
    public function getCosts($id)
    {
        $imports = Import::find($id);
        $importBankCost = BankCost::where('import_id','=',$id)->get();
        $importCnfCost = CnfCost::where('import_id','=',$id)->get();
        $importOtherCost = OtherCost::where('import_id','=',$id)->get();
        $importProformaInvoice = ProformaInvoice::where('import_id','=',$id)->get();
        return view('Imports.costs',compact('imports'))
            ->with('importBankCost',$importBankCost)
            ->with('importCnfCost',$importCnfCost)
            ->with('importOtherCost',$importOtherCost)
            ->with('importProformaInvoice',$importProformaInvoice);
    }
    public function getEdit($id)
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $import = Import::find($id);
        return view('Imports.edit',compact('import'))
            ->with('branchAll',$branchAll);
    }
    public function getEditdetails($id)
    {
        $import = ImportDetail::find($id);
        $products = new Product();
        $productAll = $products->getProductsDropDownForeign();

        return view('Imports.editDetails',compact('import'))
            ->with('productAll',$productAll);

    }
    public function getEditcost($id)
    {
        $imports = Import::find($id);
        $proformaInvoice = ProformaInvoice::where('import_id','=',$id)->get();
        $bankCost    = BankCost::where('import_id','=',$id)->get();
        $cnfCost     = CnfCost::where('import_id','=',$id)->get();
        $otherCost   = OtherCost::where('import_id','=',$id)->get();
        $ttCharges   = TTCharge::where('import_id','=',$id)->get();
        return view('Imports.editCost',compact('imports', 'ttCharges'))
            ->with('importProformaInvoice',$proformaInvoice)
            ->with('importBankCost',$bankCost)
            ->with('importCnfCost',$cnfCost)
            ->with('importOtherCost',$otherCost);
    }
    public function postUpdate($id)
    {
        $ruless = array(
            'branch_id' => 'required',
            'consignment_name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $import = Import::find($id);
            $this->setImportDataEdit($import);
            $import->save();
            Session::flash('message', 'Import has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }
    public function postUpdateDetails($id)
    {
        $ruless = array(
            'product_id' => 'required',
            'quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('imports/create')
                ->withErrors($validate);
        }
        else{
            $importDetail = ImportDetail::find($id);
            $this->setImportDetailsData($importDetail);
            $importDetail->save();
            Session::flash('message', 'Import Details has been Successfully Updated.');
            return Redirect::to('imports/index');
        }
    }
    public function getChangeStatus($status,$id)
    {
        $import = Import::find($id);
        if($import['status'] == $status) {
            $import->status = ($status == 'Activate' ? 'Deactivate': 'Activate');
            $import->save();

        }
        return new JsonResponse(array(
            'id' => $import['id'],
            'status' => $import['status']
        ));
    }
    private function setImportData($import,$import_num)
    {

        $import->import_num = $import_num;
        $import->branch_id = Input::get('branch_id');
        $import->consignment_name = Input::get('consignment_name');
        $import->description = Input::get('description');
        $import->user_id = Session::get('user_id');
        $import->status = "Activate";
    }
    private function setImportDataEdit($import)
    {

        $import->import_num = Input::get('import_num');
        $import->branch_id = Input::get('branch_id');
        $import->consignment_name = Input::get('consignment_name');
        $import->description = Input::get('description');
        $import->user_id = Session::get('user_id');
        $import->status = "Activate";
    }
    private function setImportDetailsData($importDetail)
    {
        $importDetail->import_num = Input::get('import_num');
        $importDetail->product_id = Input::get('product_id');
        $importDetail->quantity = Input::get('quantity');
        $importDetail->total_booking_price = Input::get('total_booking_price');
        $importDetail->total_cfr_price = Input::get('total_cfr_price');
        $importDetail->user_id = Session::get('user_id');
    }
    private function setProformaInvoiceData($pi)
    {
        $pi->invoice_no = Input::get('invoice_no');
        $pi->beneficiary_name = Input::get('beneficiary_name');
        $pi->terms = Input::get('terms');
        $pi->import_id = Input::get('import_id');
    }
    private function setOtherCostData($otherCost)
    {
        $otherCost->dollar_to_bd_rate = Input::get('dollar_to_bd_rate');
        $otherCost->tt_charge = Input::get('tt_charge');
        $otherCost->import_id = Input::get('import_id');
    }
    private function setBankCostData($bankCost)
    {
        $bankCost->lc_no = Input::get('lc_no');
        $bankCost->bank_name = Input::get('bank_name');
        $date = strtotime(Input::get('lc_date'));
        $bankCost->lc_date = date('m-d-Y',$date);
        $bankCost->lc_commission_charge = Input::get('lc_commission_charge');
        $bankCost->vat_commission = Input::get('vat_commission');
        $bankCost->stamp_charge = Input::get('stamp_charge');
        $bankCost->swift_charge = Input::get('swift_charge');
        $bankCost->lca_charge = Input::get('lca_charge');
        $bankCost->insurance_charge = Input::get('insurance_charge');
        $bankCost->bank_service_charge = Input::get('bank_service_charge');
        $bankCost->others_charge = Input::get('others_charge');
        $bankCost->import_id = Input::get('import_id');

        $totalBankCost = Input::get('lc_commission_charge') + Input::get('vat_commission') + Input::get('stamp_charge') +  Input::get('swift_charge') +
                         Input::get('lca_charge') + Input::get('insurance_charge')+   Input::get('bank_service_charge') + Input::get('others_charge');

        $bankCost->total_bank_cost = $totalBankCost;
    }
    private function setCnfCostData($cnfCost)
    {
        $cnfCost->clearing_agent_name = Input::get('clearing_agent_name');
        $cnfCost->bill_no = Input::get('bill_no');
        $cnfCost->bank_no = '';
        $date = strtotime(Input::get('clearing_date'));
        $cnfCost->clearing_date = date('Y-m-d',$date);
        $cnfCost->association_fee = Input::get('association_fee');
        $cnfCost->po_cash = Input::get('po_cash');
        $cnfCost->port_charge = Input::get('port_charge');
        $cnfCost->shipping_charge = Input::get('shipping_charge');
        $cnfCost->noc_charge = Input::get('noc_charge');
        $cnfCost->labour_charge = Input::get('labour_charge');
        $cnfCost->jetty_charge = Input::get('jetty_charge');
        $cnfCost->agency_commission = Input::get('agency_commission');
        $cnfCost->others_charge = Input::get('others_charge');
        $cnfCost->import_id = Input::get('import_id');

        $totalCnfCost = Input::get('association_fee') + Input::get('port_charge') + Input::get('shipping_charge') +  Input::get('noc_charge') +
                        Input::get('labour_charge') + Input::get('jetty_charge')+   Input::get('agency_commission') + Input::get('others_charge');

        $cnfCost->total_cnf_cost = $totalCnfCost;
    }

    private function createAutoGeneratedImportNum()
    {
        $imports = new Import();
        $import_number = $imports->getLastImportId();
       if($import_number){
           $test = explode('IMP',$import_number->import_num);
           $test[1] = $test[1] + 1;
           $number = sprintf('%06d', $test[1]);
           $import_num = 'IMP'.$number;
       }else{
           $sec = 'IMP';
           $num = '000001';
           $import_num = $sec . $num;
       }
        return $import_num;

    }

    public function getAddToStock($import_id, $to_stock_id){
        $stockInvoces = new StockInvoice();
        $stockDetails = new StockDetail();

        $invoiceId = $stockInvoces->invoice_id = $this->generateInvoiceId();

        $import = Import::find($import_id);

        $import_details = ImportDetail::where('import_num', '=', $import_id)->where('stock_in_status', '=','0')->get();
        if(!empty($import_details[0])){
            $this->insertStockData($stockInvoces, $import, $invoiceId);
        }
        foreach($import_details as $row) {

            $this->setStockData($import, $row, $stockDetails, $invoiceId, $to_stock_id);
        }

        Session::flash('message', 'Product added to the stock successfully');
        return Redirect::to('imports/details/'.$import->id);

        //$list = $this->setStockData($import, $stockDetails);
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

    private function insertStockData($stockInvoces, $import, $invoiceId)
    {
        $stockInvoces->branch_id = $import->branch_id;
        $stockInvoces->status = 'Activate';
        $stockInvoces->user_id = Session::get('user_id');


        $stock_invoices_check = StockInvoice::where('invoice_id','=',$invoiceId)
            ->get();
        if(empty($stock_invoices_check[0]))
            $stockInvoces->save();
    }

    private function setStockData($import, $import_details,$stockDetails, $invoiceId, $to_stock_id)
    {
        $stock_Count = StockCount::where('product_id','=',$import_details->product_id)
            ->where('stock_info_id','=',$to_stock_id)
            ->get();

        $stockDetails->branch_id = $import->branch_id;
        $stockDetails->product_id = $import_details->product_id;
        $stockDetails->entry_type = "StockIn";

        $product = Product::find($import_details->product_id);
        $stockDetails->product_type = $product->product_type;
        $stockDetails->stock_info_id = $to_stock_id;
        $stockDetails->remarks = "";
        $stockDetails->invoice_id = $invoiceId;
        $stockDetails->quantity = $import_details->quantity;

        $import_details->stock_in_status = 1;
        $import_details->save();
        if($stockDetails->entry_type == 'StockIn')
        {

            $stockDetails->consignment_name = $import->consignment_name;

            if(empty($stock_Count[0]))
            {

                $stock_Count = new StockCount();
                $stock_Count->product_id = $import_details->product_id;
                $stock_Count->stock_info_id = $stockDetails->stock_info_id;
                $stock_Count->product_quantity = $import_details->quantity;
                $stock_Count->save();
                $stockDetails->save();
                //$stockCounts->save();
            }else{

                $stock_Count[0]->product_quantity = $stock_Count[0]->product_quantity + $import_details->quantity;
                //$stock->save();
                $stock_Count[0]->save();
                $stockDetails->save();
            }


        }

    }

}