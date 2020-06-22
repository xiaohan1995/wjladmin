<?php
namespace app\admin\controller;

use app\common\util\PasswordHash;
use think\Db;
use think\Controller;
class Goodtype  extends AdminBase
{
   
    public function GoodtypeList()   
    {
    	
        
        $goodtype =  Db::table('yx_goods_type')->select();


        $this->assign("goodtype",$goodtype);

        return $this->fetch();
    }
    
    public function publishGoods() {
       
        $type      = input("param.type",'');
        //$category  =  $this->getGoodsCategory();
        if($type=='update') {
            
            $goodtype =  model('goodtype')->getGoodtype(input("param.t_id",''));
            //print_r($goods);
            //$goods['goods_category'] = explode(",", $goods['g_type']);
            $this->assign("goodtype",$goodtype);
            //$this->assign("goods_category",$goods['goods_category']);
        }
        
        //$this->assign("category",$category);

        $this->assign("type",$type);

        return $this->fetch();
    }

    
    public function addGoodtype() {
        $input = input();
        $info  = model('goodtype')->addGoodtype($input);

        return $info;
    }

    public function delGoodtype() {
       $t_id = input("param.t_id");

       $info  = model('goodtype')->delGoodtype($t_id);

        return $info;

    }

    public function updateGoods() {
        
        $input = input();
        $info  = model('goodtype')->updateGoodtype($input);

        return $info;
    }

    
}
