@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Accounts Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('accountcategory/index')}}">Account Category List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Account Category</div>
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
                        <a class="btn green" data-toggle="modal" href="#account_category" >Add Account Category &nbsp;&nbsp;<i class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover" id="accountcategory_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($categories as $category)
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td>{{$category->name}}</td>
                        <td>
                            <a class="btn blue btn-sm editAccount" rel="{{ $category->id }}" data-ref="{{$category->name}}" data-toggle="modal" href="#editAccountCategory" >
                                <i class="fa fa-edit"></i> Edit AccountCategory</a>
                            <a class="btn red btn-sm" href="{{ URL::to('accountcategory/delete/'.$category->id)}}"
                               onclick="return confirm('Are you sure you want to delete this item?');"><i
                                        class="fa fa-trash-o"></i> Delete</a>
                        </td>
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

<div id="account_category" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3>Create Account Category</h3>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/saveAccountCategory', 'method' => 'post', 'class'=>'form-horizontal account_category_form',
                ))!!}
                <div class="form-body">

                    <div class="alert alert-danger display-hide">
                        <button data-close="alert" class="close"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button data-close="alert" class="close"></button>
                        Your form validation is successful!
                    </div>
                    <div class="portlet-body form" id="testt">
                                <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                {!!HTML::decode(Form::label('name','Name<span class="required">*</span>',array('class' =>
                                'control-label col-md-4')))!!}
                                <div class="col-md-7">
                                    {!!Form::text('name',null,array('placeholder' => 'Name', 'class' =>
                                    'form-control','id'=>'name'))!!}
                                </div>
                            </div>

                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    {!!Form::button('Save',array('type' => 'submit','class' => 'btn blue','id' => 'save'))!!}
                                    <button type="button" data-dismiss="modal" class="btn">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!!Form::close()!!}

                </div>
                <!-- <div class="modal-footer">
                     <button type="button" data-dismiss="modal" class="btn">Close</button>
                     <button type="button" class="btn blue">Save changes</button>
                 </div>-->

            </div>
        </div>
    </div>
</div>

<div id="editAccountCategory" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3>Edit Account Category</h3>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/updateAccountCategory', 'method' => 'post', 'class'=>'form-horizontal account_category_form_edit',
              ))!!}
                <div class="form-body">

                    <div class="alert alert-danger display-hide">
                        <button data-close="alert" class="close"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button data-close="alert" class="close"></button>
                        Your form validation is successful!
                    </div>
                    <div class="portlet-body form" id="testt">
                        {!! Form::hidden('id',null,array('id'=>'accountCategoryId'))!!}
                                <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                {!!HTML::decode(Form::label('name','Name<span class="required">*</span>',array('class' =>
                                'control-label col-md-4')))!!}
                                <div class="col-md-7">
                                    {!!Form::text('name',null,array('placeholder' => 'Name', 'class' =>
                                    'form-control ','id'=>'nameEdit'))!!}
                                </div>
                            </div>

                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    {!!Form::button('Update',array('type' => 'submit','class' => 'btn blue','id' => 'save'))!!}
                                    <button type="button" data-dismiss="modal" class="btn">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!!Form::close()!!}

                </div>
                <!-- <div class="modal-footer">
                     <button type="button" data-dismiss="modal" class="btn">Close</button>
                     <button type="button" class="btn blue">Save changes</button>
                 </div>-->

            </div>
        </div>
    </div>
</div>

@stop
@section('javascript')
{!! HTML::script('js/accountCategory.js') !!}
@stop