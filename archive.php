<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="grace-main grace-margin-top">
	<div class="grace-rows1 grace-l">
        <?php if($this->options->logoimg): ?> <div class="grace-logo"><a href="<?php $this->options->siteUrl(); ?>" target="_blank"><img src="<?php $this->options->logoimg();?>" width="100%" height="auto"/></a></div><?php endif; ?>      
			<div id="msearch">
				<input type="text" id="msearchKey" placeholder="搜索关键词" value="" />
			</div>
			<div class="grace-accordion" style="display:none; margin-top:5px;">
				<dl id="docdl-se" >
					<dt><span class="fa fa-search"></span>搜索结果</dt>
				</dl>
			</div>
			<div class="grace-accordion" id="grace-accordion">
					<!-- 左侧菜单栏 -->
				    <?php $this->need('sidebar.php'); ?>				
			</div>
            <div class="grace-accordion" style="margin-top:15px;"><?php if($this->options->postrightads): ?> <?php $this->options->postrightads();?> <?php endif; ?></div> 
            <div class="grace-accordion" style="margin-top:10px;padding-top:10px;border-top:1px dashed #999;"><span class="sa-last-update-view">Powered：<a href="https://typecho.org" target="_blank" rel="nofollow">Typecho </a></span><span class="sa-last-login-edit">Theme：<a href="https://wiki.80srz.com/18.html" target="_blank">XBwiki</a></span></div> 

	</div>
	
	<div class="grace-rows2 grace-r">
		<div class="sabackhome">
			<?php if($this->options->postdownads): ?>
                 <img src="<?php $this->options->themeUrl('/img/spiker.png'); ?>" width="20px" height="20px" style="padding-left:5px;padding-top:5px;float:left;padding-buttom:5px;" alt="公告" />
                 <marquee scrollamount="5" style="color:red;float:right;width:92%;" ><?php $this->options->gonggao();?></marquee>
            <?php endif; ?>
		</div>
		<div class="grace-content" style="padding:0 25px;">
        <h2 class="archive-title"><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?></h2>
        <?php if ($this->have()): ?>
    	<?php while($this->next()): ?>
            <article class="grace-content" itemscope itemtype="http://schema.org/BlogPosting" style="border-bottom:1px dashed #999;">
    			<h2 class="grace-h2 grace-color-main" itemprop="name headline"><a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
    			<p>
    				<span class="sa-last-created-time"itemprop="author" itemscope itemtype="http://schema.org/Person"><?php _e('作者: '); ?><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></span>
    				<span class="sa-last-update-view"><?php _e('时间: '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></span>
    				<span class="sa-last-update-view"><?php _e('分类: '); ?><?php $this->category(','); ?></span>
    			</p>
                <div class="post-content" itemprop="articleBody">
        			<?php $this->excerpt(200, ''); ?>
                </div>
    		</article>
    	<?php endwhile; ?>
        <?php else: ?>
            <article class="grace-content">
                <h2 class="grace-h3 grace-color-main"><?php _e('没有找到内容'); ?></h2>
            </article>
        <?php endif; ?>

        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
          
		</div>		
	</div>
  
</div>
<?php
		$db = Typecho_Db::get();
		$result = $db->fetchall($db->select()->from('table.relationships')
			->where('cid = ?',$this->cid));	
		$mid = $result[0]['mid'];
?>

<script type="text/javascript">
$('#nav-doc').addClass('grace-current');
var index = $('#docdl-<?php echo $mid;?>').index();
$('#grace-accordion').accordion(index);
$('#doc-menu-<?php $this->cid(); ?>').addClass('grace-current');
</script>

<?php $this->need('footer.php'); ?>

</body>
</html>