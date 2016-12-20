<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class ProformaInvoice extends Eloquent
{
    protected $table = 'proforma_invoices';
    public function import()
    {
        return $this->belongsTo('App\Import');
    }

}