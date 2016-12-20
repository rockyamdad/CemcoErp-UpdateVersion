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

            <li><a href="{{URL::to('accountnames/index')}}">Account Name List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Account Name</div>
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
                        <a class="btn green" data-toggle="modal"  data-target="#ajax" href="{{URL::to('accountnames/create')}}" >Add Account Name &nbsp;&nbsp;<i class="fa fa-plus"></i></a>

                    </div>

                </div>
                <table class="table table-striped table-bordered table-hover" id="accountName_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Branch Name</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Balance</th>
                        <th>Created By</th>
                        <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($accountNames as $accountName)
                        <?php
                                $accounts = \App\AccountCategory::find($accountName->account_category_id);
                                $branch = \App\Branch::find($accountName->branch_id);
                                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td>{{$branch->name}}</td>
                        <td>{{$accountName->name}}</td>
                        <td>{{$accounts->name}}</td>
                        <td>{{$accountName->opening_balance}}</td>
                        <td>{{$accountName->user->username}}</td>
                     <td>
                            <a class="btn blue btn-sm editAccountName" data-toggle="modal"  data-target="#ajax2" href="{{URL::to('accountnames/edit',$accountName->id )}}" >
                                <i class="fa fa-edit"></i> Edit Account Name</a>
                            <a class="btn red btn-sm" href="{{ URL::to('accountnames/delete',$accountName->id)}}"
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
{!! $accountNames->render() !!}

@stop
@section('javascript')
{!! HTML::script('js/accountName.js') !!}
@stop