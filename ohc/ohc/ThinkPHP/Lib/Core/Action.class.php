<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * ThinkPHP Action控制器基类 抽象类
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author   liu21st <liu21st@gmail.com>
 */
abstract class Action {

    /**
     * 视图实例对象
     * @var view
     * @access protected
     */
    protected $view = null;

    /**
     * 当前控制器名称
     * @var name
     * @access protected
     */
    private $name = '';

    /**
     * 模板变量
     * @var tVar
     * @access protected
     */
    protected $tVar = array();

    /**
     * 控制器参数
     * @var config
     * @access protected
     */
    protected $config = array();

    /**
     * 搜索页面专用
     * @var type 
     */
    protected $searchtype; //类型 1 为医生查询 2为医院查询 3为医疗项目查询
    protected $limit; //最多显示条数 如用户未登录或者未激活 只显示3条  否则就显示全部
    protected $min; //分页使用  显示几条数据 0为数据库第一条数据 以此类推
    protected $max; //分页使用 为最多数据 如果为2 的话 就只查询出2条
    protected $where;
    protected $page; //此变量为 显示页面的名称
    protected $user; //判断用户是否登录
    protected $pagesize = 15; //最多显示几条
    protected $search_array;
    protected $advance_where;
    protected $advance_text;
    protected $displaypage;
    protected $order;

    /**
     * end
     */

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function __construct() {
        tag('action_begin', $this->config);
        //控制器初始化
        if (method_exists($this, '_initialize')) {
            $this->_initialize();
        }
        //初始化 一些页面配置 设定css和js 路径全局
        $this->getURL();
        //获取当前模块
        $array_s = $_GET['_URL_'];
        $able = -1;
        if (count($array_s) > 0) {
            foreach ($array_s as $k => $v) {
                if ($v == 'l') {
                    $able = $k + 1;
                } else {
                    if ($able != $k) {
                        $str.= $v . '/';
                    }
                }
            }
        } else {  //当前首页
            $str = '';
        }
        $this->assign('operatModel', $str);
    }

    /**
     * 获取当前URL  配置CSS 和 页面 全局路径
     * @access protected
     * PUBLIC 为公共库使用路径
     * PUBLICJSURL 为ajax使用URL 
     */
    protected function getURL() {
        global $PUBLIC;
        global $PUBLICJSURL;
        $domain = $_SERVER['HTTP_HOST'];
        //$domain = $domain == 'localhost' ? 'localhost' : 'www' . strstr($_SERVER['HTTP_HOST'], '.');
//        $domain = $domain == 'localhost' ? 'localhost/ohc' : 'localhost/ohc';
//        $PUBLIC = (is_ssl() ? 'https://' : 'http://') . $domain . '/public';
        //$domain = $domain == 'localhost' ? 'transparentmedicalcare.com/' : 'transparentmedicalcare.com';
       $domain = $domain == 'localhost' ? 'localhost/OHC-/ohc/ohc/' : 'http://localhost/OHC-/ohc/ohc/';
        $PUBLIC = (is_ssl() ? 'https://' : 'http://') . $domain . '/public';
        $PUBLICJSURL = (is_ssl() ? 'https://' : 'http://') . $domain;

        $this->assign('PUBLIC', $PUBLIC);
        $this->assign('PUBLICJSURL', $PUBLICJSURL);
    }

