<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="initial-scale=1,width=device-width,minimum-scale=1,maximum-scale=6">
<meta name="wap-font-scale" content="no">
<meta http-equiv="Cache-Control" content="no-transform"/>
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<meta name="applicable-device" content="pc,mobile">
<meta name="MobileOptimized" content="width">
<meta name="HandheldFriendly" content="true">
<meta content="always" name="referrer"> 
<?php if ($this->is('index')): ?>
<meta property="og:type" content="blog"/>
<meta property="og:url" content="<?php $this->options->siteUrl();?>"/>
<meta property="og:title" content="<?php $this->options->title();?>"/>
<meta property="og:author" content="<?php $this->author->name();?>"/>
<meta name="keywords"  content="<?php $this->keywords();?>"> 
<meta name="description"  content="<?php $this->options->description();?>">
<?php endif;?>
<?php if ($this->is('post') || $this->is('page') || $this->is('attachment')): ?>
<meta property="og:url" content="<?php $this->permalink();?>"/>
<meta property="og:title" content="<?php $this->title();?> - <?php $this->options->title();?>"/>
<meta property="og:author" content="<?php $this->author();?>"/>    
<meta property="og:type" content="article"/>
<meta property="article:published_time" content="<?php $this->date('c'); ?>"/>
<meta property="article:published_first" content="<?php $this->options->title() ?>, <?php $this->permalink() ?>" /> 
<meta name="keywords"  content="<?php $k=$this->fields->keyword;if(empty($k)){echo $this->keywords();}else{ echo $k;};?>">
<meta name="description" content="<?php $d=$this->fields->description;if(empty($d) || !$this->is('single')){if($this->getDescription()){echo $this->getDescription();}}else{ echo $d;};?>" />
<?php endif;?>  
<link rel="stylesheet" href="<?php XBwikiUrl('lib/css/grace.css'); ?>"  />
<link rel="stylesheet" href="<?php XBwikiUrl('lib/css/search.css'); ?>"  />
<link rel="stylesheet" href="<?php XBwikiUrl('lib/css/markdown.css'); ?>"  />
<link rel="stylesheet" href="<?php XBwikiUrl('lib/css/prettify.css'); ?>"  />
<link rel="stylesheet" type="text/css" href="<?php XBwikiUrl('lib/css/font_611166_fpdzl80md8u.css'); ?>" />
<link href="<?php XBwikiUrl('lib/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
<?php if($this->options->favicon): ?><link rel="shortcut icon" href="<?php $this->options->favicon();?>"><?php endif; ?>
<script type="text/javascript" src="<?php XBwikiUrl('lib/js/jquery-3.4.1.min.js'); ?>" ></script>
<script type="text/javascript" src="<?php XBwikiUrl('lib/js/grace.js'); ?>" ></script>
<style type="text/css">
<?php if($this->options->csscode): ?> <?php $this->options->csscode();?><?php endif; ?>
</style>
</head>
<?php if ($this->is('index')): ?>
<style type="text/css">@media screen and (max-width:800px){  .grace-rows1{width:94%; padding:5px 2%;}  .grace-rows2{display:none;}}</style> 
<?php else : ?>
<style type="text/css">@media screen and (max-width:800px){  .grace-rows1{display:none;}.grace-rows2{width:94%; padding:5px 2%;}}</style> 
<?php endif; ?>
<style type="text/css">
#msearch{width:100%; margin-bottom:10px;}
#msearch input{width:82%; padding:10px 9%; border-radius:3px; line-height:20px; height:20px; background:#F2F2F2; border:none;}
#docdl-se dt{color:#3688FF;}
#docdl-se dt *{color:#3688FF;}
</style> 
<title>
  <?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php if($this->_currentPage>1) echo ' 第 '.$this->_currentPage.' 页 - '; ?><?php $this->options->title(); ?>
</title>
<body>
<div class="grace-header">
	<div class="grace-main">
		<ul class="grace-nav">
				<li><a href="<?php $this->options->siteUrl(); ?>" id="nav-doc">首页</a></li>
                <li><a href="/28.html" target="_blank" id="nav-tmp">投稿</a></li> 
                <li><a href="/17.html" target="_blank" id="nav-tmp">留言</a></li>  
          		<li><a href="https://www.80srz.com" id="nav-tmp" target="_blank">博客</a></li>
		</ul>
        <div class="grace-fr share_ico">                	        
              <a id="search" class="search icon btn" href="javascript:;" title="站内搜索"><i class="fa fa-search"></i></a>
         </div>   
	</div> 
</div>
<div class="grace-header-line"></div>
  