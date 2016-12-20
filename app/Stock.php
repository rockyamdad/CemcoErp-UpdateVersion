<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Stock extends Eloquent
{
    protected $table = 'stocks';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function stockInfo()
    {
        return $this->belongsTo('App\StockInfo');
    }

}