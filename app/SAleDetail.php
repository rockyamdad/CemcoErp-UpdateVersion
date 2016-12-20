<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class SAleDetail extends Eloquent
{
    protected $table = 'sale_details';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getTotalAmount($invoice_id)
    {
        return DB::table('sale_details')
            ->selectRaw('sum(quantity*price) as total')
            ->where('invoice_id', '=', $invoice_id)
            ->get();
    }

}
