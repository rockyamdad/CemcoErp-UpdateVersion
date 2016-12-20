<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class AccountCategory extends Eloquent
{
    protected $table = 'account_categories';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getAccountCategories()
    {

        $catgories = DB::table('account_categories')->get();
        return $catgories;
    }

    public function getAccountCategoriesDropDown()
    {
        $accountCategories = $this->getAccountCategories();

        $array = array();

        foreach($accountCategories as $category){
            $array[$category->id] = $category->name;
        }

        return $array;
    }

}