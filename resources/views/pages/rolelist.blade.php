@extends('layouts.default')
@section('title')
User Management
@stop
@section('content')
    <div id="page-identity" data-menu="#roles-menu" data-parent=""  data-parent2=""></div>
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Role Management <small></small>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Role Management</a>
            </li>
        </ul>
    </div>
    <!-- TABLE ZONE  -->
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-reorder"></i>Data
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a href="{{url('/role-add')}}" id="" class="btn btn-success">
                             <i class="fa fa-user"></i> Add Role
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- <div class="btn-group pull-right">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="#">
                                    Print </a>
                                </li>
                                <li>
                                    <a href="#">
                                    Save as PDF </a>
                                </li>
                                <li>
                                    <a href="#">
                                    Export to Excel </a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-roles">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role Code</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END TABLE ZONE -->
@stop
@section('script')
<link rel="stylesheet" type="text/css" href="{{Config::get('app.root_path')}}/resources/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
  <!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{Config::get('app.root_path')}}/resources/assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{Config::get('app.root_path')}}/resources/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function() {   
        var ajTable = jQuery("#tb-roles").dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('/datatable/roles')}}",
                "type": "POST",
                "data": function ( d ) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
             "columns": [{
                    "orderable": false
                }, {
                    "orderable": false
                }, {
                    "orderable": false
                },{
                    "orderable": false
                }, {
                    "orderable": false
                }],
            "order": [] 
        });
        
    });
    function reloadTable(){
        $('#tb-roles').DataTable().ajax.reload();
    }
    function setActive(action,code){
        if(confirm("Are you sure to change status this item ?")){
            var params = {};
            params.status = action;
            params.code = code;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{url('/action/role-status')}}",
                type: "POST",
                data: params,
                success: function (result) {
                    reloadTable();
                }
            }).always(function () {
            });
        }
    }
</script>
   
@stop