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

    static function proMenu($layer, $name = 'child')
    {
        $html = '';
        foreach ($layer as $t) {
            //没有子菜单
            if (empty($t[$name])) {
                $html .= ' <li><a href="'.$t['url'].'"><i class="fa fa-circle-o text-red"></i> <span>' . $t['display_name'] . '</span></a></li>';
            } else {
                //子菜单
                $html .= '<li class="treeview"><a href="'.$t['url'].'"><i class="fa fa-share"></i> <span>' . $t['display_name'] . '</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a><ul class="treeview-menu">';
                $html .= self::proMenu($t[$name], $name);
                $html .= '</ul></li>';
            }
        }
        return $html;
    }


}
