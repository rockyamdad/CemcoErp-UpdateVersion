<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class SubCategory extends Eloquent
{
    protected $table = 'product_sub_categories';
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function getSubCategories()
    {

        $categories = DB::table('product_sub_categories')->get();
        return $categories;
    }

    public function getSubCategoriesDropDown()
    {
        $subCategories = $this->getSubCategories();

        $array = array();

        foreach($subCategories as $subCategory){
            $array[$subCategory->id] = $subCategory->name;
        }

        return $array;
    }
    public function delete()
    {
        $this->products()->delete();
        return parent::delete();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}