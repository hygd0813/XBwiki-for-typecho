const parser = new HyperDown();
//const player = window.JoeConfig.playerAPI;

export default function createPreviewHtml(str) {
	if (!window.JoeConfig.canPreview) return $('.cm-preview-content').html('1. 预览已默认关闭<br>2. 点击上方预览按钮启用预览<br>3. 若编辑器卡顿可尝试关闭预览');

	if (str.indexOf('　') !== -1) {
		str = str.replace(/　/g, '&emsp;');
	}

	/* 生成html */
	str = parser.makeHtml(str);
	$('.cm-preview-content').html(str);
	$('.cm-preview-content p:empty').remove();
	Prism.highlightAll();
}
