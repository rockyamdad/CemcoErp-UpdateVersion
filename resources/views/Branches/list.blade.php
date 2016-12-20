@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Branch Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ URL::to('dashboard/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('branchList')}}">Branch List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Branches</div>
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

            <div class="portlet-body flip-scroll">

                <div class="table-toolbar">
                    <div class="btn-group">
                        <a class="btn green" href="{{ URL::to('branchAdd') }}">Add Branch &nbsp;&nbsp;<i class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-bordered table-striped table-condensed flip-content" id="branch_table">
                    <thead class="flip-content">
                    <tr>
                        <th>SL</th>
                        <th >Name</th>
                        <th >Location</th>
                        <th >Description</th>
                        <th >Created By</th>
                        <th >Status</th>
                        <th width="200px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($branches as $branch )
                    <tr class="odd gradeX">
                        <td><?php echo $sl;?></td>
                        <td>{{$branch->name}}</td>
                        <td>{{$branch->location}}</td>
                        <td>{{$branch->description}}</td>
                        <td>{{$branch->user->username}}</td>
                        @if($branch->status == "Activate")
                        <td class="branch-status"><span class="label label-sm label-success">Activate</span></td>
                        @else
                        <td class="branch-status"><span class="label label-sm label-danger">Deactivate</span></td>
                        @endif
                        <td>
                            <a class="btn blue btn-sm" href="{{ URL::to('branch/edit/'. $branch->id ) }}"><i class="fa fa-edit"></i>Edit </a>
                            <a data-id="{{$branch->id}}" class="btn btn-sm purple changeStatus" href="{{ URL::to('changeStatusBranch/'.$branch->status.'/'. $branch->id ) }}"><i class="fa fa-link"></i>Change Status</a>

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
{!! $branches->render() !!}
@stop
@section('javascript')
{!! HTML::script('js/branches.js') !!}
@stop