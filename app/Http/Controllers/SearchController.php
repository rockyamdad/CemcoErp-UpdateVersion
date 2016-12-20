<?php namespace App\Http\Controllers;

use App\Branch;
use App\Category;
use App\Party;
use App\Product;
use App\ProformaInvoice;
use App\Search;
use App\Stock;
use App\StockInfo;
use App\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {

    }
    public function getEntry()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('Searches.stockEntryType')
            ->with('branchAll',$branchAll);
    }
    public function postSearchResult()
    {
            $branch= Input::get('branch_id');
            $type= Input::get('entry_type');
            $date1 = Input::get('from_date');
            $date2 = Input::get('to_date');
            $search = new Search();
            $results = $search->getResultSearchType($type,$date1,$date2,$branch);

            return view('Searches.stockEntryTypeResult',compact('results'))
                ->with('branch',$branch);
    }
    public function getRequisition()
    {
        $parties = new Party();
        $partyAll = $parties->getPartiesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('Searches.stockRequisition',compact('partyAll'))
            ->with('branchAll',$branchAll);
    }
    public function postRequisitionResult()
    {
            $party = Input::get('party_id');
            $branch= Input::get('branch_id');
            $date1 = Input::get('from_date');
            $date2 = Input::get('to_date');
            $search = new Search();

            $partyName=Party::find($party);

            $results = $search->getResultRequisition($party,$branch,$date1,$date2);

            return view('Searches.requisitionResult',compact('results'))
                ->with('partyName',$partyName);
    }
    public function getStockProducts()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $stockInfos = new StockInfo();
        $allStockInfos = $stockInfos->getStockInfoDropDown();
        $catogories = new Category();
        $categoriesAll = $catogories->getCategoriesDropDown();
        $products = new Product();
        $productAll = $products->getProductsWithCategories();
        return view('Searches.stockProduct',compact('productAll'))
            ->with('categoriesAll',$categoriesAll)
            ->with('allStockInfos',$allStockInfos)
            ->with('branchAll',$branchAll);
    }
    public function postStockProductResult()
    {
        $branch = Input::get('branch_id');
        $stock = Input::get('stock_info_id');
        $category = Input::get('category_id');
        $product = Input::get('product_id');
        $date1 = Input::get('from_date');
        $date2 = Input::get('to_date');
        $search = new Search();
        $results = $search->getResultStockProducts($category,$product,$date1,$date2,$branch,$stock);

        return view('Searches.stockProductResult',compact('results'));

    }
    public  function getProducts($category)
    {
        $productsNames = Product::where('category_id','=',$category)
            ->get();

        foreach ($productsNames as $productName) {

            $category = Category::find($productName->category_id);
            if($productName->sub_category_id){
                $subCategory = SubCategory::find($productName->sub_category_id);
                $subCategoryName = $subCategory->name;
            }else{
                $subCategoryName = '';
            }

            echo "<option value = $productName->id > $productName->name ($category->name) ($subCategoryName)</option> ";

        }
    }
    public function getCategory($branch_id)
    {
        $categoriesName = Category::where('branch_id','=',$branch_id)
            ->get();

        foreach ($categoriesName as $categoryName) {

            echo "<option value = $categoryName->id > $categoryName->name</option> ";

        }
    }

}