<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        $list = cookie('cart') ?: [];
        $goods_id = 101;
        $spec_goods_id = 211;
        $number = 20;
        $key = $goods_id . '_' . $spec_goods_id;
        if(isset($list[$key])){
            $list[$key]['number'] += $number;
        }else{
            $list[$key] = [
                'goods_id' => $goods_id,
                'spec_goods_id' => $spec_goods_id,
                'number'=>$number,
                'is_selected' => 1
            ];
        }
        cookie('cart', $list, 86400);

        $goods_id = 101;
        $spec_goods_id = 211;
        $number = 20;
        $list = cookie('cart')?:[];
        $key = $goods_id . '_' . $spec_goods_id;
        $list[$key]['number'] = $number;
        cookie('cart', $list, 86400);

        $goods_id = 101;
        $spec_goods_id = 211;
        $list = cookie('cart')?:[];
        $key = $goods_id . '_' . $spec_goods_id;
        unset($list[$key]);
        cookie('cart', $list, 86400);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
