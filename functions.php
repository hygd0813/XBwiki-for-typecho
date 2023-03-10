<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('INITIAL_VERSION_NUMBER', '1.2');

// 主题设置
function themeConfig($form){
    $logoimg = new Typecho_Widget_Helper_Form_Element_Text('logoimg', NULL, NULL, _t('页头logo地址'), _t('一般为https://www.80srz.com/image.png,支持 https:// 或 //,留空则使用默认图片'));
    $form->addInput($logoimg);
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为https://www.80srz.com/image.ico,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon);
    $gonggao = new Typecho_Widget_Helper_Form_Element_Text('gonggao', NULL, NULL, _t('站点公告'), _t('一段文字或代码，站点公告消息'));
    $form->addInput($gonggao);  
    $ICP = new Typecho_Widget_Helper_Form_Element_Text('ICP', NULL, NULL, _t('ICP备案号'), _t('萌ICP备20221989号'));
    $form->addInput($ICP); 
    $xbwikicdnAddress = new Typecho_Widget_Helper_Form_Element_Text('xbwikicdnAddress', NULL, NULL, _t('CSS文件的链接地址替换'), _t('请输入你的CDN云存储地址，例如：https://cdn.jsdelivr.net/gh/hygd0813/XBwiki@main/，支持绝大部分有镜像功能的CDN服务<br><b>被替换的原地址为主题文件位置，即：https://wiki.80srz.com/usr/themes/XBwiki/</b>'));
    $form->addInput($xbwikicdnAddress);	  
    $themecompress = new Typecho_Widget_Helper_Form_Element_Select('themecompress',array('0'=>'不开启','1'=>'开启'),'0','HTML压缩功能','是否开启HTML压缩功能,缩减页面代码');
    $form->addInput($themecompress);
    $GEditor = new Typecho_Widget_Helper_Form_Element_Select(
        'GEditor',
        array(
            'on' => '开启（默认）',
            'off' => '关闭',
        ),
        'on',
        '是否启用自定义编辑器',
        '介绍：开启后，文章编辑器将替换成编辑器 <br>
         其他：目前编辑器处于拓展阶段，如果想继续使用原生编辑器，关闭此项即可'
    );
    $form->addInput($GEditor->multiMode());
    $csscode = new Typecho_Widget_Helper_Form_Element_Textarea('csscode', NULL, NULL, _t('自定义CSS样式'), _t('直接写css，无需 style 标签'));
    $form->addInput($csscode);    
    $Keywordspress = new Typecho_Widget_Helper_Form_Element_Textarea('Keywordspress', NULL, NULL, _t('关键字内链<b style="color: red;">✱</b>'), _t('文章详情页自动关键词链接,每行1组以"<b style="color: red;">关键词|(半角竖线)链接</b>"形式)'));
    $form->addInput($Keywordspress);   
    $postdownads = new Typecho_Widget_Helper_Form_Element_Textarea('postdownads', NULL, NULL, _t('内容页下方ads'), _t('内容页下方ads,图片建议800*200px，内容随意！'));
    $form->addInput($postdownads);			  
    $postrightads = new Typecho_Widget_Helper_Form_Element_Textarea('postrightads', NULL, NULL, _t('内容页右侧ads'), _t('内容页右侧ads,图片建议240*240px，内容随意！'));
    $form->addInput($postrightads); 
    $zztj = new Typecho_Widget_Helper_Form_Element_Textarea('zztj', NULL, NULL, _t('网站统计代码'), _t('在这里填入你的网站统计代码,这个可以到百度统计或者cnzz上申请。'));
    $form->addInput($zztj);

}

//自定义字段
function themeFields ($layout) {
    $keyword = new Typecho_Widget_Helper_Form_Element_Textarea('keyword', NULL, NULL, _t('keywords关键词'), _t('多个关键词用英文下逗号隔开'));
    $description = new Typecho_Widget_Helper_Form_Element_Textarea('description', NULL, NULL, _t('description描述'), _t('简单一句话描述'));
    $layout->addItem($keyword);
    $layout->addItem($description);
  
}

/**设置CDN**/
function XBwikiUrl($path) {
    $options = Helper::options();
    $ver = '?ver='.constant("INITIAL_VERSION_NUMBER");
    if ($options->XBwikicdnAddress) {
        echo rtrim($options->XBwikicdnAddress, '/').'/'.$path.$ver;
    } else {
        $options->themeUrl($path.$ver);
    }
}

