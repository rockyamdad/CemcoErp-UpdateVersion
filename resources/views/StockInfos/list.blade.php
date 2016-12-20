@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Stock Info Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('stockInfos/index')}}">Stock Info List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Stock Info</div>
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
                        <a class="btn green" href="{{ URL::to('stockInfos/create') }}">Add Stock Info &nbsp;&nbsp;<i class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover" id="stock_info_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Branch</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($stockInfos as $stockInfo )
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td>{{$stockInfo->name}}</td>
                        <td>{{$stockInfo->location}}</td>
                        <td>{{$stockInfo->branch->name}}</td>
                        <td>{{$stockInfo->user->username}}</td>

                        @if($stockInfo->status == "Activate")
                        <td class="stock-status"><span class="label label-sm label-success">Activate</span></td>
                        @else
                        <td class="stock-status"><span class="label label-sm label-danger">Deactivate</span></td>
                        @endif
                        <td>
                            <a class="btn blue btn-sm" href="{{ URL::to('stockInfos/edit/'. $stockInfo->id ) }}"><i class="fa fa-edit"></i>Edit Stock Info</a>
                            <a data-id="{{$stockInfo->id}}" class="btn btn-sm purple changeStatus" href="{{ URL::to('changeStatusStock/'.$stockInfo->status.'/'. $stockInfo->id ) }}"><i class="fa fa-link"></i>Change Status</a>

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
{!! $stockInfos->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/stockInfo.js') !!}
@stop