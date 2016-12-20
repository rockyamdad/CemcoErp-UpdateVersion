<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Party extends Eloquent
{
    protected $table = 'parties';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function getParties()
    {
        $parties = DB::table('parties')->where('status', 'Activate')->get();
        return $parties;
    }
    public function getSuppliers()
    {
        $parties = DB::table('parties')->where('status','=', 'Activate')
            ->where('type','=','supplier')
            ->get();
        return $parties;
    }
    public function getBuyers()
    {
        $parties = DB::table('parties')->where('status','=', 'Activate')
            ->where('type','=','Buyer')
            ->get();
        return $parties;
    }
    public function getPartiesDropDown()
    {
        $parties = $this->getParties();

        $array = array();

        foreach($parties as $party){
            $array[$party->id] = $party->name;
        }

        return $array;
    }
    public function getSuppliersDropDown()
    {
        $suppliers = $this->getSuppliers();

        $array = array();

        foreach($suppliers as $supplier){
            $array[$supplier->id] = $supplier->name;
        }

        return $array;
    }
    public function getBuyersDropDown()
    {
        $buyers = $this->getBuyers();

        $array = array();

        foreach($buyers as $buyer){
            $array[$buyer->id] = $buyer->name;
        }

        return $array;
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}