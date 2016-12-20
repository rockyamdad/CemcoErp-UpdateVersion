<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Branch extends Eloquent
{
    protected $table = 'branches';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    /*public function user()
    {
        return $this->belongsTo('App\User');
    }*/
    public function getBranches()
    {

        $branches = Branch::where('status','=','Activate')->get();
        return $branches;
    }

    public function getBranchesDropDown()
    {
        $branches = $this->getBranches();

        $array = array();

        foreach($branches as $branch){
            $array[$branch->id] = $branch->name;
        }

        return $array;
    }
    public function categories()
    {
        return $this->hasMany('App\Category');
    }
    public function subcategories()
    {
        return $this->hasMany('App\SubCategory');
    }
    public function imports()
    {
        return $this->hasMany('App\Import');
    }
}