    public function getPageNoAjax($page, $finaCount, $Page_size, $url, $type) {
        global $PUBLICJSURL;
        global $PUBLIC;
        //$url = U($url);
        $Page_size = $Page_size;
        $init = 1;
        $page_len = 4;
        $count = $finaCount;
        $page_count = ceil($count / $Page_size);
        $max_p = $page_count;
        $pages = $page_count;
        if (empty($page) || $page < 0) {  //判断传送的页码
            $page = 1;
        }
        $min = ($Page_size * $page) - $Page_size;
        $max = ($Page_size * $page) - 1;
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1; //页码个数
        $pageoffset = ($page_len - 1) / 2; //页码个数左右偏移量
        $key1 = '<div class="page1' . $type . '">';
        if ($page != 1) {
            if ($type == "seachSmall") {
                $key1.="<span  class='shangyiye$type'>
                <a href=\"$url/p/" . ($page - 1) . "\">&lt;</a>
                </span>";  //上一页
            } else if ($type == "seachBig") {
                $key1.=" <span   class='shouye$type'>
            <a href=\"$url/p/1\">&lt;&lt;</a></span> "; //第一页
                $key1.="<span  class='shangyiye$type'>
            <a href=\"$url/p/" . ($page - 1) . "\">&lt;</a>
            </span>"; //上一页
            } else {
                $key1.=" <span   class='shouye$type'>
                <a href=\"$url/p/1\">&nbsp</a></span> "; //第一页
                $key1.="<span  class='shangyiye$type'>
                <a href=\"$url/p/" . ($page - 1) . "\">&nbsp;</a>
                </span>"; //上一页
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span  class='shangyiye$type'>
                <a href=\"$url/p/" . ($page - 1) . "\">&nbsp;</a>
                </span>";  //上一页
            } else if ($type == "seachBig") {
                $key1.=" <span   class='shouye$type'>
            <a href=\"$url/p/1\">&nbsp;</a></span> "; //第一页
                $key1.="<span  class='shangyiye$type'>
            <a href=\"$url/p/" . ($page - 1) . "\">&nbsp;</a>
            </span>"; //上一页
            } else {
                $key1.="<span  class='shouye$type'>&nbsp;</span>"; //第一页
                $key1.="<span  class='shangyiye$type'>&nbsp;</span>"; //上一页
            }
        }
        if ($pages > $page_len) {//如果当前页小于等于左偏移
            if ($page <= $pageoffset) {
                $init = 1;
                $max_p = $page_len;
            } else {//如果当前页大于左偏移/如果当前页码右偏移超出最大分页数
                if ($page + $pageoffset >= $pages + 1) {
                    $init = $pages - $page_len + 1;
                } else {//左右偏移都存在时的计算
                    $init = $page - $pageoffset;
                    $max_p = $page + $pageoffset;
                }
            }
        }
        for ($i = $init; $i <= $max_p; $i++) {
            if ($i == $page) {
                if ($type == "seachSmall" || $type == "seachBig") {
                    $key1.=' <span class="page_active' . $type . '">' . $i . '</span>';
                } else {
                    $key1.=' <span class="page_active' . $type . ' page">' . $i . '</span>';
                }
            } else {
                if ($type == "seachSmall" || $type == "seachBig") {
                    $key1.=" <span  class='page_class$type ' ><a href=\"$url" . "/p/$i\">" . $i . "</a></span>";
                } else {
                    $key1.=" <span  class='page_class$type page' ><a href=\"$url" . "/p/$i\">" . $i . "</a></span>";
                }
            }
        }

        if ($page != $pages) {
            if ($type == "seachSmall") {
                $key1.=" <span   class='next$type'>
                <a href=\"$url/p/" . ($page + 1) . "\">&gt;</a></span> "; //下一页
            } else if ($type == "seachBig") {
                $key1.=" <span   class='next$type'>
                <a href=\"$url/p/" . ($page + 1) . "\">&gt;</a></span> "; //下一页
                $key1.="<span  class='last$type'>
                <a href=\"$url" . "/p/$page_count\">&gt;&gt;</a>
                </span>"; //最后一页
            } else {
                $key1.=" <span   class='next$type'>
                <a href=\"$url/p/" . ($page + 1) . "\">&nbsp</a></span> "; //下一页
                $key1.="<span  class='last$type'>
                <a href=\"$url" . "/p/$page_count\">&nbsp;</a>
                </span>"; //最后一页
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span class='next$type'>&nbsp;</span>";
            } else if ($type == "seachBig") {
                $key1.="<span class='next$type'>&nbsp;</span>"; //下一页
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            } else {
                $key1.="<span class='next$type'>&nbsp;</span>"; //下一页
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            }
        }
        $key1.='</div>';
        $array = $key1;
        return $array;
    }

    /**
     * 获取当前Action名称
     * @access protected
     */
    protected function getActionName() {
        if (empty($this->name)) {
            // 获取Action名称
            $this->name = substr(get_class($this), 0, -6);
        }
        return $this->name;
    }

    /**
     *   设置用户登录session
     */
    protected function sessionuser($User) {
        $_SESSION['user_id'] = $User['user_id'];
        $_SESSION['user_email'] = $User['user_email'];
        $_SESSION['user_name'] = $User['user_name'];
    }

