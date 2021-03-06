<?php
namespace app\admin\controller;

use app\common\util\PasswordHash;
use think\Db;
use think\Controller;
class Goods  extends AdminBase
{
   
    public function goodsList()   
    {
    	
        
        $goods =  Db::table('yx_goods')->select();


        $this->assign("goods",$goods);

        return $this->fetch();
    }
    
    public function publishGoods() {
       
        $type      = input("param.type",'');
        $category  =  $this->getGoodsCategory();
        if($type=='update') {
            
            $goods =  model('goods')->getGoods(input("param.g_id",''));
            //print_r($goods);
            $goods['goods_category'] = explode(",", $goods['g_type']);
            $this->assign("goods",$goods);
            $this->assign("goods_category",$goods['goods_category']);
        }else{

            $this->assign("goods_category",[]);
        }
        
        $this->assign("category",$category);

        $this->assign("type",$type);

        return $this->fetch();
    }

    
    public function addGoods() {
        $input = input();
        $info  = model('goods')->addGoods($input);

        return $info;
    }

    public function delGoods() {
       $goods_id = input("param.g_id");

       $info  = model('goods')->delGoods($goods_id);

        return $info;

    }

    public function updateGoods() {
        
        $input = input();
        $info  = model('goods')->updateGoods($input);

        return $info;
    }


    public function getGoodsCategory(){
        $cat  = db('goodtype')->select();
        if(!empty($cat)){
            return $cat;
        }else{
            return array();
        }
        
        

        
    }

    
}
