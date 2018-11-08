<?php

namespace app\Admin\controller;

use think\Request;
use think\Controller;
use app\admin\model\News as NewsModel;  //tp5 存在控制器 和模型的冲突

class News extends Base
{
    //新闻管理添加
    public function add(Request $request)
    {
        if($request->ispost()){
            $data = $request->param();
            //数据校验
            //实例化对调用
            $new = new \app\admin\model\News();     //实例化对象
            //自定义主键
            $new->pk = 'n_id';
            try {
                
                $n_id = $new->add($data);
            } catch (\Exception $e) {
                return ['code'=>config('iauth.error')];
            }
            //是否新建成功
            if($n_id){
                return ['code'=>config('iauth.success'),'jump_url'=>url('news/index')];
            }
        }
        return $this->fetch('',['cate'=>config('cate.lists')]);
    }

    //新闻列表显示
    public function index(Request $request,NewsModel $news)
    {
        $data = $request->param();
        $query = http_build_query($data);       //分页youbug
        //halt($query);
        //tp5 内置分页情况
        //$news = $news->getNews();
        $whereData = [];    //使用闭包的形式实现
        //开始时间 结束时间
        /*if(!empty($data['start_time']) && !empty($data['end_time']) && ($data['end_time'] > $data['start_time'])){
            $whereData['create_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }*/


        /*//分类id
        if(!empty($data['cateid'])){
            $whereData['cateid'] = intval($data['cateid']); //ok
        }*/

        //模糊查询
        /*if(!empty($data['title'])){
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }*/

        //var_dump($query);  //cateid=2&start_time=2018-11-05+20%3A40&end_time=2018-11-06+13%3A59&title=
        
        //模式二   page size form 
        $this->getPageAndSize($data);
        //echo $this->form;
        $total = $news->getNewsCountCondition($whereData,$this->form,$this->size);
        $news = $news->getNewsByCondition($data);
        
        $pageTotal = ceil($total/$this->size);
       
        $cate = config('cate.lists');

    	return $this->fetch('',[
            'news'=>$news,
            'cate'=>$cate,
            'total'=>$total,
            'pageTotal'=>$pageTotal,
            'curr'=>$this->page,
            'start_time'=>empty($data['start_time'])?"":$data['start_time'],
            'end_time'=>empty($data['end_time'])?"":$data['end_time'],
            'cateid'=>empty($data['cateid'])?"":$data['cateid'],
            'title'=>empty($data['title'])?"":$data['title'],
            'query'=>$query
        ]);
    }


}
