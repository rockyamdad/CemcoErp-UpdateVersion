<?php
/**
 * Created by PhpStorm.
 * User: Aasim
 * Date: 3/1/2016
 * Time: 12:54 AM
 */
namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class StockDetail extends Eloquent
{
    protected $table = 'stock_details';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
//    public function getTotalAmount($invoice_id)
//    {
//        return DB::table('stock_details')
//            ->selectRaw('sum(quantity*price) as total')
//            ->where('invoice_id', '=', $invoice_id)
//            ->get();
//    }

}