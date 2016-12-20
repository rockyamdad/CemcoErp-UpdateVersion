<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Product extends Eloquent
{

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getProducts()
    {

        $products = DB::table('products')->where('product_type', 'Foreign')->get();
        return $products;
    }
    public function getProductsWithCategories()
    {
        $products =Product::all();

        $array = array();

        foreach($products as $product){
            $category = $product->category->name;
           // $subCategory = $product->subCategory->name;    "."($subCategory) ata add korte hbe sub cat ar jonno
            $array[$product->id] = $product->name."($category)";
        }

        return $array;
    }

    public function getProductsDropDownForeign()
    {
        $products = Product::where('product_type','Foreign')->get();

        $array = array();

        foreach($products as $product){
            $category = $product->category->name;
            $subCategory= $this->getSubCategoryName($product->id);
            if(!empty($subCategory))
            {
                $array[$product->id] = $product->name."($category)".$subCategory[0]->sName;
            }else{
                $array[$product->id] = $product->name."($category)".'(N/A)';
            }

        }

        return $array;
    }
    public function getLocalProductsDropDown()
    {
        $localProducts = Product::where('product_type','Local')->get();

        $array = array();

        foreach($localProducts as $product){
            $array[$product->id] = $product->name;
        }

        return $array;
    }
    public function getFinishGoodsDropDown()
    {
        $finishGoods = Product::where('product_type','Finish Goods')->get();

        $array = array();

        foreach($finishGoods as $finishGood){
            $array[$finishGood->id] = $finishGood->name;
        }

        return $array;
    }
    public function importdetails()
    {
        return $this->belongsToMany('App\importDetail');
    }
    public function stock()
    {
        return $this->hasOne('App\Stock');
    }
    public function getSubCategoryName($id)
    {
        return DB::table('products')
            ->join('product_sub_categories', 'products.sub_category_id', '=', 'product_sub_categories.id')
            ->where('products.id', '=', $id)
            ->select('product_sub_categories.name AS sName'
            )
            ->take(1)
            ->get();
    }

}