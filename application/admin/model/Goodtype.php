<?php
namespace app\admin\model;
use think\Model;
use app\admin\controller\Upload;
class Goodtype extends Model
{
    
    protected $pk = 't_id';

    protected $autoWriteTimestamp = 'datetime'; //时间字段类型

    // 指定自动写入的时间戳字段名
    protected $createTime = 'article_add_time';
    

    public  function getGoodtypes($num=20){
       
        $keywords = input('param.keywords','');
        $where    = "";
        $param = [];
        if($keywords) {
            $param['keywords'] = $keywords;
            $where .= "a.t_name like"."'%".$keywords."%'";
        }
    
        $goodtype  = Goodtype::alias('a')
                    ->where($where)
                    ->order('a.t_id','DESC')
                    ->paginate($num,false,['query' =>$param]);

        
        $page = $goodtype->render();// 获取分页显示


        if($goodtype) {

            return ['code'=>1,'data'=>$goodtype,'msg'=>'数据查询成功','page'=>$page];

        }else{

            return ['code'=>2,'data'=>'','msg'=>'暂无数据','page'=>''];
        }

    } 
    
    
    public function getGoodtype($goodtypeId){

        $goodtype = $this->where("t_id=".$goodsId)->find();
        if($goodtype) {
            $goodtype = $goodtype->toArray();
            return $goodtype;
        }else{
            
            return '';
            
        }
       
    }

    public function addGoodtype($input){
        
        if(request()->isPost()){

            if($input['handle_type'] == 'add') {
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


    public function delGoodtype($goodsId){
        
        $del = $this->where('t_id='.$goodsId)->setField('t_status',2); //删除状态改为2

        if($del) {

            return json(['code'=>1,'msg'=>'删除成功']);

        }else{

            return json(['code'=>0,'msg'=>'删除失败']);
        }
    } 

    public function updateGoodtype($input){
        
        if(request()->isPost()){

            if($input['handle_type'] == 'update') {

                $save = $this->allowField(true)->save($input,$input['t_id']);
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
