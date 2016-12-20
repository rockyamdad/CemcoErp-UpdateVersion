<?php
/**
 * Created by PhpStorm.
 * User: Aasim
 * Date: 3/1/2016
 * Time: 12:39 AM
 */
namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class SalesReturnInvoice extends Eloquent
{
    protected $table = 'sales_return_invoices';
    public function stockreturndetails()
    {
        return $this->hasMany('App\StockReturnDetail');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function deletee()
    {
        $this->stockreturns()->delete();
        return parent::delete();
    }
    public function getSalesReturnInvoice()
    {
        $sales = DB::table('sales_return_invoices')->get();
        return $sales;
    }
    public function getSalesReturnInvoiceDropDown()
    {
        $stockInvoices = $this->getSalesReturnInvoice();

        $array = array();

        foreach($stockInvoices as $invoice){
            $array[$invoice->invoice_id] = $invoice->invoice_id;
        }

        return $array;
    }

}