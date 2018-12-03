<?php
/**
 * 通用工具
 * Date: 2018/12/4
 * Time: 1:03
 */
namespace Admin\Tool;

class CommonTool
{
    /**
     * 分页
     * @param $count
     * @param $perlogs
     * @param $page
     * @param $url
     * @param string $suffix
     * @return array
     */
    public static function pagination($count, $perlogs, $page, $url, $suffix = '')
    {
        /**
         * <div class="row">
         *  <div class="col-sm-5">
         *      <div class="dataTables_info" role="status" aria-live="polite">1 to 10 of 57</div>
         *  </div>
         *  <div class="col-sm-7">
         *      <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
         *          <ul class="pagination">
         *              <li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
         *              <li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li>
         *              <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li>
         *              <li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
         *          </ul>
         *      </div>
         *   </div>
         * </div>
         */
        /**
         * <div class="row">
         *      <div class="col-sm-5">
         *          <div class="dataTables_info" role="status" aria-live="polite">从1到3, 共3记录</div>
         *      </div>
         *      <div class="col-sm-7">
         *          <div class="dataTables_paginate paging_simple_numbers">
         *              <ul class="pagination">
         *                  <li class="paginate_button active"><a href="http://adminlte.test/admin/system/admin/log?search&amp;page=1" tabindex="0">1</a></li>
         *              </ul>
         *          </div>
         *      </div>
         * </div>
         */
        $url .= '&page=';
        $pnums = @ceil($count / $perlogs);
        $re = '';
        for ($i = $page - 3; $i <= $page + 3 && $i <= $pnums; $i++) {
            if ($i > 0) {
                if ($i == $page) {
                    $re .= '<li class="paginate_button active"><a href="'.$url.$i.$suffix.'" tabindex="0">'.$i.'</a></li>';
                } else {
                    $re .= '<li class="paginate_button "><a href="'.$url.$i.$suffix.'" tabindex="0">'.$i.'</a></li>';
                }
            }
        }
        //上一页
        if ($page > 1) {
            $re = '<li class="paginate_button previous"><a href="'.$url.($page-1).$suffix.'" tabindex="0">上一页</a></li>' . $re;
        }
        //下一页
        if ($page < $pnums) {
            $re .= '<li class="paginate_button next"><a href="'.$url.($page+1).$suffix.'" tabindex="0">下一页</a></li>';
        }
        //首页
        if ($page > 1) {
            $re = '<li class="paginate_button previous"><a href="'.$url.'1'.$suffix.'" tabindex="0">首页</a></li>' . $re;
        }
        //尾页
        if ($page + 0 < $pnums) {
            $re .= '<li class="paginate_button next"><a href="' . $url . $pnums . $suffix . '" tabindex="0">尾页</a></li>';
        }
//        if ($pnums <= 1) {
//            $re = '';
//        } else {
//            $re = '<div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination">' . $re;
//            $re .= '</ul></div></div>';
//        }
        $re = '<div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination">' . $re;
        $re .= '</ul></div></div>';
        $url .= $page;
        $startOffset = ($page - 1) * $perlogs;
        if ($startOffset == 0) {
            $startOffset ++;
        }
        $endOffset = $startOffset + $perlogs;
        if ($endOffset > $count) {
            $endOffset = $count;
        }
        $start = '<div class="row">';
        $end = '</div>';
        if ($count == 0) {
            $total = '<div class="col-sm-5"><div class="dataTables_info" role="status" aria-live="polite">共'.$count.'记录</div></div>';
        } else {
            $total = '<div class="col-sm-5"><div class="dataTables_info" role="status" aria-live="polite">从'.$startOffset.'到'.$endOffset.', 共'.$count.'记录</div></div>';
        }
        return [$url, $start.$total.$re.$end];
    }
}