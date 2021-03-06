<?php
/**
 * Date: 2017/7/14/0014
 * Time: 17:37
 */
namespace Home\Controller;
class SearchController extends CommonController {
    public function cat_search()
    {

//        取出商品数据与分页
        $goodsModel=D('Admin/Goods');
        $data=$goodsModel->cat_search(I('get.catid'));
        //        取出筛选条件（应该根据符合的商品来取，而不能直接用分类下的商品）
        $category_model=D('Admin/category');
        $res=$category_model->getsearchBygoodsId($data['goods_id']);
        $category_model=D('Admin/category');

        $category_info=$category_model->getparent(I('get.catid'));
        $this->assign(array(
            'category_info'=>$category_info,
            'res'=>$res,
            'data'=>$data,
            'page_name'=>'分类搜索',
            'page_keywords'=>'分类搜索',
            'page_description'=>'分类搜索',
        ));
        $this->display();
    }
    public function key_search()
    {
//        根据关键字搜索
//        使用sphinx搜索
//        require_once './sphinxapi.php';
        $sphinx=new \SphinxClient();
        $sphinx->SetServer('localhost',9312);
        $sphinx->setFilter('is_updated',array(0));
        $word=I('get.key');
        $res=$sphinx->Query($word);
        $row=$res['matches'];
        $ids=array_keys($row);
//        取出商品数据与分页
        $goodsModel=D('Admin/Goods');
//      根据关键字搜索
//        $data=$goodsModel->key_search(I('get.key'));
//        根据sphinx搜索
        $data=$goodsModel->key_search($ids);
        //        取出筛选条件（应该根据符合的商品来取，而不能直接用分类下的商品）
        $category_model=D('Admin/category');
        $res=$category_model->getsearchBygoodsId($data['goods_id']);
        $this->assign(array(
            'res'=>$res,
            'data'=>$data,
            'page_name'=>'关键字搜索',
            'page_keywords'=>'关键字搜索',
            'page_description'=>'关键字搜索',
        ));
        $this->display();
    }
}
