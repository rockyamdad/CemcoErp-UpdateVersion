@extends('baseLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Balance Transfer Section
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{URL::to('dashboard/')}}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li><a href="{{URL::to('balancetransfers/index')}}">Balance Transfer List</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i>Balance Transfer</div>
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
                    @if (Session::has('wrong'))
                        <div class="alert alert-danger">
                            <button data-close="alert" class="close"></button>
                            {{ Session::get('wrong') }}
                        </div>
                    @endif
            </div>

            <div class="portlet-body">

                <div class="table-toolbar">
                    <div class="btn-group">
                        <a class="btn green" href="{{ URL::to('balancetransfers/create') }}">Make Balance Transfer &nbsp;&nbsp;<i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="balance_transfer_table">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>From Branch</th>

                        <th>From Account</th>
                        <th>To Branch</th>

                        <th>To Account</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sl=1;
                    ?>
                    @foreach($balanceTransfers as $transfer )
                        <?php
                            $branch1   = \App\Branch::find($transfer->from_branch_id);
                            $branch2   = \App\Branch::find($transfer->to_branch_id);
                            $category1 = \App\AccountCategory::find($transfer->from_account_category_id);
                            $category2 = \App\AccountCategory::find($transfer->to_account_category_id);
                            $account1  = \App\NameOfAccount::find($transfer->from_account_name_id);
                            $account2  = \App\NameOfAccount::find($transfer->to_account_name_id);
                            $user      = \App\User::find($transfer->user_id);
                        ?>
                    <tr class="odd gradeX">
                        <td><?php echo $sl; ?></td>
                        <td>{{$branch1->name}}</td>

                        <td>{{$account1->name."(".$category1->name.")"}}</td>
                        <td>{{$branch2->name}}</td>

                        <td>{{$account2->name."(".$category2->name.")"}}</td>
                        <td>{{$transfer->amount}}</td>
                        <td>{{$transfer->remarks}}</td>
                        <td>{{$user->name}}</td>

                        <td>
                            <a class="btn red btn-sm" href="{{ URL::to('balancetransfers/delete/'.$transfer->id)}}"
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
@stop
@section('javascript')
    {!! HTML::script('js/balancetransfer.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}
@stop