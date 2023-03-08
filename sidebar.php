<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
error_reporting(0);
$db = Typecho_Db::get();
$query= $db->select('mid','name','iconfont','count')->from('table.metas')->where('type=?','category')->order('order',Typecho_Db::SORT_ASC);
$data = $db->fetchAll($query);

//print_r($data);
//print_r($data2); 

//for循环遍历数组
$menu = '';

foreach ($data as $key => $val) {
	//初始化
  	$dl = '';
	$dt = '';
	$dd = '';
	$ico = $val['iconfont'];
	$name = $val['name'];
	$mid = $val['mid'];
	$count = $val['count'];
	
	$dl =  '<dl id="docdl-'.$mid.'">';
	$dt = '<dt><span class=" fa '.$ico.' "></span>'.$name.' <small>( '.$count.' )</small><i class="iconfont icon-jt-down"></i></dt>';
	
  	$db2 = Typecho_Db::get();
	$query2 = $db2->select() ->from('table.contents') ->join('table.relationships', 'table.contents.cid = table.relationships.cid', Typecho_Db::LEFT_JOIN)->where('`mid` = ?', $mid) ->order('table.contents.cid',Typecho_Db::SORT_ASC); 
	$data2 = $db2->fetchAll($query2);

	foreach ($data2 as $key2 => $val2) {
		$dd.= '<dd><a href="'.$val2["cid"].'.html"  id="doc-menu-'.$val2["cid"].'">'.$val2["title"].'</a></dd>';
	}
	if($dd <> ''){
		$menu .= $dl.$dt.$dd.'</dl>';
	}
}

echo $menu;

?>

