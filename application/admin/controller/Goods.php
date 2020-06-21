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
           
            $article =  model('article')->getArticle(input("param.article_id",''));
            $article['article_content']  = htmlspecialchars_decode($article['article_content']);
            $article['article_category'] = explode(",", $article['article_category']);
            $this->assign("article",$article);
            $this->assign("article_category",$article['article_category']);
        }else{

            $this->assign("article_category",[]);
        }
        
        $this->assign("category",$category);

        $this->assign("type",$type);

        return $this->fetch();
    }

    
    public function addArticle() {
        $input = input();
        $info  = model('article')->addArticle($input);

        return $info;
    }

    public function delArticle() {
       $article_id = input("param.article_id");

       $info  = model('article')->delArticle($article_id);

        return $info;

    }

    public function updateArticle() {
        
        $input = input();
  
        $info  = model('article')->updateArticle($input);

        return $info;
    }


    public function getGoodsCategory(){
        $cat  = db('yx_goods_type')->select();
        if(!empty($cat)){
            return $cat;
        }else{
            return array();
        }
        
        

        
    }

    
}
