<?php
/**
 * 一款软件使用说明 / 帮助文件 / WIKI主题<br>一款Typecho 文档型主题
 * 
 * @package XBwiki System Theme 
 * @author 荒野孤灯
 * @version 1.0
 * @link https://www.80srz.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>
<?php $this->need('header.php'); ?>
<div class="grace-main grace-margin-top">
	<div class="grace-rows1 grace-l">
        <?php if($this->options->logoimg): ?> <div class="grace-accordion"><a href="<?php $this->options->siteUrl(); ?>" target="_blank"><img src="<?php $this->options->logoimg();?>" width="100%" height="auto"/></a> </div><?php endif; ?>         
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
            <div class="grace-accordion" style="margin-top:10px;padding-top:10px;border-top:1px dashed #999;"><span class="sa-last-update-view">Powered：<a href="https://typecho.org" target="_blank" rel="nofollow">Typecho </a></span><span class="sa-last-login-edit">Theme：<a href="https://wiki.80srz.com/18.html" target="_blank">XBwiki</a></span></div> 
	</div>
	</div>
	
	<div class="grace-rows2 grace-r">
		<div class="sabackhome">
			<?php if($this->options->postdownads): ?>
                 <img src="<?php $this->options->themeUrl('/img/spiker.png'); ?>" width="20px" height="20px" style="padding-left:5px;padding-top:5px;float:left;padding-buttom:5px;" alt="公告" />
                 <marquee scrollamount="5" style="color:red;float:right;width:92%;" ><?php $this->options->gonggao();?></marquee>
            <?php endif; ?>
		</div>      
		<?php while($this->next()): ?>
			<div style="line-height:2em;">
				<h1 class="grace-h3 grace-color-main"><?php $this->title() ?></h1>
			</div>
			<div class="content markdown-body" style="padding:15px 15px;">
				<?php $this->content('- 阅读剩余部分 -'); ?>
			</div>
		<?php endwhile; ?>
			
	</div>
</div>

<script type="text/javascript">
$('#nav-doc').addClass('grace-current');
var index = $('#docdl-2').index();
$('#grace-accordion').accordion(index);
$('#doc-menu-7').addClass('grace-current');
</script>

<?php $this->need('footer.php'); ?>


</body>
</html>