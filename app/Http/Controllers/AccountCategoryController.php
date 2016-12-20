<?php namespace App\Http\Controllers;

use App\AccountCategory;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccountCategoryController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
       $categories = AccountCategory::orderBy('id','DESC')->paginate(15);

        return view('AccountCategory.list',compact('categories'));
    }

    public function postSaveAccountCategory()
    {
        $ruless = array(
            'name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('accountcategory/index/')
                ->withErrors($validate);
        }
        else{
            $category = new AccountCategory();
            $this->setAccountData($category);
            $category->save();
            Session::flash('message', 'Account Category has been Successfully Created.');
            return Redirect::to('accountcategory/index');
        }
    }
    public function postUpdate()
    {
        $ruless = array(
            'name' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('accountcategory/index/')
                ->withErrors($validate);
        }
        else{
            $category = AccountCategory::find(Input::get('id'));
            $this->setAccountData($category);
            $category->save();
            Session::flash('message', 'Account Category  has been Successfully Updated.');
            return Redirect::to('accountcategory/index');
        }
    }

    private function setAccountData($category)
    {
        $category->name = Input::get('name');
        $category->user_id = Session::get('user_id');
    }
    public function getDelete($id)
    {
        $product = AccountCategory::find($id);
        $product->delete();
        Session::flash('message', 'Account Category  has been Successfully Deleted.');
        return Redirect::to('accountcategory/index');
    }

}