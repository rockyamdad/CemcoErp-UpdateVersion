@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Order Requisition Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('requisitions/index')}}">Order Requisition List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Order Requisition</div>
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
                @if(Session::get('user_role') != 'manager')
                <div class="table-toolbar">
                    <div class="btn-group">
                        <a class="btn green" href="{{ URL::to('requisitions/create') }}">Make Order Requisition&nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>

                    </div>

                </div>
                @endif
                <table class="table table-bordered table-striped table-condensed flip-content" id="Requisitiontable">
                    <thead class="flip-content">
                    <tr>
                        <th>SL</th>
                        <th>Branch</th>
                        <th>Product</th>
                        <th>Party</th>
                        <th>Req No</th>
                        <th class="numeric">Req Qty</th>
                        <th class="numeric">Issued</th>
                        <th class="numeric">Remaining</th>
                        <th>Remarks</th>
                        <th>Created By</th>
                      <!--  <th>Status</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($requisitions as $requisition )
                    <?php
                        $branchName = \App\Branch::find($requisition->branch_id);
                        $subCategory = \App\SubCategory::find($requisition->product->sub_category_id);
                        $subCategoryName =  '('.$subCategory->name.')';
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td>{{$branchName->name}}</td>
                        <td>{{$requisition->product->name."(".$requisition->product->category->name.")".$subCategoryName}}</td>
                        <td>{{$requisition->party->name}}</td>
                        <td>{{$requisition->requisition_id}}</td>
                        <td class="numeric">{{$requisition->requisition_quantity}}</td>
                        <td class="numeric">{{$requisition->issued_quantity}}</td>
                        <td class="numeric">{{$requisition->requisition_quantity-$requisition->issued_quantity}}</td>
                        <td>{{$requisition->remarks}}</td>
                        <td>{{$requisition->user->username}}</td>
                      <!--  <td>@if($requisition->status == 'Activate')
                            <span class="label label-sm label-success">Activate</span>
                            @else
                            <span class="label label-sm label-danger">DeActivate</span>
                            @endif
                        </td>-->
                        <td>
                            @if( Session::get('user_role') == "admin")
                            {{--<a class="btn blue btn-sm" href="{{ URL::to('requisitions/edit/'. $requisition->id ) }}"><i
                                    class="fa fa-edit"></i>Edit Product</a>--}}
                            <a class="btn red btn-sm" href="{{ URL::to('requisitions/del/'.$requisition->id)}}"
                               onclick="return confirm('Are you sure you want to delete this item?');"><i
                                    class="fa fa-trash-o"></i> Delete</a>
                            @else

                            <a class="btn blue btn-sm issued" rel="{{ $requisition->id }}" data-toggle="modal" href="#issuedRequisition" >
                                   Issued Requisition</a>
                            @endif

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
<div id="issuedRequisition" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3>Issued Requisition</h3>
            </div>
            <div class="modal-body">

                {!!Form::open(array('url' => '/updateIssuedRequisition', 'method' => 'post', 'class'=>'form-horizontal',
                'id'=>'issued_requisition_form'))!!}
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
                        {!! Form::hidden('id',null,array('id'=>'requisitionId'))!!}
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                {!!HTML::decode(Form::label('issued_quantity','Issue Quantity<span class="required">*</span>',array('class' =>
                                'control-label col-md-4')))!!}
                                <div class="col-md-7">
                                    {!!Form::text('issued_quantity',null,array('placeholder' => 'Requisition Quantity', 'class' =>
                                    'form-control','id'=>'requisition_quantity'))!!}
                                </div>
                            </div>

                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    {!!Form::button('Save changes',array('type' => 'submit','class' => 'btn blue','id' => 'save'))!!}
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

{!! $requisitions->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/stockRequisition.js') !!}
{!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop
