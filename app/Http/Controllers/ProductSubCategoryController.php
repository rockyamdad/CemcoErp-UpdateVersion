<?php namespace App\Http\Controllers;

use App\Branch;
use App\Category;
use App\SubCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductSubCategoryController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
        $subCategories = SubCategory::orderBy('id','DESC')->paginate(15);
        //var_dump($categories); die();
        return view('ProductSubCategory.list', compact('subCategories'));
    }
    public function getCreate()
    {
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        return view('ProductSubCategory.add',compact('branchAll'));
    }
    public function postSaveSubCategory()
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
            'category_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('productsubCategories/create')
                ->withErrors($validate);
        }
        else{
            $subCategories = new SubCategory();
            $this->setSubCategoriesData($subCategories);
            $subCategories->save();
            Session::flash('message', 'Product Category has been Successfully Created.');
            return Redirect::to('productsubcategories/index');
        }
    }
    public function getEdit($id)
    {
        $categories = new Category();
        $allCategory = $categories->getCategoriesDropDown();
        $branches = new Branch();
        $branchAll = $branches->getBranchesDropDown();
        $subCategory = SubCategory::find($id);
        return view('ProductSubCategory.edit',compact('branchAll'))
            ->with('subCategory',$subCategory)
            ->with('categoryAll',$allCategory);
    }
    public function postUpdateSubCategory($id)
    {
        $ruless = array(
            'name' => 'required',
            'branch_id' => 'required',
            'category_id' => 'required',
        );
        $validate = Validator::make(Input::all(), $ruless);

        if($validate->fails())
        {
            return Redirect::to('productsubcategories/edit/'.$id)
                ->withErrors($validate);
        }
        else{
            $subCategories = SubCategory::find($id);
            $this->setSubCategoriesData($subCategories);
            $subCategories->save();
            Session::flash('message', 'Product SubCategory has been Successfully Updated.');
            return Redirect::to('productsubcategories/index');
        }
    }
    public function getCategorybybranch($branch_id)
    {
        $categoriesName = Category::where('branch_id','=',$branch_id)
            ->get();

        foreach ($categoriesName as $categoryName) {
            echo "<option value = $categoryName->id > $categoryName->name</option> ";
        }
    }

    private function setSubCategoriesData($SubCategories)
    {
        $SubCategories->name = Input::get('name');
        $SubCategories->branch_id = Input::get('branch_id');
        $SubCategories->category_id = Input::get('category_id');
        $SubCategories->user_id = Session::get('user_id');

    }
    public function getDelete($id)
    {
        $del = SubCategory::find($id);
        try {
            $del->delete();
            Session::flash('message', 'Sub Category has been Successfully Deleted.');
        } catch (Exception $e) {
            Session::flash('message', 'This Sub Category can\'t delete because it  is used to file');
        }

        return Redirect::to('productsubcategories/index');
    }
}