    /**
     *   修改用户登录session
     */
    protected function sessionuserData($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
      +----------------------------------------------------------
     *  根据 页数 与 总数据 进行分页
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * $type =seachSmall 使用无图片分页
     * $displayAll =no 只能选择三条分页数据 专用于小页面分页！
     */
    public function getPage($page, $finaCount, $Page_size, $scorce, $type, $displayAll = '') {
        global $PUBLICJSURL;
        global $PUBLIC;
        $url = U($url);
        $Page_size = $Page_size;
        $init = 1;
        $page_len = 4;
        $count = $finaCount;
        $page_count = ceil($count / $Page_size);
        $max_p = $page_count;
        $pages = $page_count;
        if (empty($page) || $page < 0) {  //判断传送的页码
            $page = 1;
        }
        $min = ($Page_size * $page) - $Page_size;
        $max = ($Page_size * $page) - 1;
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1; //页码个数
        $pageoffset = ($page_len - 1) / 2; //页码个数左右偏移量
        $key1 = '<div class="page1' . $type . '">';
        if ($page != 1) {
            if ($type == "seachSmall") {
                $key1.="<span  class='shouye$type'  onclick=\"searchCount('page','" . 1 . "','Medical/search/index','" . $scorce . "','' )\">&lt;&lt;</span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"searchCount('page','" . ($page - 1) . "','Medical/search/index','" . $scorce . "','' )\">&lt;</span>"; //上一页               
            } else if ($type == "seachBig") {
                $key1.="<span  class='shouye$type'  onclick=\"searchCount('page','" . 1 . "','Medical/search/index','" . $scorce . "','' )\">&lt;&lt;</span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"searchCount('page','" . ($page - 1) . "','Medical/search/index','" . $scorce . "','' )\">&lt;</span>"; //上一页
            } else {
                $key1.="<span  class='shouye$type'  onclick=\"searchCount('page','" . 1 . "','Medical/search/index','" . $scorce . "','' )\"></span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"searchCount('page','" . ($page - 1) . "','Medical/search/index','" . $scorce . "','' )\"></span>"; //上一页
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span  class='shouye$type'  onclick=\"searchCount('page','" . 1 . "','Medical/search/index','" . $scorce . "','' )\">&nbsp;</span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"searchCount('page','" . ($page - 1) . "','Medical/search/index','" . $scorce . "','' )\">&nbsp;</span>"; //上一页               
            } else if ($type == "seachBig") {
                $key1.="<span  class='shouye$type'  onclick=\"searchCount('page','" . 1 . "','Medical/search/index','" . $scorce . "','' )\">&nbsp;</span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"searchCount('page','" . ($page - 1) . "','Medical/search/index','" . $scorce . "','' )\">&nbsp;</span>"; //上一页
            } else {
                $key1.="<span  class='shouye$type'>&nbsp;</span>"; //第一页
                $key1.="<span  class='shangyiye$type'>&nbsp;</span>"; //上一页
            }
        }
        if ($pages > $page_len) {//如果当前页小于等于左偏移
            if ($page <= $pageoffset) {
                $init = 1;
                $max_p = $page_len;
            } else {//如果当前页大于左偏移/如果当前页码右偏移超出最大分页数
                if ($page + $pageoffset >= $pages + 1) {
                    $init = $pages - $page_len + 1;
                } else {//左右偏移都存在时的计算
                    $init = $page - $pageoffset;
                    $max_p = $page + $pageoffset;
                }
            }
        }
        for ($i = $init; $i <= $max_p; $i++) {
            if ($i == $page) {
                if ($type == "seachSmall" || $type == "seachBig") {
                    $key1.=' <span class="page_active' . $type . '">' . $i . '</span>';
                } else {
                    $key1.=' <span class="page_active' . $type . ' page">' . $i . '</span>';
                }
            } else {
                if ($type == "seachSmall") {
                    if ($displayAll == 'no' && $i > 3) {
                        $key1.=" <span  class='page_class$type' onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','no')\">" . $i . "</span>";
                    } else {
                        $key1.=" <span  class='page_class$type' onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','')\">" . $i . "</span>";
                    }
                } else if ($type == "seachBig") {
                    if ($displayAll == 'no') {
                        $key1.=" <span  class='page_class$type' onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','no')\">" . $i . "</span>";
                    } else {
                        $key1.=" <span  class='page_class$type' onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','')\">" . $i . "</span>";
                    }
                } else {
                    if ($displayAll == 'no' && $i > 3) {
                        $key1.=" <span  class='page_class$type page'  onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','no')\">" . $i . "</span>";
                    } else {
                        $key1.=" <span  class='page_class$type page'  onclick=\"searchCount('page','" . $i . "','Medical/search/index','" . $scorce . "','')\">" . $i . "</span>";
                    }
                }
            }
        }

        if ($page != $pages) {
            if ($type == "seachSmall") {
                if (($page + 1) > 3 && $displayAll == 'no') {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','no')\" class='next$type'>&gt;</span> ";
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','no')\"  class='last$type'>&gt;&gt;</span>"; //最后一页     
                } else {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','')\" class='next$type'>&gt;</span> ";
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','')\"  class='last$type'>&gt;&gt;</span>"; //最后一页
                }
            } else if ($type == "seachBig") {
                if ($displayAll == 'no') {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','no')\" class='next$type'>&gt;</span> "; //下一页
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','no')\"  class='last$type'>&gt;&gt;</span>"; //最后一页                    
                } else {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','')\" class='next$type'>&gt;</span> "; //下一页
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','')\"  class='last$type'>&gt;&gt;</span>"; //最后一页
                }
            } else {
                if ($displayAll == 'no' && ($page + 1) > 3) {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','no')\" class='next$type'>&nbsp;</span> "; //下一页
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','no')\"  class='last$type'>&nbsp;</span>"; //最后一页                    
                } else {
                    $key1.=" <span  onclick=\"searchCount('page','" . ($page + 1) . "','Medical/search/index','" . $scorce . "','')\" class='next$type'>&nbsp;</span> "; //下一页
                    $key1.="<span   onclick=\"searchCount('page','" . $pages . "','Medical/search/index','" . $scorce . "','')\"  class='last$type'>&nbsp;</span>"; //最后一页
                }
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span  class='next$type'>&nbsp;</span>";
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            } else if ($type == "seachBig") {
                $key1.="<span  class='next$type'>&nbsp;</span>"; //下一页
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            } else {
                $key1.="<span  class='next$type'>&nbsp;</span>"; //下一页
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            }
        }
        $key1.='</div>';
        $array = $key1;
        return $array;
    }

    public function getviewPage($page, $finaCount, $Page_size, $scorce, $type, $displayAll = '') {
        global $PUBLICJSURL;
        global $PUBLIC;
        $url = U($url);
        $Page_size = $Page_size;
        $init = 1;
        $page_len = 4;
        $count = $finaCount;
        $page_count = ceil($count / $Page_size);
        $max_p = $page_count;
        $pages = $page_count;
        if (empty($page) || $page < 0) {  //判断传送的页码
            $page = 1;
        }
        $min = ($Page_size * $page) - $Page_size;
        $max = ($Page_size * $page) - 1;
        $page_len = ($page_len % 2) ? $page_len : $page_len + 1; //页码个数
        $pageoffset = ($page_len - 1) / 2; //页码个数左右偏移量
        $key1 = '<div class="page1' . $type . '">';
        if ($page != 1) {
            if ($type == "seachSmall") {
                $key1.="<span   class='shangyiye$type'  onclick=\"viewbodyAjax('page','" . ($page - 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','' )\">&lt;</span>"; //上一页               
            } else {
                $key1.="<span  class='shouye$type'  onclick=\"viewbodyAjax('page','" . 1 . "','Home/Index/viewbodyAjax','" . $scorce . "','' )\"></span> ";     //第一页
                $key1.="<span   class='shangyiye$type'  onclick=\"viewbodyAjax('page','" . ($page - 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','' )\"></span>"; //上一页
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span   class='shangyiye$type'  onclick=\"viewbodyAjax('page','" . ($page - 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','' )\">&nbsp;</span>"; //上一页               
            } else {
                $key1.="<span  class='shouye$type'>&nbsp;</span>"; //第一页
                $key1.="<span  class='shangyiye$type'>&nbsp;</span>"; //上一页
            }
        }
        if ($pages > $page_len) {//如果当前页小于等于左偏移
            if ($page <= $pageoffset) {
                $init = 1;
                $max_p = $page_len;
            } else {//如果当前页大于左偏移/如果当前页码右偏移超出最大分页数
                if ($page + $pageoffset >= $pages + 1) {
                    $init = $pages - $page_len + 1;
                } else {//左右偏移都存在时的计算
                    $init = $page - $pageoffset;
                    $max_p = $page + $pageoffset;
                }
            }
        }
        for ($i = $init; $i <= $max_p; $i++) {
            if ($i == $page) {
                if ($type == "seachSmall") {
                    $key1.=' <span class="page_active' . $type . '">' . $i . '</span>';
                } else {
                    $key1.=' <span class="page_active' . $type . ' page">' . $i . '</span>';
                }
            } else {
                if ($type == "seachSmall") {
                    if ($displayAll == 'no' && $i > 3) {
                        $key1.=" <span  class='page_class$type' onclick=\"viewbodyAjax('page','" . $i . "','Home/Index/viewbodyAjax','" . $scorce . "','no')\">" . $i . "</span>";
                    } else {
                        $key1.=" <span  class='page_class$type' onclick=\"viewbodyAjax('page','" . $i . "','Home/Index/viewbodyAjax','" . $scorce . "','')\">" . $i . "</span>";
                    }
                } else {
                    if ($displayAll == 'no' && $i > 3) {
                        $key1.=" <span  class='page_class$type page'  onclick=\"viewbodyAjax('page','" . $i . "','Home/Index/viewbodyAjax','" . $scorce . "','no')\">" . $i . "</span>";
                    } else {
                        $key1.=" <span  class='page_class$type page'  onclick=\"viewbodyAjax('page','" . $i . "','Home/Index/viewbodyAjax','" . $scorce . "','')\">" . $i . "</span>";
                    }
                }
            }
        }

        if ($page != $pages) {
            if ($type == "seachSmall") {
                if (($page + 1) > 3 && $displayAll == 'no') {
                    $key1.=" <span  onclick=\"viewbodyAjax('page','" . ($page + 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','no')\" class='next$type'>&gt;</span> ";
                } else {
                    $key1.=" <span  onclick=\"viewbodyAjax('page','" . ($page + 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','')\" class='next$type'>&gt;</span> ";
                }
            } else {
                if ($displayAll == 'no' && ($page + 1) > 3) {
                    $key1.=" <span  onclick=\"viewbodyAjax('page','" . ($page + 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','no')\" class='next$type'>&nbsp;</span> "; //下一页
                    $key1.="<span   onclick=\"viewbodyAjax('page','" . $pages . "','Home/Index/viewbodyAjax','" . $scorce . "','no')\"  class='last$type'>&nbsp;</span>"; //最后一页                    
                } else {
                    $key1.=" <span  onclick=\"viewbodyAjax('page','" . ($page + 1) . "','Home/Index/viewbodyAjax','" . $scorce . "','')\" class='next$type'>&nbsp;</span> "; //下一页
                    $key1.="<span   onclick=\"viewbodyAjax('page','" . $pages . "','Home/Index/viewbodyAjax','" . $scorce . "','')\"  class='last$type'>&nbsp;</span>"; //最后一页
                }
            }
        } else {
            if ($type == "seachSmall") {
                $key1.="<span  class='next$type'>&nbsp;</span>";
            } else {
                $key1.="<span  class='next$type'>&nbsp;</span>"; //下一页
                $key1.="<span  class='last$type'>&nbsp;</span>"; //最后一页
            }
        }
        $key1.='</div>';
        $array = $key1;
        return $array;
    }

    /**
     *  用户权限
     */
    public function pageconfig() {
        if (!empty($_REQUEST['searching'])) {
            $this->type = $_REQUEST['searching'];
        }
        $this->where = '';
        $this->advance_where = '';
        $userVal = $_SESSION['user_id'] > 0 ? 1 : 0;
        if ($userVal == 1) {
            $userInfo = M('ohc_user')->where('user_id = ' . $_SESSION['user_id'])->find();
            $this->user = $userInfo['email_activation'] > 0 ? $userVal : 0;
        } else {
            $this->user = 0;
        }
    }
    /**
     * 如用户未登录时 根据ip存储查询次数 如查询次数超过3次 弹出登录界面
     */
    public function ableLogin(){
        if($_SESSION['user_id'] <= 0 ){
            
        }
    }

    /**
     *  获取页面的条数
     */
    public function pagereview($page = 1) {
        $this->page = $page;
        $size = $this->pagesize;
        $temp = ceil($page / 5);
        $this->min = ($temp - 1) * $size;
        $this->max = $size * $temp;
    }

    public function advancedSearch($data) {
        $this->advance_text = $data["search_text"];
        if (!empty($data['search_text_location_hidden']) && $data['search_text_location_hidden'] != 't') {
            $this->search_array['search_text_location'] = trim($data['search_text_location_hidden']);
        } else{
            $this->search_array['search_text_location'] = trim($data['search_text_location']);
        }
        if ($data['search_advanced_type'] == 1) {
            $this->advance_where = '';
            if ($data['search_text_location_hidden'] != 't') {
                $this->search_array['search_text_location'] = trim($data['search_text_location_hidden']);
            }
            $advance_array = array('doctor_search_text', 'hospital_search_text', 'procedure_search_text');
            //判断医生是否有填写 如填写的话 则  
            if ($data['doctor_search_text'] != '') {
                $advance_array_key = array_search("doctor_search_text", $advance_array);
                unset($advance_array[$advance_array_key]);
                $this->advancedWhere($data['doctor_search_text'], $advance_array, $data);
                $this->searchtype = 1;
                $this->advance_text = $data['doctor_search_text'];
            } else if ($data['procedure_search_text'] != '') {
                $advance_array_key = array_search("procedure_search_text", $advance_array);
                unset($advance_array[$advance_array_key]);
                $this->advancedWhere($data['procedure_search_text'], $advance_array, $data);
                $this->searchtype = 3;
                $this->advance_text = $data['procedure_search_text'];
            } else if ($data['hospital_search_text'] != '') {
                $advance_array_key = array_search("hospital_search_text", $advance_array);
                unset($advance_array[$advance_array_key]);
                $this->advancedWhere($data['hospital_search_text'], $advance_array, $data);
                $this->searchtype = 2;
                $this->advance_text = $data['hospital_search_text'];
            }
        } else {
            $this->search_array['search_text'] = trim($data['search_text']);
            $this->searchtype = $data['searching'];
        }
        $this->searchWhere($this->searchtype, $this->search_array['search_text'], $this->search_array['search_text_location']);
    }

    function searchWhere($type, $searchtext, $searchlocation) {
        switch ($type) {
            case '2':$this->hospitalSql($searchtext, $searchlocation);
                break;
            case '3':$this->procudureSql($searchtext, $searchlocation);
                break;
        }
    }

    function advancedWhere($searchVale, $advanceArray, $data) {
        $this->search_array['search_text'] = $searchVale;
        foreach ($advanceArray as $v_advance) {
            if ($data[$v_advance] != '') {
                switch ($v_advance) {
                    case 'hospital_search_text':$advance_str = 'hospitals_name';
                        break;
                    case 'procedure_search_text':$advance_str = 'procedures_name';
                        break;
                }
                $this->advance_where .=' AND ' . $advance_str . ' like "' . trim($data[$v_advance]) . '"';
            }
        }
    }

    /**
     * 是否AJAX请求
     * @access protected
     * @return bool
     */
    protected function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
                return true;
        }
        if (!empty($_POST[C('VAR_AJAX_SUBMIT')]) || !empty($_GET[C('VAR_AJAX_SUBMIT')]))
        // 判断Ajax方式提交
            return true;
        return false;
    }

    /**
     * 模板显示 调用内置的模板引擎显示方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     * @param string $content 输出内容
     * @param string $prefix 模板缓存前缀
     * @return void
     */
    protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        $this->initView();
        $this->view->display($templateFile, $charset, $contentType, $content, $prefix);
    }

    /**
     * 输出内容文本可以包括Html 并支持内容解析
     * @access protected
     * @param string $content 输出内容
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @param string $prefix 模板缓存前缀
     * @return mixed
     */
    protected function show($content, $charset = '', $contentType = '', $prefix = '') {
        $this->initView();
        $this->view->display('', $charset, $contentType, $content, $prefix);
    }

    /**
     *  获取输出页面内容
     * 调用内置的模板引擎fetch方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀* 
     * @return string
     */
    protected function fetch($templateFile = '', $content = '', $prefix = '') {
        $this->initView();
        return $this->view->fetch($templateFile, $content, $prefix);
    }

    /**
     * 初始化视图
     * @access private
     * @return void
     */
    private function initView() {
        //实例化视图类
        if (!$this->view)
            $this->view = Think::instance('View');
        // 模板变量传值
        if ($this->tVar)
            $this->view->assign($this->tVar);
    }

    /**
     *  创建静态页面
     * @access protected
     * @htmlfile 生成的静态文件名称
     * @htmlpath 生成的静态文件路径
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @return string
     */
    protected function buildHtml($htmlfile = '', $htmlpath = '', $templateFile = '') {
        $content = $this->fetch($templateFile);
        $htmlpath = !empty($htmlpath) ? $htmlpath : HTML_PATH;
        $htmlfile = $htmlpath . $htmlfile . C('HTML_FILE_SUFFIX');
        if (!is_dir(dirname($htmlfile)))
        // 如果静态目录不存在 则创建
            mkdir(dirname($htmlfile), 0755, true);
        if (false === file_put_contents($htmlfile, $content))
            throw_exception(L('_CACHE_WRITE_ERROR_') . ':' . $htmlfile);
        return $content;
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return void
     */
    protected function assign($name, $value = '') {
        if (is_array($name)) {
            $this->tVar = array_merge($this->tVar, $name);
        } else {
            $this->tVar[$name] = $value;
        }
    }

    public function __set($name, $value) {
        $this->assign($name, $value);
    }

    /**
     * 取得模板显示变量的值
     * @access protected
     * @param string $name 模板显示变量
     * @return mixed
     */
    public function get($name = '') {
        if ('' === $name) {
            return $this->tVar;
        }
        return isset($this->tVar[$name]) ? $this->tVar[$name] : false;
    }

    public function __get($name) {
        return $this->get($name);
    }

    /**
     * 检测模板变量的值
     * @access public
     * @param string $name 名称
     * @return boolean
     */
    public function __isset($name) {
        return isset($this->tVar[$name]);
    }

    /**
     * 魔术方法 有不存在的操作的时候执行
     * @access public
     * @param string $method 方法名
     * @param array $args 参数
     * @return mixed
     */
    public function __call($method, $args) {
        if (0 === strcasecmp($method, ACTION_NAME . C('ACTION_SUFFIX'))) {
            if (method_exists($this, '_empty')) {
                // 如果定义了_empty操作 则调用
                $this->_empty($method, $args);
            } elseif (file_exists_case(C('TEMPLATE_NAME'))) {
                // 检查是否存在默认模版 如果有直接输出模版
                $this->display();
            } elseif (function_exists('__hack_action')) {
                // hack 方式定义扩展操作
                __hack_action();
            } else {
                _404(L('_ERROR_ACTION_') . ':' . ACTION_NAME);
            }
        } else {
            switch (strtolower($method)) {
                // 判断提交方式
                case 'ispost' :
                case 'isget' :
                case 'ishead' :
                case 'isdelete' :
                case 'isput' :
                    return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method, 2));
                // 获取变量 支持过滤和默认值 调用方式 $this->_post($key,$filter,$default);
                case '_get' : $input = & $_GET;
                    break;
                case '_post' : $input = & $_POST;
                    break;
                case '_put' : parse_str(file_get_contents('php://input'), $input);
                    break;
                case '_param' :
                    switch ($_SERVER['REQUEST_METHOD']) {
                        case 'POST':
                            $input = $_POST;
                            break;
                        case 'PUT':
                            parse_str(file_get_contents('php://input'), $input);
                            break;
                        default:
                            $input = $_GET;
                    }
                    if (C('VAR_URL_PARAMS')) {
                        $params = $_GET[C('VAR_URL_PARAMS')];
                        $input = array_merge($input, $params);
                    }
                    break;
                case '_request' : $input = & $_REQUEST;
                    break;
                case '_session' : $input = & $_SESSION;
                    break;
                case '_cookie' : $input = & $_COOKIE;
                    break;
                case '_server' : $input = & $_SERVER;
                    break;
                case '_globals' : $input = & $GLOBALS;
                    break;
                default:
                    throw_exception(__CLASS__ . ':' . $method . L('_METHOD_NOT_EXIST_'));
            }
            if (!isset($args[0])) { // 获取全局变量
                $data = $input; // 由VAR_FILTERS配置进行过滤
            } elseif (isset($input[$args[0]])) { // 取值操作
                $data = $input[$args[0]];
                $filters = isset($args[1]) ? $args[1] : C('DEFAULT_FILTER');
                if ($filters) {// 2012/3/23 增加多方法过滤支持
                    $filters = explode(',', $filters);
                    foreach ($filters as $filter) {
                        if (function_exists($filter)) {
                            $data = is_array($data) ? array_map($filter, $data) : $filter($data); // 参数过滤
                        }
                    }
                }
            } else { // 变量默认值
                $data = isset($args[2]) ? $args[2] : NULL;
            }
            return $data;
        }
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    protected function error($message, $jumpUrl = '', $ajax = false) {
        $this->dispatchJump($message, 0, $jumpUrl, $ajax);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    protected function success($message, $jumpUrl = '', $ajax = false) {
        $this->dispatchJump($message, 1, $jumpUrl, $ajax);
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data, $type = '') {
        if (func_num_args() > 2) {// 兼容3.0之前用法
            $args = func_get_args();
            array_shift($args);
            $info = array();
            $info['data'] = $data;
            $info['info'] = array_shift($args);
            $info['status'] = array_shift($args);
            $data = $info;
            $type = $args ? array_shift($args) : '';
        }
        if (empty($type))
            $type = C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)) {
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data));
            case 'XML' :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler . '(' . json_encode($data) . ');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default :
                // 用于扩展其他返回格式数据
                tag('ajax_return', $data);
        }
    }

    /**
     * Action跳转(URL重定向） 支持指定模块和延时跳转
     * @access protected
     * @param string $url 跳转的URL表达式
     * @param array $params 其它URL参数
     * @param integer $delay 延时跳转的时间 单位为秒
     * @param string $msg 跳转提示信息
     * @return void
     */
    protected function redirect($url, $params = array(), $delay = 0, $msg = '') {
        $url = U($url, $params);
        redirect($url, $delay, $msg);
    }

    /**
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param Boolean $status 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     */
    private function dispatchJump($message, $status = 1, $jumpUrl = '', $ajax = false) {
        if (true === $ajax || IS_AJAX) {// AJAX提交
            $data = is_array($ajax) ? $ajax : array();
            $data['info'] = $message;
            $data['status'] = $status;
            $data['url'] = $jumpUrl;
            $this->ajaxReturn($data);
        }
        if (is_int($ajax))
            $this->assign('waitSecond', $ajax);
        if (!empty($jumpUrl))
            $this->assign('jumpUrl', $jumpUrl);
        // 提示标题
        $this->assign('msgTitle', $status ? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
        //如果设置了关闭窗口，则提示完毕后自动关闭窗口
        if ($this->get('closeWin'))
            $this->assign('jumpUrl', 'javascript:window.close();');
        $this->assign('status', $status);   // 状态
        //保证输出不受静态缓存影响
        C('HTML_CACHE_ON', false);
        if ($status) { //发送成功信息
            $this->assign('message', $message); // 提示信息
            // 成功操作后默认停留1秒
            if (!isset($this->waitSecond))
                $this->assign('waitSecond', '1');
            // 默认操作成功自动返回操作前页面
            if (!isset($this->jumpUrl))
                $this->assign("jumpUrl", $_SERVER["HTTP_REFERER"]);
            $this->display(C('TMPL_ACTION_SUCCESS'));
        }else {
            $this->assign('error', $message); // 提示信息
            //发生错误时候默认停留3秒
            if (!isset($this->waitSecond))
                $this->assign('waitSecond', '3');
            // 默认发生错误的话自动返回上页
            if (!isset($this->jumpUrl))
                $this->assign('jumpUrl', "javascript:history.back(-1);");
            $this->display(C('TMPL_ACTION_ERROR'));
            // 中止执行  避免出错后继续执行
            exit;
        }
    }

    /**
     * 析构方法
     * @access public
     */
    public function __destruct() {
        // 保存日志
        if (C('LOG_RECORD'))
            Log::save();
        // 执行后续操作
        tag('action_end');
    }

}