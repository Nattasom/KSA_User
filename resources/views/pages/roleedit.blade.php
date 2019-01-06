@extends('layouts.default')
@section('title')
Role Edit
@stop
@section('content')
    <div id="page-identity" data-menu="#roles-menu" data-parent=""  data-parent2=""></div>
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Edit  {{$resp['role_code']}}<small></small>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{url('/roles')}}">Role Management</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Edit {{$resp['role_code']}}</a>
            </li>
        </ul>
    </div>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-reorder"></i>Edit Data
            </div>
        </div>
        <div class="portlet-body form">
            <form action="" id="form-role" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="alert alert-warning hide" id="alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Warning!</strong> <span></span>
                    </div>
                    <div class="alert alert-success hide" id="alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Successful!</strong> <span></span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Role Code <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="code" value="{{$resp['role_code']}}"  placeholder="Role Code">
                            <input type="hidden" name="old_code" value="{{$resp['role_code']}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Role Name <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="name" value="{{$resp['role_name']}}"  placeholder="Role Name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <select name="status" id="" class="form-control">
                                <option value="A" {{($resp['status']=='A') ? 'selected' : ''}}>Active</option>
                                <option value="I" {{($resp['status']=='I') ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="action" value="edit" id="hd-action" />
                            <input type="hidden" name="action_url" value="{{url('/action/role-edit')}}" id="hd-action-url" />
                            <button type="submit" class="btn btn-info" id="btn-submit"><i class="fa fa-circle-o-notch fa-spin loader hide"></i> Submit</button>
                            <a href="{{url('/roles')}}" id="btn-back" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('script')
   <script src="{{Config::get('app.root_path')}}/resources/assets/scripts/role.js" type="text/javascript"></script>
   
@stop