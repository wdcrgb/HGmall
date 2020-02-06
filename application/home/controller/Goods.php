<?php

namespace app\home\controller;

use think\Controller;

class Goods extends Base
{
    //分类下的商品列表
    public function index($id)
    {
        //查询分类下的商品
        $list = \app\common\model\Goods::where('cate_id', $id)->order('id desc')->paginate(10);
        //查询分类信息
        $cate_info = \app\common\model\Category::find($id);
        //渲染模板
        return view('index', ['list' => $list, 'cate_info' => $cate_info ]);
    }

    //商品详情页
    public function detail($id)
    {
        //$id 是商品id
        //查询商品信息、商品相册、规格商品SKU
        $goods = \app\common\model\Goods::with('goods_images,spec_goods')->find($id);
        //将商品的第一个规格商品的信息，替换到$goods中
        if(!empty($goods['spec_goods'])){
            if($goods['spec_goods'][0]['price'] > 0){
                $goods['goods_price'] = $goods['spec_goods'][0]['price'];
            }
            if($goods['spec_goods'][0]['cost_price'] > 0){
                $goods['cost_price'] = $goods['spec_goods'][0]['cost_price'];
            }
            if($goods['spec_goods'][0]['store_count'] > 0){
                $goods['store_count'] = $goods['spec_goods'][0]['store_count'];
            }else{
                $goods['store_count'] = 0;
            }
        }
        $goods['goods_attr'] = json_decode($goods['goods_attr'], true);
        //查询商品的规格名称规格值 组装数组
        //取出所有相关的规格值id
        $value_ids = array_unique(explode('_', implode('_', array_column($goods['spec_goods'], 'value_ids'))));
        $spec_values = \app\common\model\SpecValue::with('spec')->where('id', 'in', $value_ids)->select();
        //数组结构进行转化
        $res = [];

        foreach($spec_values as $v){
            $res[$v['spec_id']] = [
                'spec_id' => $v['spec_id'],
                'spec_name' => $v['spec_name'],
                'spec_values' => []
            ];
        }

        foreach($spec_values as $v){
            //$v['spec_id']
            $res[$v['spec_id']]['spec_values'][] = $v;
        }

        $value_ids_map = [];
        foreach($goods['spec_goods'] as $v){
            //$v['id']  $v['price']
            $row = [
                'id' => $v['id'],
                'price' => $v['price']
            ];
            $value_ids_map[$v['value_ids']] = $row;
        }
        $value_ids_map = json_encode($value_ids_map);
        return view('detail', ['goods' => $goods, 'specs'=>$res, 'value_ids_map' => $value_ids_map]);
    }
}
