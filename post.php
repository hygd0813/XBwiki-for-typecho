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
                 <img src="<?php $this->options->themeUrl('/img/spiker.png'); ?>" width="20px" height="20px" style="padding-left:5px;padding-top:5px;float:left;padding-buttom:5px;" alt="公告" />
                 <marquee scrollamount="5" style="color:red;float:right;width:92%;" ><?php $this->options->gonggao();?></marquee>
            <?php endif; ?>
		</div>
		<div class="grace-content" style="padding:0 15px;">
			<h1 class="grace-h3 grace-color-main"><?php $this->title() ?></h1>
            <p>
               <span class="sa-last-created-time"><?php _e( '创建: ' ); ?><?php echo date('Y-n-j' , $this->created); ?></span>             
               <span class="sa-last-update-view"><?php _e( '访问: ' ); ?><?php echo Postviews($this); ?></span>
               <span class="sa-last-update-view"><?php _e( '用时: ' ); ?><?php echo art_time($this->cid); ?>分钟</span>  
               <span class="sa-last-login-edit"><?php if($this->user->hasLogin()):?><a href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid;?>" target="_blank">编辑</a><?php endif;?></span>
            </p>
          <p><?php if($this->options->postdownads): ?> <?php $this->options->postdownads();?> <?php endif; ?></p>
			<?php $this->content(); ?>
          <p><?php if($this->options->postdownads): ?> <?php $this->options->postdownads();?> <?php endif; ?></p>
            <p>           
               <span class="sa-last-update-time"><?php _e( '最近更新: ' ); ?><?php echo date('Y-n-j' , $this->modified); ?></span>
               <span class="sa-last-login-edit"><?php _e( '本文标签: ' ); ?> <?php $this->tags(', ', true, 'none'); ?></span>
            </p>          
           <footer class="VPDocFooter">
                 <div class="prev-next" >
                      <div class="pager" >
                          <?php echo thePrev($this); ?>
                      </div>
                      <div class="has-prev pager" >
                         <?php echo theNext($this); ?>
                      </div>
                 </div>
          </footer>
          
		</div>		
	</div>
  
	<div class="grace-rows3 grace-3">
        <div class="grace-content" style="padding:0px 15px;">
            <?php getCatalog(); ?>
            <div class="" style="margin-top:15px;"><?php if($this->options->postrightads): ?> <?php $this->options->postrightads();?> <?php endif; ?></div></div></div> <!-- 此处多一个div，重要！！！-->
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