<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class CnfCost extends Eloquent
{
    protected $table = 'cnf_costs';
    public function import()
    {
        return $this->belongsTo('App\Import');
    }

}