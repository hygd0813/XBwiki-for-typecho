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
            <div class="grace-accordion" style="margin-top:10px;padding-top:10px;border-top:1px dashed #999;"><span class="sa-last-update-view">Powered：<a href="https://typecho.org" target="_blank" rel="nofollow">Typecho </a></span><span class="sa-last-login-edit">Theme：<a href="https://wiki.80srz.com/18.html" target="_blank">XBwiki</a></span></div> 
	</div>
	
	<div class="grace-rows2 grace-r">
 		<div class="sabackhome">
			<?php if($this->options->postdownads): ?>
                 <img src="<?php XBwikiUrl('/img/spiker.png'); ?>" width="20px" height="20px" style="padding-left:5px;padding-top:5px;float:left;padding-buttom:5px;" alt="公告" />
                 <marquee scrollamount="5" style="color:red;float:right;width:92%;" ><?php $this->options->gonggao();?></marquee>
            <?php endif; ?>
		</div>     
		<?php while($this->next()): ?>
			<div style="line-height:2em;padding:5px 25px;">
				<h1 class="grace-h3 grace-color-main"><?php $this->title() ?></h1>
            <p>
               <span class="sa-last-created-time"><?php _e( '创建: ' ); ?><?php echo date('Y-n-j' , $this->created); ?></span>             
               <span class="sa-last-update-time"><?php _e( '更新: ' ); ?><?php echo date('Y-n-j' , $this->modified); ?></span>
               <span class="sa-last-update-view"><?php _e( '访问: ' ); ?><?php echo Postviews($this); ?></span>
               <span class="sa-last-update-view"><?php _e( '用时: ' ); ?><?php echo art_time($this->cid); ?>分钟</span>  
            </p>              
			</div>
			<div class="grace-content" style="padding:15px 25px;">
                    <p><?php if($this->options->postdownads): ?> <?php $this->options->postdownads();?> <?php endif; ?></p>
				<?php $this->content(); ?>
                    <p><?php if($this->options->postdownads): ?> <?php $this->options->postdownads();?> <?php endif; ?></p>
			</div>
		<?php endwhile; ?>
      <?php $this->need('comments.php'); ?>
	</div>          		
  
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