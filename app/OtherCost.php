<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class OtherCost extends Eloquent
{
    protected $table = 'other_costs';
    public function import()
    {
        return $this->belongsTo('App\Import');
    }

}