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

class SalesReturnDetail extends Eloquent
{
    protected $table = 'sales_return_details';
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

}