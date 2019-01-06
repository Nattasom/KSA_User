<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new UserModel();
    }
    public function index(Request $request){
        $status = "";
        if ($request->session()->exists('save')) {
            $status=$request->session()->get('save');
            $request->session()->forget('save');
        }
        $data["status"] = $status;
        return view("pages.userlist",$data);
    }
    public function usersDatatable(Request $request){
        $data = $this->model->getUsersTable($request->input());
       
        return response()->json($data);
    }
    public function add(){
        $data["roles"] = $this->model->GetRoles();
        return view("pages.useradd",$data);
    }
    public function edit(Request $request,$id){
        $data["roles"] = $this->model->GetRoles();
        $obj = $this->model->GetUser($id);
        if(!array_key_exists("username",$obj)){
            return redirect("/users");
        }
        $data["resp"] = $obj;
        return view("pages.useredit",$data);
    }
    public function actionAdd(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $params = $request->input();
        $userInfo = $request->session()->get('userinfo');
        $params["username"] = $userInfo->Username;
        $resp = $this->model->UserAdd($params);
        if($resp=="01"){
            $data["status"] = $resp;
            $data["message"] = "Save data successful";
            $request->session()->put('save', $data["status"]);
        }else{
            $data["status"] = $resp;
            $data["message"] = "Can not save data";
            if($resp=="03"){
                $data["message"] = "Username is duplicate";
            }
        }
        return response()->json($data);
    }
    public function actionEdit(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $params = $request->input();
        $userInfo = $request->session()->get('userinfo');
        $params["username"] = $userInfo->Username;
        $resp = $this->model->UserEdit($params);
        if($resp=="01"){
            $data["status"] = $resp;
            $data["message"] = "Save data successful";
        }else{
            $data["status"] = $resp;
            $data["message"] = "Can not save data";
            if($resp=="03"){
                $data["message"] = "Username is duplicate";
            }
        }
        return response()->json($data);
    }
    public function actionStatus(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $resp = $this->model->SetUserStatus($request->input());
        if($resp){
            $data["status"] = "01";
        }
        return response()->json($data);
    }
    public function roles(Request $request){
        $status = "";
        if ($request->session()->exists('save')) {
            $status=$request->session()->get('save');
            $request->session()->forget('save');
        }
        $data["status"] = $status;
        return view("pages.rolelist",$data);
    }
    public function rolesDatatable(Request $request){
        $data = $this->model->getRolesTable($request->input());
       
        return response()->json($data);
    }
    public function actionRoleStatus(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $resp = $this->model->SetRoleStatus($request->input());
        if($resp){
            $data["status"] = "01";
        }
        return response()->json($data);
    }
    public function roleAdd(){
        return view("pages.roleadd");
    }
    public function roleEdit(Request $request,$id){
        $obj = $this->model->GetRole($id);
        if(!array_key_exists("role_code",$obj)){
            return redirect("/roles");
        }
        $data["resp"] = $obj;
        return view("pages.roleedit",$data);
    }
    public function actionRoleAdd(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $params = $request->input();
        $userInfo = $request->session()->get('userinfo');
        $params["username"] = $userInfo->Username;
        $resp = $this->model->RoleAdd($params);
        if($resp=="01"){
            $data["status"] = $resp;
            $data["message"] = "Save data successful";
            $request->session()->put('save', $data["status"]);
        }else{
            $data["status"] = $resp;
            $data["message"] = "Can not save data";
            if($resp=="03"){
                $data["message"] = "Role is duplicate";
            }
        }
        return response()->json($data);
    }
    public function actionRoleEdit(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $params = $request->input();
        $userInfo = $request->session()->get('userinfo');
        $params["username"] = $userInfo->Username;
        $resp = $this->model->RoleEdit($params);
        if($resp=="01"){
            $data["status"] = $resp;
            $data["message"] = "Save data successful";
        }else{
            $data["status"] = $resp;
            $data["message"] = "Can not save data";
            if($resp=="03"){
                $data["message"] = "Role is duplicate";
            }
        }
        return response()->json($data);
    }
    public function actionRolePermission(Request $request){
        $data["status"] = "00";
        $data["message"] = "";
        $params = $request->input();
        $userInfo = $request->session()->get('userinfo');
        $params["username"] = $userInfo->Username;
        $resp = $this->model->SaveRolePermission($params);
        if($resp=="01"){
            $data["status"] = $resp;
            $data["message"] = "Save data successful";
        }else{
            $data["status"] = $resp;
            $data["message"] = "Can not save data";
        }
        return response()->json($data);
    }
    public function rolePermission(Request $request,$id){
        $obj = $this->model->GetRole($id);
        if(!array_key_exists("role_code",$obj)){
            return redirect("/roles");
        }
        $permission = $this->model->GetPermission($id);
        $data["resp"] = $obj;
        $data["permission"] = $permission;
        return view("pages.rolepermission",$data);
    }
}
