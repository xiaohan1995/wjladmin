<?php
namespace app\admin\model;
use think\Model;
use app\admin\controller\Upload;
class Goods extends Model
{
    
    protected $pk = 'g_id';

    protected $autoWriteTimestamp = 'datetime'; //时间字段类型

    // 指定自动写入的时间戳字段名
    protected $createTime = 'article_add_time';
    

    public  function getGoodss($num=20){
       
        $keywords = input('param.keywords','');
        $where    = "";
        $param = [];
        if($keywords) {
            $param['keywords'] = $keywords;
            $where .= "a.g_name like"."'%".$keywords."%'";
        }
    
        $goods  = Goods::alias('a')
                    ->where($where)
                    ->order('a.g_id','DESC')
                    ->paginate($num,false,['query' =>$param]);

        
        $page = $goods->render();// 获取分页显示


        if($goods) {

            return ['code'=>1,'data'=>$goods,'msg'=>'数据查询成功','page'=>$page];

        }else{

            return ['code'=>2,'data'=>'','msg'=>'暂无数据','page'=>''];
        }

    } 
    
    
    public function getGoods($goodsId){

        $goods = $this->where("g_id=".$goodsId)->find();

        if($goods) {
            $goods = $goods->toArray();

            return $goods;
        }else{
            
            return '';
            
        }
       
    }

    public function addGoods($input){
        
        if(request()->isPost()){

            if($input['handle_type'] == 'add') {

                $upload = new Upload();

                if($_FILES['file']['name']) {
                    $goods_poster_url = $upload->uploadFile('goods');

                    $input['g_img'] = $goods_poster_url;
                }
                

                $save = $this->allowField(true)->save($input);
                
                if($save) {
                    return json(['code'=>1,'msg'=>'保存成功']);

                }else{

                    return json(['code'=>2,'msg'=>'保存失败']);
                }
                
            }else{

               return json(['code'=>4,'msg'=>'非法数据']); 
            }

        }else{
            
               return json(['code'=>5,'msg'=>'非法请求']);
        }
    } 


    public function delGoods($goodsId){
        
        $del = $this->where('g_id='.$goodsId)->setField('g_status',2); //删除状态改为1

        if($del) {

            return json(['code'=>1,'msg'=>'删除成功']);

        }else{

            return json(['code'=>0,'msg'=>'删除失败']);
        }
    } 

    public function updateGoods($input){
        
        if(request()->isPost()){

            if($input['handle_type'] == 'update') {

                $upload = new Upload();

                if($_FILES['file']['name']) {
                    $goods_poster_url = $upload->uploadFile('goods');

                    $input['goods_poster'] = $goods_poster_url;
                }else{

                    $input['goods_poster'] = $input['hide_goods_poster'];
                }
                

                $save = $this->allowField(true)->save($input,$input['g_id']);
                
                if($save) {
                    return json(['code'=>1,'msg'=>'保存成功']);

                }else{

                    return json(['code'=>2,'msg'=>'保存失败']);
                }
                
            }else{

               return json(['code'=>4,'msg'=>'非法数据']); 
            }

        }else{
            
               return json(['code'=>5,'msg'=>'非法请求']);
        }

        
    }
 
}
