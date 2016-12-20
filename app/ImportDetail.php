<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class ImportDetail extends Eloquent
{
    protected $table = 'import_details';

    public function import()
    {
        return $this->belongsTo('App\Import');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function getLandingCostData($id)
    {
       return DB::table('import_details')
            ->join('products', 'import_details.product_id', '=', 'products.id')
            ->join('imports', 'import_details.import_num', '=', 'imports.id')
            ->join('cnf_costs', 'import_details.import_num', '=', 'cnf_costs.import_id')
            ->join('other_costs', 'import_details.import_num', '=', 'other_costs.import_id')
            ->where('import_details.import_num','=',$id)
            ->get();
    }


}