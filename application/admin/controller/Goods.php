<?php
namespace app\admin\controller;

use app\common\util\PasswordHash;
use think\Db;
use think\Controller;
class Goods  extends AdminBase
{
   
    public function goodsList()   
    {
    	
        
        $goods =  Db::table('goods')->select();


        $this->assign("goods",$goods);

        return $this->fetch();
    }
    
    public function getUser() {
        $userId = input('param.user_id');

        $user   = model("User")->getUser($userId);
        
        return $user;
    }
    
    public function getRoles(){

        $roles  = model('Role')->getSelectRoles();

        return $roles ? json(['code'=>1,'roles'=>$roles,'msg'=>'获取数据成功']) : json(['code'=>0,'roles'=>'','msg'=>'获取数据成功']);
    }
    public function addUser(){
        
        $input = input();

        $info  =  model('User')->addUser($input);
       
        return $info;
    }
    
    public function delUser(){
        
        $userId = input('param.user_id');
        
        $info   =  model('User')->delUser($userId);
    
        return $info;
        
    }
    
    public function updateUser(){
           
        $input  = input();
         
        $info   = model('User')->updateUser($input);
        
        return $info;
      
    }

    
}
