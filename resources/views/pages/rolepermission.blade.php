@extends('layouts.default')
@section('title')
Role Permission
@stop
@section('content')
    <div id="page-identity" data-menu="#roles-menu" data-parent=""  data-parent2=""></div>
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
    Permission  {{$resp['role_code']}}<small></small>
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
                <a href="#">Permission {{$resp['role_code']}}</a>
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
                        <label class="col-md-3 control-label">Role Code: </label>
                        <div class="col-md-4">
                            <p class="form-control-static">{{$resp['role_code']}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Role Name: </label>
                        <div class="col-md-4">
                            <p class="form-control-static">{{$resp['role_name']}}</p>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-3 control-label">Role Code <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="code" value="{{$resp['role_code']}}"  placeholder="Role Code">
                            <input type="hidden" name="old_code" value="{{$resp['role_code']}}" />
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-3 control-label">Role Name <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="name" value="{{$resp['role_name']}}"  placeholder="Role Name">
                        </div>
                    </div>
                    
                    <div class="form-group hide">
                        <label class="col-md-3 control-label">Status <sup class="required">*</sup></label>
                        <div class="col-md-4">
                            <select name="status" id="" class="form-control">
                                <option value="A" {{($resp['status']=='A') ? 'selected' : ''}}>Active</option>
                                <option value="I" {{($resp['status']=='I') ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div id="permission-group">
                        <table class="table table-bordered">
                            <tbody>
                                @foreach($permission as $key=>$value)
                                <tr class="bg-info">
                                    <td colspan="2"><strong>{{$value['group_name']}}</strong></td>
                                </tr>
                                    
                                    @foreach($value['pages'] as $k=>$v)
                                        @php($i=0)
                                        @foreach($v['actions'] as $k1=>$v1)
                                            @php($page_name = "")
                                            @if($i==0)
                                                @php($page_name=$v["page_name"])
                                            @endif
                                        <tr>
                                            <td style="width:30%;">{{$page_name}}</td>
                                            <td><label for=""><input type="checkbox" data-code="{{$v1['action_code']}}" data-page="{{$v['page_id']}}"  class="chk-action" {{($v1['checked']=='T') ? 'checked':''}}/> {{$v1['action_name']}}</label></td>
                                        </tr>
                                            @php($i+=1)
                                        @endforeach
                                    @endforeach
                                @endforeach
                                
                            </tbody>
                        </table>
                        
                        
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="str_save" id="hd-str-save" />
                            <input type="hidden" name="action" value="permission" id="hd-action" />
                            <input type="hidden" name="action_url" value="{{url('/action/role-permission')}}" id="hd-action-url" />
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