/* 加强后台编辑器功能 */
if (Helper::options()->GEditor !== 'off') {
    Typecho_Plugin::factory('admin/write-post.php')->richEditor  = array('Editor', 'Edit');
    Typecho_Plugin::factory('admin/write-page.php')->richEditor  = array('Editor', 'Edit');
}
class Editor
{
    public static function Edit()
    {
?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prism-theme-one-light-dark@1.0.4/prism-onedark.min.css">
        <link rel="stylesheet" href="<?php Helper::options()->themeUrl('lib/write/css/joe.write.min.css') ?>">
        <script>
            window.JoeConfig = {
                uploadAPI: '<?php Helper::security()->index('/action/upload'); ?>',
                emojiAPI: '<?php Helper::options()->themeUrl('lib/write/json/emoji.json') ?>',
                expressionAPI: '<?php Helper::options()->themeUrl('lib/write/json/expression.json') ?>',
                characterAPI: '<?php Helper::options()->themeUrl('lib/write/json/character.json') ?>',
                autoSave: <?php Helper::options()->autoSave(); ?>,
                themeURL: '<?php Helper::options()->themeUrl(); ?>',
                canPreview: false
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/typecho-joe-next@6.2.4/plugin/prism/prism.min.js"></script>
        <script src="<?php Helper::options()->themeUrl('lib/write/parse/parse.min.js') ?>"></script>
        <script src="<?php Helper::options()->themeUrl('lib/write/dist/index.bundle.js') ?>"></script>
<?php
    }
}

/**
* 阅读统计
* 调用<?php get_post_view($this); ?>
*/
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    return $exist == 0 ? '0' : $exist.' ';
}

//文章阅读时间统计
function art_time ($cid){
    $db=Typecho_Db::get ();
    $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);
    $text_word = mb_strlen($text,'utf-8');
    echo ceil($text_word / 180);
}

/**
* 显示下一篇
*
* @access public
* @param string $default 如果没有下一篇,显示的默认文字
* @return void
*/
function theNext($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created > ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_ASC)
->limit(1);
$content = $db->fetchRow($sql);
if ($content) {
$content = $widget->filter($content);

echo '<a class="pager-link next" href="' . $content['permalink'] . '" ><span class="desc" >下一篇<i class="fa fa-angle-right" style="padding-left:15px;"></i></span><span class="title" >' . $content['title'] . '</span></a>';


} else {
echo $default;
}}

/**
* 显示上一篇
*
* @access public
* @param string $default 如果没有下一篇,显示的默认文字
* @return void
*/
function thePrev($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created < ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_DESC)
->limit(1);
$content = $db->fetchRow($sql);
if ($content) {
   
$content = $widget->filter($content);

echo '<a class="pager-link prev" href="' . $content['permalink'] . '" ><span class="desc" ><i class="fa fa-angle-left" style="padding-right:15px;"></i>上一篇</span><span class="title" >' . $content['title'] . '</span></a>';

}   
else {
echo $default;
}}

/** HTML压缩功能 */
function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

/**
 * 文章内容替换为内链
 * @param $content
 * @return mixed
 */
function get_glo_keywords($content)
{   
	$settings = Helper::options()->Keywordspress;	
	$keywords_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$keywords_list[] = explode('|',$kwset);
			}
		}
	ksort($keywords_list);  //对关键词排序，短词排在前面
	
    if($keywords_list){
        $readnum = 0;
		$i = 0;
		$j = 1;
        foreach ($keywords_list as $key => $val) {
			
            $title = $val[$i];
            $len = strlen($title);
            $str = '<a href="'.$val[$j].'" target="_blank">'.$title.'</a>';
            $str_index = mb_strpos($content, $title);            
			$content = preg_replace('/(?!<[^>]*)'.$title.'(?![^<]*>)/',$str,$content,1); 
			
            if(is_numeric($str_index)){
                $readnum += 1;
                //$content = substr_replace($content,$str,$str_index,$len);
                //$content = $this->str_replace_limit($title,$str,$content,$this->limit);
            }
            if($readnum == 8) {
			return $content; //匹配到8个关键词就退出
			$i += 2;
            $j += 2;
            }
		}
    }
    return $content;
}

//文章目录
function createCatalog($obj) {    //为文章标题添加锚点
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-4])(.*?)>(.*?)<\/h\1>/i', function($obj) {
        global $catalog;
        global $catalog_count;
        $catalog_count ++;
        $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
        return '<h'.$obj[1].$obj[2].'><a name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
    }, $obj);
    return $obj;
}

