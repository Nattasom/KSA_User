<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserModel 
{
    //
    public function login($username,$password){
        $response = array();
        $response["status"] = ""; //status response
        $response["user"] = array(); //user object
        $encPassword = md5($password);
        $user = DB::select("select * from mst_user where `Username` = ? AND `Password` = ? AND `Status` = 'A'", [$username,$encPassword]);
        if(count($user) > 0){
            $response["status"] = "01";
            $response["user"] = $user[0];
            //$response["user"]->Menu = $this->getMenuByUser($user[0]->SysUser_ID);
        }
        else {
            $response["status"] = "02";
        }
        return $response;
    }
    public function getUsersTable($resp = array()){
       $where = array();
       $data = array();
        $rowsTotal = 10;
        $searchText = $resp["search"]["value"];
        $sqlCount = "SELECT Count(*) as cc FROM mst_user a INNER JOIN mst_user_role b ON a.UserRoleCode=b.UserRoleCode WHERE 1=1 ";
        $sql = "SELECT a.*,b.UserRoleName FROM mst_user a INNER JOIN mst_user_role b ON a.UserRoleCode=b.UserRoleCode  WHERE 1=1";
        if(!empty($searchText)){
            $sql .=" AND (a.Username LIKE :search OR a.Firstname LIKE :search1 OR a.Lastname LIKE :search2)";
            $sqlCount .=" AND (a.Username LIKE :search OR a.Firstname LIKE :search1 OR a.Lastname LIKE :search2)";
            $where["search"] = "%".$searchText."%";
            $where["search1"] = "%".$searchText."%";
            $where["search2"] = "%".$searchText."%";
        }
        $sql .=" LIMIT ".$resp["start"].",".$resp["length"];
        $sCount = collect(\DB::select($sqlCount,$where))->first();
        $rowsTotal = $sCount->cc;
        $list = DB::select($sql,$where);
        $row = $resp["start"]+1;
        $data["data"] = array();
        foreach($list as $item){
            $username = $item->Username;
            $name = $item->Firstname." ".$item->Lastname;
            $role = $item->UserRoleName;
            if($item->Status == "A"){
                $statusText = '<span class="label label-success">Active</span>';
                $btnActive = '<a  href ="javascript:setActive(\'I\',\''.$username.'\');"  class="btn btn-danger btn-xs" >Inactive</a>';

            }else{
                $statusText = '<span class="label label-danger">Inactive</span>';
                $btnActive = '<a  href ="javascript:setActive(\'A\',\''.$username.'\');"  class="btn btn-success btn-xs" >Active</a>';
            }

            $data["data"][] = array(
                $row,
                $username,
                $name,
                $role,
                $statusText,
                '<a  href ="'.url("/user-edit",[$username]).'" class="btn btn-primary btn-xs btn-edit" >Edit</a> '.$btnActive,
            );
            $row++;
        }
        $data["draw"] = $resp["draw"];
        $data["recordsTotal"] = $rowsTotal;
        $data["recordsFiltered"] = $rowsTotal;
        
        return $data;
   }
   public function GetUser($username){
        $data = array();
        $sql = "SELECT * FROM mst_user WHERE Username = ?";
        $list = DB::select($sql,[$username]);
        foreach($list as $key=>$value){
            $data["username"] = $value->Username;
            $data["fname"] = $value->Firstname;
            $data["lname"] = $value->Lastname;
            $data["role_code"] = $value->UserRoleCode;
            $data["status"] = $value->Status;
        }
        return $data;
   }
   public function UserAdd($params = array()){
        $resp = "00";
       do{
        if($this->CheckDuplicate($params["input_username"])){
            $resp="03";
            break;
        }
        $insertData = array(
            "Username"=>$params["input_username"],
            "Password"=>md5($params["password"]),
            "UserRoleCode"=>$params["role"],
            "Firstname"=>$params["fname"],
            "Lastname"=>$params["lname"],
            "Status"=>$params["status"],
            "CreateBy"=>$params["username"],
            "CreateDate"=>date("Y-m-d H:i:s"),
            "UpdateBy"=>$params["username"],
            "UpdateDate"=>date("Y-m-d H:i:s"),
        );
        $ins = DB::table("mst_user")->insert($insertData);
        if($ins > 0){
            $resp = "01";
        }
       }while(false);
       
       return $resp;
   }
   public function UserEdit($params = array()){
        $resp = "00";
       do{
        if($params["old_username"]!=$params["input_username"]){
            if($this->CheckDuplicate($params["input_username"])){
                $resp="03";
                break;
            }
        }
        
        $updateData = array(
            "Username"=>$params["input_username"],
            "UserRoleCode"=>$params["role"],
            "Firstname"=>$params["fname"],
            "Lastname"=>$params["lname"],
            "Status"=>$params["status"],
            "UpdateBy"=>$params["username"],
            "UpdateDate"=>date("Y-m-d H:i:s"),
        );
        if(array_key_exists("reset_password",$params)){
            $updateData["Password"] = md5($params["password"]);
        }
        
        $ins = DB::table('mst_user')
            ->where('Username', $params["old_username"])
            ->update($updateData);
        if($ins > 0){
            $resp = "01";
        }
       }while(false);
       
       return $resp;
   }
   public function SetUserStatus($params = array()){
        $resp = false;
        $row = DB::update("UPDATE mst_user SET Status = ? WHERE Username = ?",[$params["status"],$params["code"]]);
        if($row > 0){
            $resp = true;
        }
        return $resp;
   }
   public function CheckDuplicate($username){
       $resp = false;
        $res = collect(\DB::select("SELECT Count(*) as cc FROM mst_user WHERE Username = ?",[$username]))->first();
        if($res->cc > 0){
            $resp = true;
        }

        return $resp;
   }

   public function GetRoles(){
       $list = DB::select("select * from mst_user_role ");

       return $list;
   }
   public function getRolesTable($resp = array()){
       $where = array();
       $data = array();
        $rowsTotal = 10;
        $searchText = $resp["search"]["value"];
        $sqlCount = "SELECT Count(*) as cc FROM mst_user_role  WHERE 1=1 ";
        $sql = "SELECT * FROM mst_user_role   WHERE 1=1";
        if(!empty($searchText)){
            $sql .=" AND (UserRoleName LIKE :search )";
            $sqlCount .=" AND (UserRoleName LIKE :search )";
            $where["search"] = "%".$searchText."%";
        }
        $sql .=" LIMIT ".$resp["start"].",".$resp["length"];
        $sCount = collect(\DB::select($sqlCount,$where))->first();
        $rowsTotal = $sCount->cc;
        $list = DB::select($sql,$where);
        $row = $resp["start"]+1;
        $data["data"] = array();
        foreach($list as $item){
            $code = $item->UserRoleCode;
            $role = $item->UserRoleName;
            if($item->Status == "A"){
                $statusText = '<span class="label label-success">Active</span>';
                $btnActive = '<a  href ="javascript:setActive(\'I\',\''.$code.'\');"  class="btn btn-danger btn-xs" >Inactive</a>';

            }else{
                $statusText = '<span class="label label-danger">Inactive</span>';
                $btnActive = '<a  href ="javascript:setActive(\'A\',\''.$code.'\');"  class="btn btn-success btn-xs" >Active</a>';
            }

            $data["data"][] = array(
                $row,
                $code,
                $role,
                $statusText,
                '<a  href ="'.url("/role-edit",[$code]).'" class="btn btn-primary btn-xs btn-edit" >Edit</a> <a  href ="'.url("/role-permission",[$code]).'" class="btn btn-info btn-xs btn-permission" >Permission</a> '.$btnActive,
            );
            $row++;
        }
        $data["draw"] = $resp["draw"];
        $data["recordsTotal"] = $rowsTotal;
        $data["recordsFiltered"] = $rowsTotal;
        
        return $data;
   }
   public function SetRoleStatus($params = array()){
        $resp = false;
        $row = DB::update("UPDATE mst_user_role SET Status = ? WHERE UserRoleCode = ?",[$params["status"],$params["code"]]);
        if($row > 0){
            $resp = true;
        }
        return $resp;
   }
   public function RoleAdd($params = array()){
        $resp = "00";
       do{
        if($this->CheckRoleDuplicate($params["code"])){
            $resp="03";
            break;
        }
        $insertData = array(
            "UserRoleCode"=>$params["code"],
            "UserRoleName"=>$params["name"],
            "Status"=>$params["status"],
            "CreateBy"=>$params["username"],
            "CreateDate"=>date("Y-m-d H:i:s"),
            "UpdateBy"=>$params["username"],
            "UpdateDate"=>date("Y-m-d H:i:s"),
        );
        $ins = DB::table("mst_user_role")->insert($insertData);
        if($ins > 0){
            $resp = "01";
        }
       }while(false);
       
       return $resp;
   }
   public function RoleEdit($params = array()){
        $resp = "00";
       do{
        if($params["old_code"]!=$params["code"]){
            if($this->CheckRoleDuplicate($params["code"])){
                $resp="03";
                break;
            }
        }
        
        $updateData = array(
            "UserRoleCode"=>$params["code"],
            "UserRoleName"=>$params["name"],
            "Status"=>$params["status"],
            "UpdateBy"=>$params["username"],
            "UpdateDate"=>date("Y-m-d H:i:s"),
        );
        
        $ins = DB::table('mst_user_role')
            ->where('UserRoleCode', $params["old_code"])
            ->update($updateData);
        if($ins > 0){
            $resp = "01";
        }
       }while(false);
       
       return $resp;
   }
   public function CheckRoleDuplicate($code){
       $resp = false;
        $res = collect(\DB::select("SELECT Count(*) as cc FROM mst_user_role WHERE UserRoleCode = ?",[$code]))->first();
        if($res->cc > 0){
            $resp = true;
        }

        return $resp;
   }
   public function GetRole($code){
        $data = array();
        $sql = "SELECT * FROM mst_user_role WHERE UserRoleCode = ?";
        $list = DB::select($sql,[$code]);
        foreach($list as $key=>$value){
            $data["role_code"] = $value->UserRoleCode;
            $data["role_name"] = $value->UserRoleName;
            $data["status"] = $value->Status;
        }
        return $data;
   
   }
   public function GetPermission($code){
        $data = array();
        $sqlGroup = "SELECT *
                FROM    cfg_page_group a
                WHERE Parent IS NULL
                Order by a.Seq
        ";
        $group = DB::select($sqlGroup);
        foreach($group as $key=>$value){
            $pages = $this->GetPages($value->PageGroupID,$code);
            $data[]=array(
                "group_id"=>$value->PageGroupID,
                "group_name"=>$value->PageGroupName,
                "has_sub"=>$value->HasSub,
                "icon"=>$value->PageGroupIcon,
                "pages"=>$pages
            );
        }

        return $data;
   }
   public function GetPages($group,$role){
       $resp = array();
        $sql = "SELECT b.*,a.Parent,a.PageGroupName
                FROM cfg_page_group a 
                        INNER JOIN cfg_page b ON a.PageGroupID=b.PageGroupID
                WHERE a.PageGroupID = ? OR a.Parent = ?
                Order By b.Seq
            ";
        $pages = DB::select($sql,[$group,$group]);
        foreach($pages as $key=>$value){
            $actions = array();
            $sqlAction = "SELECT b.PageActionCode,b.PageActionDesc,(SELECT Count(*) FROM mst_user_role_mapping WHERE UserRoleCode = ? 
            AND PageID=b.PageID AND PageActionCode = b.PageActionCode) as RoleCount
                    FROM cfg_page a 
                        INNER JOIN cfg_page_action b ON a.PageID=b.PageID
                    WHERE a.PageID = ?
                    Order by b.Seq
            ";
            $listAction = DB::select($sqlAction,[$role,$value->PageID]);
            foreach ($listAction as $k => $v) {
                $actions[] = array(
                    "action_code"=>$v->PageActionCode,
                    "action_name"=>$v->PageActionDesc,
                    "checked"=>($v->RoleCount > 0) ? "T":"F",
                );
            }
            $resp[]=array(
                "page_id"=>$value->PageID,
                "page_name"=>$value->PageName,
                "page_url"=>$value->PageUrl,
                "real_parent"=>$value->PageGroupName,
                "root_parent"=>$value->Parent,
                "icon"=>$value->PageIcon,
                "actions"=>$actions
            );
        }
        return $resp;
   }
   public function SaveRolePermission($params = array()){
        $resp = "00";
       do{
        $arrSave = explode(',',$params["str_save"]);
        $rowcount = 0;
        DB::delete("DELETE FROM mst_user_role_mapping WHERE  UserRoleCode = ? ",[$params["old_code"]]);
        for($i = 0;$i < count($arrSave);$i++){
            $arrData = explode(':',$arrSave[$i]);
            
            $insData = array(
                "UserRoleCode"=>$params["old_code"],
                "PageID"=>$arrData[1],
                "PageActionCode"=>$arrData[0],
                "UpdateBy"=>$params["username"],
                "UpdateDate"=>date("Y-m-d H:i:s"),
            );
            $rowcount += DB::table("mst_user_role_mapping")->insert($insData);
        }
        if($rowcount == count($arrSave)){
            $resp = "01";
        }
       }while(false);
       
       return $resp;
   }
   
}
