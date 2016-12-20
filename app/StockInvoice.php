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

class StockInvoice extends Eloquent
{
    protected $table = 'stock_invoices';
    public function stockdetails()
    {
        return $this->hasMany('App\StockDetail');
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
        $this->stockdetails()->delete();
        return parent::delete();
    }
    public function getStockInvoice()
    {
        $sales = DB::table('stock_invoices')->get();
        return $sales;
    }
    public function getStockInvoiceDropDown()
    {
        $stockInvoices = $this->getStockInvoice();

        $array = array();

        foreach($stockInvoices as $invoice){
            $array[$invoice->invoice_id] = $invoice->invoice_id;
        }

        return $array;
    }

    public static function generateInvoiceId()
    {
        //needs recheck
        $invdesc = StockInvoice::orderBy('id', 'DESC')->first();
        if ($invdesc != null) {
            $invDescId = $invdesc->invoice_id;
            $invDescIdNo = substr($invDescId, 7);

            $subinv1 = substr($invDescId, 6);
            $dd = substr($invDescId, 1, 2);
            $mm = substr($invDescId, 3,2);
            $yy = substr($invDescId, 5, 2);
            //var_dump($invDescId." ".$dd." ".$mm." ".$yy);
            //echo "d1 ".$yy;


            $tz = 'Asia/Dhaka';
            $timestamp = time();
            $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $Today = $dt->format('d.m.Y');

            $explodToday = explode(".", $Today);
            $dd2 = $explodToday[0];
            $mm2 = $explodToday[1];
            $yy1 = $explodToday[2];
            $yy2 = substr($yy1, 2);
            //var_dump($dd2." ".$mm2." ".$yy2);


            if ($dd == $dd2 && $yy == $yy2 && $mm == $mm2) {
                $invoiceidd = "C".$dd2 . $mm2 . $yy2 . ($invDescIdNo + 1);
                //var_dump($invoiceidd);
                return $invoiceidd;
            } else {
                $invoiceidd = "C".$dd2 . $mm2 . $yy2 . "1";
                return $invoiceidd;
            }
        } else {
            $tz = 'Asia/Dhaka';
            $timestamp = time();
            $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $Today = $dt->format('d.m.Y');

            $explodToday = explode(".", $Today);
            $mm2 = $explodToday[1];
            $dd2 = $explodToday[0];
            $yy1 = $explodToday[2];
            $yy2 = substr($yy1, 2);


            $invoiceidd = "C".$dd2 . $mm2 . $yy2 . "1";
            //var_dump($invoiceidd);
            return $invoiceidd;
        }
    }


}