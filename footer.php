<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="grace-footer-line"></div>
<div class="grace-footer">
   	 <span>本站内容版权归 wiki.80srz.com 所有, 未经允许不得转载 !</span><br>
    <span>如有侵权，请联系，E-mail: hygd0813@qq.com !</span><br>
     © <?php echo date('Y'); ?>.<a href="<?php $this->options->siteUrl();?>" target="_blank"><?php $this->options->title();?></a> & <a href="https://www.80srz.com" target="_blank"> 荒野孤灯 </a><br>
    <?php if($this->options->ICP): ?><span style="color:#FF2755;"><a href="https://beian.miit.gov.cn/" rel="nofollow" targrt="_blank"><?php $this->options->ICP();?></a></span><?php endif; ?>
</div>
<!-- html代码压缩 -->
<?php if ($this->options->themecompress == '1'):?>
<?php error_reporting(0); $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); ?>
<?php endif; ?>
<!-- js搜索 -->
<script type="text/javascript">
		$(function(){
			$("#msearchKey").keyup(function(){
				var kwd = $(this).val();
				$('#docdl-se').find('dd').remove();
				$('#docdl-se').parent().hide();
				if(kwd.length < 2){return false;}
				var res = false;
				$('#grace-accordion dd').each(function(){
					var atext = $(this).text();
					if(atext.indexOf(kwd) != -1){
						$(this).clone().appendTo('#docdl-se');
						res = true;
					}
				});
				if(!res){
					$('<dd style="text-align:center;">无搜索结果 ...</dd>').appendTo('#docdl-se');
				}
				$('#docdl-se').parent().show();
				$('#docdl-se').find('dd').show();
			});
		});
		
</script>
	   <div class="searchbox">
    <div class="searchbox-container">
        <div class="searchbox-input-wrapper">
            <form class="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                <input name="s" type="search" class="searchbox-input" placeholder="输入您感兴趣的关键词尽情搜索吧！" />
                <span class="searchbox-close searchbox-selectable"><i class="fa fa-times-circle"></i></span>
            </form>
        </div>
    </div>
</div>	
<script>
document.addEventListener('DOMContentLoaded',function(){(function($){$('#search').click(function(){$('.searchbox').toggleClass('show')});$('.searchbox .searchbox-mask').click(function(){$('.searchbox').removeClass('show')});$('.searchbox-close').click(function(){$('.searchbox').removeClass('show')})})(jQuery)});
</script>
<script type="text/javascript" src="<?php XBwikiUrl('lib/js/prettify.js'); ?>"></script>
<script type="text/javascript">
$('pre').addClass('prettyprint');
$('table').each(function(){
	$(this).find('tr:even').find('td').css({background:'#F6F7F8';border:'1px dashed #999'});
});
prettyPrint();
$('#grace-ctype div').click(function(){
	var index = $(this).index();
	if(index > 2){return;}
	$(this).addClass('grace-current').siblings().removeClass('grace-current');
	$('#sc-content .grace-content').eq(index).show().siblings().hide();
});
</script>
<style type="text/css">
.grace-content pre{position:relative;}
.grace-content pre .copy{width:50px; cursor:pointer; text-align:center; height:28px; line-height:28px; background:#3688FF; font-size:12px; color:#FFF; position:absolute; z-index:1; right:0px; top:0px;}
blockquote{font-size:15px; line-height:2em; padding:10px 20px; color:#000000; background:#F7F8F9; border-left:5px solid #009688; margin:15px 0; text-indent:0;}
</style>
<script type="text/javascript" src="<?php XBwikiUrl('lib/js/clipboard.min.js'); ?>"></script>
<script type="text/javascript">
$('pre').each(function(){
	$('<div class="copy">复制</div>').appendTo($(this));
});
var clopyObj;
var clipboard = new ClipboardJS('.copy', {
    target: function(trigger) {
    	clopyObj = $(trigger).parent();
    	clopyObj.find('.copy').remove();
        return clopyObj.get(0);
    }
});

clipboard.on('success', function(e) {
	graceToast('代码复制成功 (:');
	$('<div class="copy">成功</div>').appendTo(clopyObj);
});

clipboard.on('error', function(e) {
	graceToast('复制失败 ):');
	$('<div class="copy">复制</div>').appendTo(clopyObj);
});
</script>
<script type="text/javascript">
	(function(){
		var pres = document.querySelectorAll('pre');
		var lineNumberClassName = 'line-numbers';
		pres.forEach(function (item, index) {
			item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
		});
	})();
</script>
<!-- 统计代码 -->
<?php if($this->options->zztj): ?> <?php $this->options->zztj();?> <?php endif; ?>