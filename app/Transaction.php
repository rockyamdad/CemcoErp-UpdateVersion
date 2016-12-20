<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Transaction extends Eloquent
{
    protected $table = 'transactions';
    public function accountCategory()
    {
        return $this->belongsTo('App\AccountCategory');
    }
    public function accountName()
    {
        return $this->belongsTo('App\NameOfAccount');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getTotalPaid($invoice_id)
    {
        return DB::table('transactions')
            ->selectRaw('sum(amount) as totalPaid')
            ->where('invoice_id', '=', $invoice_id)
            ->where('type', '=', 'Receive')
            ->get();
    }
    public function getTotalExpensePaid($invoice_id)
    {
        return DB::table('transactions')
            ->selectRaw('sum(amount) as totalPaid')
            ->where('invoice_id', '=', $invoice_id)
            ->where('type', '=', 'Expense')
            ->get();
    }
    public function getTotalPaidPurchase($invoice_id)
    {
        return DB::table('transactions')
            ->selectRaw('sum(amount) as totalPaid')
            ->where('invoice_id', '=', $invoice_id)
            ->where('type', '=', 'Payment')
            ->get();
    }

    public static function convertDate($date){
        $date = strtotime($date);
        return date('d/m/Y', $date);
        //return 'asd';
    }
}
