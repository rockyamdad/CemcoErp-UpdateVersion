<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceDetail extends Eloquent
{
    protected $table = 'purchase_invoice_details';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function getTotalAmount($invoice_id)
    {
        return DB::table('purchase_invoice_details')
            ->selectRaw('sum(quantity*price) as total')
            ->where('detail_invoice_id', '=', $invoice_id)
            ->get();
    }

    public function getPurchasedue($invoiceId)
    {
        $totalPrice = $this->getTotalAmount($invoiceId);
        $totalAmount = 0;

        $transactions = Transaction::where('invoice_id','=',$invoiceId)
            ->where('payment_method', '=', 'Check')
            ->where('type', '=', 'Payment')
            ->where('cheque_status', '=', 1)->get();


        foreach($transactions as $transaction)
        {
            $totalAmount =$totalAmount + ($transaction->amount);
        }

        $transactions2 = Transaction::where('invoice_id','=',$invoiceId)
            ->where('type', '=', 'Payment')
            ->where('payment_method', '!=', 'Check')->get();
        foreach($transactions2 as $transaction)
        {
            $totalAmount =$totalAmount + ($transaction->amount);
        }

        $due = $totalPrice[0]->total - $totalAmount;
        return $due;



    }

}
