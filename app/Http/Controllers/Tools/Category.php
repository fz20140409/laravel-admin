<?php

namespace App\Http\Controllers\Tools;


class Category
{
    //一维
    static function toLevel($cates, $pid = 0, $delimiter = '--', $level = 0)
    {
        $data = array();
        foreach ($cates as $cate) {
            if ($cate['pid'] == $pid) {
                $cate['level'] = $level + 1;
                $cate['delimiter'] = str_repeat($delimiter, $level * 2);
                $data[] = $cate;
                $data = array_merge($data, self::toLevel($cates, $cate['id'], $delimiter, $cate['level']));
            }

        }
        return $data;
    }

    //组成多维数组
    static function toLayer($cates, $name = 'child', $pid = 0)
    {

        $arr = array();
        foreach ($cates as $cate) {
            if ($cate['pid'] == $pid) {
                $cate[$name] = self::toLayer($cates, $name, $cate['id']);
                $arr[] = $cate;
            }
        }

        return $arr;
    }

    /**
     * 生成菜单
     * @param array $cates 原始数据
     * @param string $name
     * @param int $pid
     * @return string
     */
    static function proMenu( array $cates, $name = 'child', $pid = 0)
    {
        $arr = array();
        $html = '';
        foreach ($cates as $cate) {
            if ($cate['pid'] == $pid) {
                $html .= ' <a href="'.route($cate['name']).'"><i class="fa fa-dashboard"></i> <span>' . $cate['display_name'] . '</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a><ul class="treeview-menu">';
                $html .= self::proMenu($cates, $name, $cate['id']);
                $html .= '</ul>';
            }
        }
        return $html ? ' <li class="treeview">' . $html . '</li>' : $html;

    }

}
