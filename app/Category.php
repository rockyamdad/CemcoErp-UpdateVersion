<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Category extends Eloquent
{
     protected $table = 'product_categories';
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function subcategory()
    {
        return $this->hasOne('App\SubCategory');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function getCategories()
    {

        $categories = DB::table('product_categories')->get();
        return $categories;
    }

    public function getCategoriesDropDown()
    {
        $categories = $this->getCategories();

        $array = array();

        foreach($categories as $category){
            $array[$category->id] = $category->name;
        }

        return $array;
    }
    public function delete()
    {
        $this->subcategories()->delete();
        $this->products()->delete();
        return parent::delete();
    }
}