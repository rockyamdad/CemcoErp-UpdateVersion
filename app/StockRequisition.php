<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class StockRequisition extends Eloquent
{
    protected $table = 'stock_requisitions';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function party()
    {
        return $this->belongsTo('App\Party');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}