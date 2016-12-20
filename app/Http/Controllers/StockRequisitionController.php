<?php namespace App\Http\Controllers;

use App\Branch;
use App\Party;
use App\Product;
use App\Stock;
use App\StockRequisition;
use App\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockRequisitionController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $requisitions = StockRequisition::where('status','=','Activate')->paginate(25);
        return view('StockRequisition.list',compact('requisitions'));
    }

    public function getCreate()
    {
        $products = new Product();
        $productAll = $products->getProductsWithCategories();
        $parties = new Party();
        $partyAll = $parties->getPartiesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('StockRequisition.add',compact('productAll'))
            ->with('partyAll',$partyAll)
            ->with('branchAll',$branchAll);
    }
    public function postSaveRequisition()
    {
        $ruless = array(
            'branch_id' => 'required',
            'product_id' => 'required',
            'requisition_quantity' => 'required',
            'party_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('requisitions/create')
                ->withErrors($validate);
        }
        else{
            $requisition = new StockRequisition();
            $list = $this->setStockRequisitionData($requisition);
            return new JsonResponse($list);
        }
    }
    public function getEdit($id)
    {
        $stockRequisition = StockRequisition::find($id);
        $products = new Product();
        $productAll = $products->getProductsWithCategories();
        $parties = new Party();
        $partyAll = $parties->getPartiesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('StockRequisition.edit',compact('stockRequisition'))
            ->with('partyAll',$partyAll)
            ->with('productAll',$productAll)
            ->with('branchAll',$branchAll);
    }

    public function postUpdateIssuedRequisition()
    {
        $ruless = array(
            'issued_quantity' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('requisitions/index')
                ->withErrors($validate);
        }
        else{
            $issuedRequisition = StockRequisition::find(Input::get('id'));
            $issuedRequisition->issued_quantity = Input::get('issued_quantity');;
            $issuedRequisition->save();
            Session::flash('message', 'Stock Requisition Quantity Issued');

            return Redirect::to('requisitions/index');
        }
    }
    private function setStockRequisitionData($requisition)
    {
        $requisition->branch_id = Input::get('branch_id');
        $requisition->product_id = Input::get('product_id');
        $requisition->party_id = Input::get('party_id');
        $requisition->requisition_quantity = Input::get('requisition_quantity');
        $requisition->remarks = Input::get('remarks');
        $requisition->requisition_id = Input::get('requisition_id');
        $requisition->issued_quantity = 0;
        $requisition->user_id = Session::get('user_id');
        $requisition->status = "Activate";
        $requisition->save();
        $requisition = StockRequisition::find($requisition->id);
        $list = $this->requisitionInfoConvertToArray($requisition);
        return $list;
    }

    public function getDelete($id)
    {
        $requisition = StockRequisition::find($id);
        $requisition->delete();
        $message = array('Stock Requisition  Successfully Deleted');
        return new JsonResponse($message);
    }
    private function requisitionInfoConvertToArray($requisitions)
    {
        $array = array();
        $branchName = Branch::find($requisitions->branch_id);
        $array['id'] = $requisitions->id;
        $array['branch'] = $branchName->name;
        $array['product'] = $requisitions->product->name;
        $array['party'] = $requisitions->party->name;
        $array['quantity']   = $requisitions->requisition_quantity;
        $array['remarks'] = $requisitions->remarks;
        return $array;
    }
    public function getDel($id)
    {
        $stock = StockRequisition::find($id);
        $stock->delete();
        Session::flash('message', 'Stock Requisition has been Successfully Deleted.');
        return Redirect::to('requisitions/index');
    }

    public function getProducts($branch_id)
    {

        $poductsNames = Product::where('branch_id','=',$branch_id)
            ->get();

        foreach ($poductsNames as $product) {
            $category = $product->category->name;
            if($product->sub_category_id){
                $subCategory = SubCategory::find($product->sub_category_id);
                $subCategoryName = '('.$subCategory->name.')';
            }else{
                $subCategoryName = '';
            }
            echo "<option value = $product->id > $product->name ($category) $subCategoryName</option> ";

        }
    }

}