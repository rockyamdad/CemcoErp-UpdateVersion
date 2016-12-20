<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Expense extends Eloquent
{
    protected $table = 'expenses';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getExpenseInvoice()
    {
        $expense = DB::table('expenses')->get();
        return $expense;
    }
    public function getExpenseInvoiceDropDown()
    {
        $expenseInvoices = $this->getExpenseInvoice();

        $array = array();

        foreach($expenseInvoices as $invoice){
            $array[$invoice->invoice_id] = $invoice->invoice_id;
        }

        return $array;
    }
}
