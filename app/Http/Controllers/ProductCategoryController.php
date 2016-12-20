<?php namespace App\Http\Controllers;

use App\Branch;
use App\Category;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $categories = Category::orderBy('id','DESC')->paginate(15);
       //var_dump($categories); die();
        return view('ProductCategory.list', compact('categories'));
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('ProductCategory.add',compact('branchAll'));
    }
    public function postSaveCategory()
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('create/')
                ->withErrors($validate);
        }
        else{
            $categories = new Category();
            $this->setCategoriesData($categories);
            $categories->save();
            Session::flash('message', 'Product Category has been Successfully Created.');
            return Redirect::to('productCategories/index');
        }
    }
    public function getEdit($id)
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $category = Category::find($id);
        return view('ProductCategory.edit',compact('branchAll'))
            ->with('category',$category);
    }
    public function postUpdateCategory($id)
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            var_dump("ddd");exit;
            return Redirect::to('productCategories/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $categories = Category::find($id);
            $this->setCategoriesData($categories);
            $categories->save();
            Session::flash('message', 'Product Category has been Successfully Updated.');
            return Redirect::to('productCategories/index');
        }
    }
    public function getDelete($id)
    {
        $del = Category::find($id);
        try {
            $del->delete();
            Session::flash('message', ' Category has been Successfully Deleted.');
        } catch (Exception $e) {
            Session::flash('message', 'This  Category can\'t delete because it  is used to file');
        }

        return Redirect::to('productCategories/index');
    }

    private function setCategoriesData($categories)
    {
        $categories->name = Input::get('name');
        $categories->branch_id = Input::get('branch_id');
        $categories->user_id = Session::get('user_id');

    }
}