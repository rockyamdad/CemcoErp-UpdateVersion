<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class NameOfAccount extends Eloquent
{
    protected $table = 'name_of_accounts';
    public function account()
    {
        return $this->hasOne('App\AccountCategory');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getAccounts()
    {

        $accounts = NameOfAccount::all();
        return $accounts;
    }

    public function getAccountsDropDown()
    {
        $accounts = $this->getAccounts();

        $array = array();

        foreach($accounts as $account){
            $array[$account->id] = $account->name;
        }

        return $array;
    }
}
