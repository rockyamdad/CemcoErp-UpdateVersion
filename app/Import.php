<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Import extends Eloquent
{
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getImports()
    {
        $imports = DB::table('imports')->get();
        return $imports;
    }

    public function getImportsDropDown()
    {
        $imports = $this->getImports();

        $array = array();

        foreach($imports as $import){
            $array[$import->id] = $import->import_num;
        }

        return $array;
    }
    public function getConsignmentNameDropDown()
    {
        $imports = $this->getImports();

        $array = array();
        $array['N/A'] = 'N/A';
        foreach($imports as $import){
            $array[$import->id] = $import->consignment_name;
        }

        return $array;
    }
    public function details()
    {
        return $this->hasMany('App\ImportDetail');
    }
    /*public function products()
    {
        return $this->hasManyThrough('App\Product','App\ImportDetail');
    }*/
    public function bankcost()
    {
        return $this->hasOne('App\BankCost');
    }
    public function cnfcost()
    {
        return $this->hasOne('App\CnfCost');
    }
    public function othercost()
    {
        return $this->hasOne('App\OtherCost');
    }
    public function proformainvoice()
    {
        return $this->hasOne('App\ProformaInvoice');
    }
    public function getLastImportId()
    {
        return DB::table('imports')->orderBy('id', 'desc')->first();

    }

}