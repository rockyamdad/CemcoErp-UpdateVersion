<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class StockInfo extends Eloquent
{
    protected $table = 'stock_infos';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function getAllStocks()
    {

        $stocks = StockInfo::where('status','=','Activate')->get();
        return $stocks;
    }

    public function getStockInfoDropDown()
    {
        $stockInfos = $this->getAllStocks();

        $array = array();

        foreach($stockInfos as $stockInfo){
            $array[$stockInfo->id] = $stockInfo->name;
        }

        return $array;
    }
}