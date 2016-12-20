@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product Category Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('productCategories/index')}}">Product Category List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Product Category</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div style="float: left;width: 80%; margin-left: 20px">
                @if (Session::has('message'))
                <div class="alert alert-success">
                    <button data-close="alert" class="close"></button>
                    {{ Session::get('message') }}
                </div>
                @endif
            </div>

            <div class="portlet-body">

                <div class="table-toolbar">
                    <div class="btn-group">
                        <a class="btn green" href="{{ URL::to('productCategories/create') }}">Add Product Category
                            &nbsp;&nbsp;<i class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover" id="category_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Created By</th>
                        @if(Session::get('user_role') == 'admin')
                         <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($categories as $category )
                    <tr class="odd gradeX">
                        <td><?php echo $sl;?></td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->branch->name}}</td>
                        <td>{{$category->user->username}}</td>
                        @if(Session::get('user_role') == 'admin')
                        <td>
                            <a class="btn blue btn-sm"
                               href="{{ URL::to('productCategories/edit/'. $category->id ) }}"><i
                                    class="fa fa-edit"></i>Edit Category</a>
                            <a class="btn red btn-sm" href="{{ URL::to('productCategories/delete/'.$category->id)}}"
                               onclick="return confirm('Are you sure you want to delete this item?');"><i
                                    class="fa fa-trash-o"></i> Delete</a>
                        </td>
                        @endif

                    </tr>
                    <?php
                    $sl++;
                    ?>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $categories->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/productCategories.js') !!}
@stop