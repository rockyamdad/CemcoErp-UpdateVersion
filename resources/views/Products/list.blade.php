@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Product Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('products/index')}}">Product List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Product</div>
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
                        <a class="btn green" href="{{ URL::to('products/create') }}">Add Product &nbsp;&nbsp;<i
                                    class="fa fa-plus"></i></a>
                    </div>

                </div>

                {!!Form::open(array('action'=>'ProductController@postSearch','method' => 'post', 'class'=>'form-horizontal'
                ))!!}
                <div class="form-group">

                    <div class="col-md-4">
                        {!!Form::select('category_id',[null=>'Please Select Category'] +$categoryAll,'null', array('class'=>'form-control ','id'=>'category_id') )!!}
                    </div>
                    <div class="col-md-4">
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">Select Product</option>
                        </select>

                    </div>

                    <div class=" fluid">
                        <div class=" col-md-3">
                            <button type="submit" class="btn blue btn-block " >SEARCH <i class="m-icon-swapright m-icon-white"></i></button>
                        </div>
                    </div>

                </div>

                {!!Form::close()!!}
                <table class="table table-striped table-bordered table-hover" id="product_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Category</th>
                        <th>Sub Category</th>

                        <th>Price</th>
                        <th>Created By</th>
                        @if(Session::get('user_role') == 'admin')
                        <th width="200px;">Action</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @if(count($productsName) > 0)
                        @foreach($productsName as $product )
                            <?php
                            $subCategoryName = \App\SubCategory::find($product->sub_category_id);
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $sl; ?></td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->branch->name}}</td>
                                <td>{{$product->category->name}}</td>
                                @if($product->sub_category_id == 0)
                                    <td>N/A</td>
                                @else
                                    <td>@if($subCategoryName!= null){{$subCategoryName->name}}@else N/A @endif</td>
                                @endif

                                <td>{{$product->price}}</td>
                                <td>{{$product->user->username}}</td>
                                @if(Session::get('user_role') == 'admin')
                                <td>
                                    <a class="btn blue btn-sm" href="{{ URL::to('products/edit/'. $product->id ) }}"><i
                                                class="fa fa-edit"></i>Edit </a>
                                    <a class="btn red btn-sm" href="{{ URL::to('products/delete/'.$product->id)}}"
                                       onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                </td>
                                @endif

                            </tr>
                            <?php
                            $sl++;
                            ?>
                        @endforeach


                    @else
                        @foreach($products as $product )
                            <?php
                            $subCategoryName = \App\SubCategory::find($product->sub_category_id);
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $sl; ?></td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->branch->name}}</td>
                                <td>{{$product->category->name}}</td>
                                @if($product->sub_category_id == 0)
                                    <td>N/A</td>
                                @else
                                    <td>@if($subCategoryName != null){{$subCategoryName->name}}@else N/A @endif</td>
                                @endif

                                <td>{{$product->price}}</td>
                                <td>{{$product->user->username}}</td>
                                @if(Session::get('user_role') == 'admin')
                                <td>
                                    <a class="btn blue btn-sm" href="{{ URL::to('products/edit/'. $product->id ) }}"><i
                                                class="fa fa-edit"></i>Edit </a>
                                    <a class="btn red btn-sm" href="{{ URL::to('products/delete/'.$product->id)}}"
                                       onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                </td>
                                @endif

                            </tr>
                            <?php
                            $sl++;
                            ?>
                        @endforeach

                    @endif



                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
{!! $products->render() !!}
@stop
@section('javascript')
    {!! HTML::script('js/products.js') !!}
@stop