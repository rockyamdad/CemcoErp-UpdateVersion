<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class PurchaseInvoice extends Eloquent
{
    protected $table = 'purchase_invoices';
    public function purchaseinvoicedetails()
    {
        return $this->hasMany('App\PurchaseInvoiceDetail');
    }
    public function party()
    {
        return $this->belongsTo('App\Party');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function deletee()
    {
        $this->purchaseinvoicedetails()->delete();
        return parent::delete();
    }
    public function getPurchasesInvoice()
    {
        $purchase = DB::table('purchase_invoices')->get();
        return $purchase;
    }
    public function getPurchaseInvoiceDropDown()
    {
        $purchaseInvoices = $this->getPurchasesInvoice();

        $array = array();

        foreach($purchaseInvoices as $invoice){
            $purchaseDetail = PurchaseInvoiceDetail::where('detail_invoice_id','=',$invoice->invoice_id)->first();
            if($purchaseDetail){
                $array[$invoice->invoice_id] = $invoice->invoice_id;
            }

        }

        return $array;
    }



}
