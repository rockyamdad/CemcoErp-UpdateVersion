<?php namespace App\Http\Controllers;

use App\Branch;
use App\Category;
use App\Product;
use App\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $products = Product::orderBy('id','DESC')
        ->paginate(25);
        $categories = new Category();
        $categoryAll = $categories->getCategoriesDropDown();
        $category_id = Input::get('category_id');
        $product_id = Input::get('product_id');
        $productsName = Product::where('category_id','=',$category_id)
            ->where('id','=',$product_id)
            ->get();
        return view('Products.list', compact('products'))
            ->with('categoryAll',$categoryAll)
            ->with('productsName',$productsName);
    }
    public function postSearch()
    {
        $products = Product::orderBy('id','DESC')
            ->paginate(25);
        $categories = new Category();
        $categoryAll = $categories->getCategoriesDropDown();
        $category_id = Input::get('category_id');
        $product_id = Input::get('product_id');
        $productsName = Product::where('category_id','=',$category_id)
            ->where('id','=',$product_id)
            ->get();
        return view('Products.search', compact('products'))
            ->with('categoryAll',$categoryAll)
            ->with('productsName',$productsName);
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('Products.add',compact('branchAll'));
    }
    public function postSaveProduct()
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
            'category_id' => 'required',
            'product_type' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('products/create/')
                ->withErrors($validate);
        }
        else{
            $products = new Product();
            $this->setProductsData($products);
            $products->save();
            Session::flash('message', 'Product has been Successfully Created.');
            return Redirect::to('products/index');
        }
    }
    public function getCategory($branch_id)
    {
        $categoriesName = Category::where('branch_id','=',$branch_id)
            ->get();
        $category_id= Input::get('data');

        foreach ($categoriesName as $categoryName) {
            if($categoryName->id==$category_id)
            {
                echo '<option value = "'.$categoryName->id.'" selected> '.$categoryName->name.' </option> ';
            }
            else
            {
                echo "<option value = $categoryName->id > $categoryName->name</option> ";
            }


        }
    }
    public function getSub($category_id)
    {
        $branchId = Input::get('branch_id');
        $sub_category_id= Input::get('data');
        $suCategoriesName = SubCategory::where('category_id','=',$category_id)
                            ->where('branch_id','=',$branchId)
            ->get();
        foreach ($suCategoriesName as $subCategoryName) {
            if($subCategoryName->id==$sub_category_id)
            {
                echo '<option value = "'.$subCategoryName->id.'" selected> '.$subCategoryName->name.' </option> ';
            }
            else
            {
                echo "<option value = $subCategoryName->id > $subCategoryName->name</option> ";
            }

        }
    }
    public function getEdit($id)
    {
        $categories = new Category();
        $allCategory = $categories->getCategoriesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $subCategories = new SubCategory();
        $allSubCategory = $subCategories->getSubCategoriesDropDown();
        $products = Product::find($id);
        return view('Products.edit',compact('branchAll'))
            ->with('products',$products)
            ->with('categoryAll',$allCategory)
            ->with('subCategoryAll',$allSubCategory);
    }
    public function postUpdateProduct($id)
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
            'category_id' => 'required',
            'product_type' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('products/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $products = Product::find($id);
            $this->setProductsData($products);
            $products->save();
            Session::flash('message', 'Product  has been Successfully Updated.');
            return Redirect::to('products/index');
        }
    }

    private function setProductsData($prodcuts)
    {
        $prodcuts->name = Input::get('name');
        $prodcuts->branch_id = Input::get('branch_id');
        $prodcuts->category_id = Input::get('category_id');
        $prodcuts->sub_category_id = Input::get('sub_category_id');
        $prodcuts->origin = Input::get('origin');
        $prodcuts->hs_code = Input::get('hs_code');
        $prodcuts->product_type = Input::get('product_type');
        $prodcuts->total_quantity = 0;
        $prodcuts->price = Input::get('price');
        $prodcuts->user_id = Session::get('user_id');

    }
    public function getDelete($id)
    {
        $product = Product::find($id);
        $product->delete();
        Session::flash('message', 'Product  has been Successfully Deleted.');
        return Redirect::to('products/index');
    }
    public function getProducts($category_id)
    {
        $productsNames = Product::where('category_id','=',$category_id)
            ->get();

        foreach ($productsNames as $product) {
            $category = Category::find($product->category_id);
            $categoryName = $category->name;
            if($product->sub_category_id){
                $subCategory = SubCategory::find($product->sub_category_id);
                if ($subCategory != null) {
                    $subCategoryName = '(' . $subCategory->name . ')';
                }else {
                    $subCategoryName = '';
                }
            }else{
                $subCategoryName = '';
            }

            echo "<option value = $product->id > $product->name ($categoryName) $subCategoryName</option> ";

        }
    }
}