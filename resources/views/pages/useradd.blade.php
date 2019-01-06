@extends('layouts.default')
@section('title')
User Add
@stop
@section('content')
    <div id="page-identity" data-menu="#users-menu" data-parent=""  data-parent2=""></div>
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    User Add <small></small>
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="{{url('/users')}}">User Management</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">User Add</a>
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
            <form action="" id="form-user" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="alert alert-warning hide" id="alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Warning!</strong> <span></span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Username <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="input_username"  placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Password <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="password" id="password"  placeholder="Password">
                                <span class="input-group-btn">
                                <button class="btn btn-default" onclick="GetPassword()" type="button">Genarate</button>
                                </span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Firstname <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="fname"  placeholder="Firstname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Lastname <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="lname"  placeholder="Lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Role <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <select name="role" id="" class="form-control">
                                <option value="">Please Select</option>
                                @foreach($roles as $key=>$value)
                                    <option value="{{$value->UserRoleCode}}">{{$value->UserRoleName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <select name="status" id="" class="form-control">
                                <option value="">Please Select</option>
                                <option value="A">Active</option>
                                <option value="I">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="action" value="add" id="hd-action" />
                            <input type="hidden" name="action_url" value="{{url('/action/user-add')}}" id="hd-action-url" />
                            <button type="submit" class="btn btn-info" id="btn-submit"><i class="fa fa-circle-o-notch fa-spin loader hide"></i> Submit</button>
                            <a href="{{url('/users')}}" id="btn-back" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('script')
   <script src="{{Config::get('app.root_path')}}/resources/assets/scripts/user.js" type="text/javascript"></script>
   
@stop