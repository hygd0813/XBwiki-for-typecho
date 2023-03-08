import { undo, redo } from '@codemirror/history';
export default class JoeAction {
	constructor() {
		$('body').append(`
				<div class="cm-modal">
						<div class="cm-modal__wrapper">
								<div class="cm-modal__wrapper-header">
										<div class="cm-modal__wrapper-header--text"></div>
										<div class="cm-modal__wrapper-header--close">×</div>
								</div>
								<div class="cm-modal__wrapper-bodyer"></div>
								<div class="cm-modal__wrapper-footer">
										<button class="cm-modal__wrapper-footer--cancle">取消</button>
										<button class="cm-modal__wrapper-footer--confirm">确定</button>
								</div>
						</div>
				</div>
		`);
		$('.cm-modal__wrapper-footer--cancle, .cm-modal__wrapper-header--close').on('click', () => $('.cm-modal').removeClass('active'));
		$('.cm-modal__wrapper-footer--confirm').on('click', () => {
			this.options.confirm();
			$('.cm-modal').removeClass('active');
		});
	}
	_openModal(options = {}) {
		const _options = {
			title: '提示',
			innerHtml: '内容',
			hasFooter: true,
			confirm: () => { },
			handler: () => { }
		};
		this.options = Object.assign(_options, options);
		$('.cm-modal__wrapper-header--text').html(this.options.title);
		$('.cm-modal__wrapper-bodyer').html(this.options.innerHtml);
		this.options.hasFooter ? $('.cm-modal__wrapper-footer').show() : $('.cm-modal__wrapper-footer').hide();
		$('.cm-modal').addClass('active');
		this.options.handler();
	}
	_getLineCh(cm) {
		const head = cm.state.selection.main.head;
		const line = cm.state.doc.lineAt(head);
		return head - line.from;
	}
	_replaceSelection(cm, str) {
		cm.dispatch(cm.state.replaceSelection(str));
	}
	_setCursor(cm, pos) {
		cm.dispatch({ selection: { anchor: pos } });
	}
	_getSelection(cm) {
		return cm.state.sliceDoc(cm.state.selection.main.from, cm.state.selection.main.to);
	}
	_insetAmboText(cm, str) {
		const cursor = cm.state.selection.main.head;
		const selection = this._getSelection(cm);
		this._replaceSelection(cm, ` ${str + selection + str} `);
		if (selection === '') this._setCursor(cm, cursor + str.length + 1);
		cm.focus();
	}
	_createTableLists(cm, url, activeTab = '', modalTitle) {
		$.ajax({
			url,
			dataType: 'json',
			success: res => {
				let tabbarStr = '';
				let listsStr = '';
				for (let key in res) {
					const arr = res[key].split(' ');
					tabbarStr += `<div class="tabbar-item ${key === activeTab ? 'active' : ''}" data-show="${key}">${key}</div>`;
					listsStr += `<div class="lists ${key === activeTab ? 'active' : ''}" data-show="${key}">${arr.map(item => `<div class="lists-item" data-text="${item}">${item}</div>`).join(' ')}</div>`;
				}
				this._openModal({
					title: modalTitle,
					hasFooter: false,
					innerHtml: `<div class="tabbar">${tabbarStr}</div>${listsStr}`,
					handler: () => {
						$('.cm-modal__wrapper-bodyer .tabbar-item').on('click', function () {
							const activeTab = $(this);
							const show = activeTab.attr('data-show');
							const tabbar = $('.cm-modal__wrapper-bodyer .tabbar');
							activeTab.addClass('active').siblings().removeClass('active');
							tabbar.stop().animate({
								scrollLeft: activeTab[0].offsetLeft - tabbar[0].offsetWidth / 2 + activeTab[0].offsetWidth / 2 - 15
							});
							$('.cm-modal__wrapper-bodyer .lists').removeClass('active');
							$(".cm-modal__wrapper-bodyer .lists[data-show='" + show + "']").addClass('active');
						});
						const _this = this;
						$('.cm-modal__wrapper-bodyer .lists-item').on('click', function () {
							const text = $(this).attr('data-text');
							_this._replaceSelection(cm, ` ${text} `);
							$('.cm-modal').removeClass('active');
							cm.focus();
						});
					}
				});
			}
		});
	}
	_updateScroller(el, target) {
		const percentage = el.scrollTop / (el.scrollHeight - el.offsetHeight);
		target.scrollTop = percentage * (target.scrollHeight - target.offsetHeight);
	}
	handleFullScreen(el) {
		el.toggleClass('active');
		$('body').toggleClass('fullscreen');
		$('.cm-container').toggleClass('fullscreen');
		$('.cm-preview').width(0);
	}
	handlePublish() {
		$('#btn-submit').click();
	}
	handleUndo(cm) {
		undo(cm);
		cm.focus();
	}
	handleRedo(cm) {
		redo(cm);
		cm.focus();
	}
	handleIndent(cm) {
		this._replaceSelection(cm, '　');
		cm.focus();
	}
	handleTime(cm) {
		const time = new Date();
		const _Year = time.getFullYear();
		const _Month = String(time.getMonth() + 1).padStart(2, 0);
		const _Date = String(time.getDate()).padStart(2, 0);
		const _Hours = String(time.getHours()).padStart(2, 0);
		const _Minutes = String(time.getMinutes()).padStart(2, 0);
		const _Seconds = String(time.getSeconds()).padStart(2, 0);
		const _Day = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'][time.getDay()];
		const _time = `${this._getLineCh(cm) ? '\n' : ''}${_Year}-${_Month}-${_Date} ${_Hours}:${_Minutes}:${_Seconds} ${_Day}\n`;
		this._replaceSelection(cm, _time);
		cm.focus();
	}
	handleHr(cm) {
		const str = `${this._getLineCh(cm) ? '\n' : ''}\n------------\n\n`;
		this._replaceSelection(cm, str);
		cm.focus();
	}
	handleClean(cm) {
		cm.dispatch({ changes: { from: 0, to: cm.state.doc.length, insert: '' } });
		cm.focus();
	}
	handleOrdered(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			const str = (this._getLineCh(cm) ? '\n\n' : '') + '1. ';
			this._replaceSelection(cm, str);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : i + 1 + '. ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleUnordered(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			const str = (this._getLineCh(cm) ? '\n' : '') + '- ';
			this._replaceSelection(cm, str);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : '- ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleQuote(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			this._replaceSelection(cm, `${this._getLineCh(cm) ? '\n' : ''}> `);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : '> ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleDownload(cm) {
		const title = $('#title').val() || '新文章';
		const aTag = document.createElement('a');
		let blob = new Blob([cm.state.doc.toString()]);
		aTag.download = title + '.md';
		aTag.href = URL.createObjectURL(blob);
		aTag.click();
		URL.revokeObjectURL(blob);
	}
	handleHtml(cm) {
		const str = `${this._getLineCh(cm) ? '\n' : ''}!!!\n<p align="center">居中</p>\n<p align="right">居右</p>\n<font size="5" color="red">颜色大小</font>\n!!!\n`;
		this._replaceSelection(cm, str);
		cm.focus();
	}
	handleTitle(cm, tool) {
		const item = $(`
			<div class="cm-tools-item" title="${tool.title}">
				${tool.innerHTML}
				<div class="cm-tools__dropdown">
					<div class="cm-tools__dropdown-item" data-text="# "> H1 </div>
					<div class="cm-tools__dropdown-item" data-text="## "> H2 </div>
					<div class="cm-tools__dropdown-item" data-text="### "> H3 </div>
					<div class="cm-tools__dropdown-item" data-text="#### "> H4 </div>
					<div class="cm-tools__dropdown-item" data-text="##### "> H5 </div>
					<div class="cm-tools__dropdown-item" data-text="###### "> H6 </div>
				</div>
			</div>
		`);
		item.on('click', function (e) {
			e.stopPropagation();
			$(this).toggleClass('active');
		});
		const _this = this;
		item.on('click', '.cm-tools__dropdown-item', function (e) {
			e.stopPropagation();
			const text = $(this).attr('data-text');
			if (_this._getLineCh(cm)) _this._replaceSelection(cm, '\n\n' + text);
			else _this._replaceSelection(cm, text);
			item.removeClass('active');
			cm.focus();
		});
		$(document).on('click', () => item.removeClass('active'));
		$('.cm-tools').append(item);
	}
	handleLink(cm) {
		this._openModal({
			title: '插入链接',
			innerHtml: `
                <div class="fitem">
                    <label>链接标题</label>
                    <input autocomplete="off" name="title" placeholder="请输入链接标题"/>
                </div>
                <div class="fitem">
                    <label>链接地址</label>
                    <input autocomplete="off" name="url" placeholder="请输入链接地址"/>
                </div>
            `,
			confirm: () => {
				const title = $(".cm-modal input[name='title']").val() || 'Test';
				const url = $(".cm-modal input[name='url']").val() || 'http://';
				this._replaceSelection(cm, ` [${title}](${url}) `);
				cm.focus();
			}
		});
	}
	handleImage(cm) {
		this._openModal({
			title: '插入图片',
			innerHtml: `
                <div class="fitem">
                    <label>图片名称</label>
                    <input autocomplete="off" name="title" placeholder="请输入图片名称"/>
                </div>
                <div class="fitem">
                    <label>图片地址</label>
                    <input autocomplete="off" name="url" placeholder="请输入图片地址"/>
                </div>
            `,
			confirm: () => {
				const title = $(".cm-modal input[name='title']").val() || 'Test';
				const url = $(".cm-modal input[name='url']").val() || 'http://';
				this._replaceSelection(cm, ` ![${title}](${url}) `);
				cm.focus();
			}
		});
	}
	handleTable(cm) {
		this._openModal({
			title: '插入表格',
			innerHtml: `
                <div class="fitem">
                    <label>表格行</label>
                    <input style="width: 50px; flex: none; margin-right: 10px;" value="3" autocomplete="off" name="row"/>
                    <label>表格列</label>
                    <input style="width: 50px; flex: none;" value="3" autocomplete="off" name="column"/>
                </div>
            `,
			confirm: () => {
				let row = $(".cm-modal input[name='row']").val();
				let column = $(".cm-modal input[name='column']").val();
				if (isNaN(row)) row = 3;
				if (isNaN(column)) column = 3;
				let rowStr = '';
				let rangeStr = '';
				let columnlStr = '';
				for (let i = 0; i < column; i++) {
					rowStr += '| 表头 ';
					rangeStr += '| :--: ';
				}
				for (let i = 0; i < row; i++) {
					for (let j = 0; j < column; j++) columnlStr += '| 表格 ';
					columnlStr += '|\n';
				}
				const htmlStr = `${rowStr}|\n${rangeStr}|\n${columnlStr}\n`;
				if (this._getLineCh(cm)) this._replaceSelection(cm, '\n\n' + htmlStr);
				else this._replaceSelection(cm, htmlStr);
				cm.focus();
			}
		});
	}
	handleGird(cm) {
		this._openModal({
			title: '插入宫格',
			innerHtml: `
                <div class="fitem">
                    <label>宫格列数</label>
                    <input value="3" autocomplete="off" name="column" placeholder="请输入宫格列数"/>
                </div>
                <div class="fitem">
                    <label>宫格间隔</label>
                    <input value="15" autocomplete="off" name="gap" placeholder="请输入宫格间隔"/>
                </div>
            `,
			confirm: () => {
				const column = $(".cm-modal input[name='column']").val();
				const gap = $(".cm-modal input[name='gap']").val();
				const htmlStr = `{gird column="${column}" gap="${gap}"}\n{gird-item}\n 宫格内容一\n{/gird-item}\n{gird-item}\n 宫格内容二\n{/gird-item}\n{gird-item}\n 宫格内容三\n{/gird-item}\n{/gird}`;
				if (this._getLineCh(cm)) this._replaceSelection(cm, '\n\n' + htmlStr);
				else this._replaceSelection(cm, htmlStr);
				cm.focus();
			}
		});
	}
}
