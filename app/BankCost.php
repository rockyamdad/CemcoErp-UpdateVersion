<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class BankCost extends Eloquent
{
    protected $table = 'bank_costs';
    public function import()
    {
        return $this->belongsTo('App\Import');
    }

}