function getCatalog() {    //输出文章目录容器
    global $catalog;
    $index = '';
    if ($catalog) {
        $index = '<ul>'."\n";
        $prev_depth = '';
        $to_depth = 0;
        foreach($catalog as $catalog_item) {
            $catalog_depth = $catalog_item['depth'];
            if ($prev_depth) {
                if ($catalog_depth == $prev_depth) {
                    $index .= '</li>'."\n";
                } elseif ($catalog_depth > $prev_depth) {
                    $to_depth++;
                    $index .= '<ul>'."\n";
                } else {
                    $to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
                    if ($to_depth2) {
                        for ($i=0; $i<$to_depth2; $i++) {
                            $index .= '</li>'."\n".'</ul>'."\n";
                            $to_depth--;
                        }
                    }
                    $index .= '</li>';
                }
            }
            $index .= '<li><a href="#cl-'.$catalog_item['count'].'"style="color: #1B8AFF;">'.$catalog_item['text'].'</a>';
            $prev_depth = $catalog_item['depth'];
        }
        for ($i=0; $i<=$to_depth; $i++) {
            $index .= '</li>'."\n".'</ul>'."\n";
        }
    $index = '<div class="ax-scrollnav-v" id="article-nav01" ><p style="font-color:#999;text-align:center;font-size:18px;border-bottom:1px dashed #999;">文 章 目 录</p>'."\n".'<span class="icon-list" style="cursor:pointer"></span>'."\n".'<div class="fn_article_nav">'."\n"."\n".'<div class="toc">'."\n".$index.'</div>';
    }
    echo $index;
}

function themeInit($archive) {
    if ($archive->is('single')) {
        if (1) {
            $archive->content = get_glo_keywords($archive->content);//文章内容关键词替换
            $archive->content = createCatalog($archive->content);//文章目录树
        }
    }
}

//编辑添加标签
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tagshelper', 'tagslist');
class tagshelper {
    public static function tagslist()
    {      
    $tag="";$taglist="";$i=0;//循环一次利用到两个位置
Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
$tag=$tag."'".$tags->name."',";
$taglist=$taglist."<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
?><style>.Posthelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.Posthelper a:hover{background: #ccc;color: #fff;}.fullscreen #tab-files{right: 0;}/*解决全屏状态下鼠标放到附件上传按钮上导致的窗口抖动问题*/
</style>
<script>
  function chaall () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'\n!['+file+'](' + url + ')\n':''+html+'';
   }else{
   html = isImage ? html+'<img src="' + url + '" alt="' + file + '" />\n':''+html+'';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }

    function chaquan () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'':html+'\n['+file+'](' + url + ')\n';
   }else{
   html = isImage ? html+'':html+'<a href="' + url + '"/>' + file + '</a>\n';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }
function filter_method(text, badword){
    //获取文本输入框中的内容
    var value = text;
    var res = '';
    //遍历敏感词数组
    for(var i=0; i<badword.length; i++){
        var reg = new RegExp(badword[i],"g");
        //判断内容中是否包括敏感词        
        if (value.indexOf(badword[i]) > -1) {
            $('#tags').tokenInput('add', {id: badword[i], tags: badword[i]});
        }
    }
    return;
}
var badwords = [<?php echo $tag; ?>];
function chatag(){
var textarea=$('#text').val();
filter_method(textarea, badwords); 
}
  $(document).ready(function(){
    $('#file-list').after('<div class="Posthelper"><a class="w-100" onclick=\"chaall()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有图片</a><a class="w-100" onclick=\"chaquan()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有非图片附件</a></div>');
    $('#tags').after('<div style="margin-top: 25px;" class="Posthelper"><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;margin-bottom: 0;"><?php echo $taglist; ?></ul><a class="w-100" onclick=\"chatag()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">检测内容插入标签</a></div>');
  }); 
  </script>
<?php
    }
}



function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {
	$options = Helper::options();
	$autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
	$noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
	if ($obj->url && $autoLink) {
		echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
	} else {
		echo $obj->author;
	}
}
function CommentAt($coid){
	$db = Typecho_Db::get();
	$prow = $db->fetchRow($db->select('parent')->from('table.comments')
		->where('coid = ? AND status = ?', $coid, 'approved'));
	$parent = $prow['parent'];
	if ($prow && $parent != '0') {
		$arow = $db->fetchRow($db->select('author')->from('table.comments')
			->where('coid = ? AND status = ?', $parent, 'approved'));
		echo '<b class="comment-at">@'.$arow['author'].'</b>';
	}
}

?>