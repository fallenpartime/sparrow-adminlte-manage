<?php
/**
 * 授课服务
 * Date: 2018/12/5
 * Time: 14:25
 */
namespace Admin\Services\Cultivate\Major;

class CourseService
{

    public static function createCourseNo($year, $majorNo, $levelNo, $num)
    {
        $num = sprintf("%03d", $num);
        return "{$year}{$majorNo}{$levelNo}{$num}";
    }
}