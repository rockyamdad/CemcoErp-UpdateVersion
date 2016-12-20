@extends('baseLayout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Import Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>

            <li><a href="{{URL::to('imports/index')}}">Imports List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Imports</div>
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
                        <a class="btn green" href="{{ URL::to('imports/create') }}">Add Import &nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover" id="">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Import Number</th>
                        <th>Consignment</th>
                        <th>Branch</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sl=1;
                    ?>
                    @foreach($imports as $import )
                    <tr class="odd gradeX">

                        <td><?php echo $sl; ?></td>
                        <td>{{$import->import_num}}</td>
                        <td>{{$import->consignment_name}}</td>
                        <td>{{$import->branch->name}}</td>
                        <td>{{$import->description}}</td>
                        <td>{{$import->user->username}}</td>
                        @if($import->status == "Activate")
                        <td class="import-status"><span class="label label-sm label-success">Activate</span></td>
                        @else
                        <td class="import-status"><span class="label label-sm label-danger">Deactivate</span></td>
                        @endif

                        <td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn purple">Actions</button>
                                    <button type="button" class="btn purple dropdown-toggle" data-toggle="dropdown"
                                            data-hover="dropdown" data-delay="1000" data-close-others="true">
                                        <i class="fa fa-angle-down"></i></button>

                                    <ul class="dropdown-menu" role="menu">

                                        <li><a href="{{ URL::to('imports/detail/'. $import->id ) }}"><i
                                                        class="fa fa-plus"></i>Add Details</a></li>
                                        @if(($import->bankcost == null) or ($import->cnfcost == null) or
                                        ($import->othercost == null) or ($import->proformainvoice == null))
                                        <li><a href="{{ URL::to('imports/costs/'. $import->id ) }}"><i
                                                    class="fa fa-plus"></i>Add Cost</a></li>
                                        @endif
                                        <li><a href="{{ URL::to('imports/edit/'. $import->id ) }}"><i
                                                    class="fa fa-edit"></i>Edit </a></li>
                                        <li><a href="{{ URL::to('imports/details/'. $import->id ) }}"
                                              ><i
                                                    class="fa fa-angle-right"></i>Show</a></li>
                                        @if(($import->bankcost != null) and ($import->cnfcost != null) )
                                        <li><a href="{{ URL::to('imports/landingcost/'. $import->id ) }}"><i
                                                    class="fa fa-try"></i>Landing Cost </a>
                                            @endif
                                        <li><a data-id="{{$import->id}}" class="changeStatusImport"
                                               href="{{ URL::to('change-status/'.$import->status.'/'. $import->id ) }}"><i
                                                    class="fa fa-link"></i>Change Status</a></li>
                                        </li>

                                    </ul>
                                </div>
                            </div>
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
{!! $imports->render() !!}
<div class="modal fade" id="myModal">

</div> <!-- /.modal -->


@stop
@section('javascript')
{!! HTML::script('js/imports.js') !!}
@stop