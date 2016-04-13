/*!
 * jQuery UI datagrid
 * 
 * @autor:.....Juarez Gon�alves Nery Junior
 * @email:.....juareznjunior@gmail.com
 * @twitter:...@juareznjunior
 * 
 * Depends:
 *	 jquery.ui.core.js
 *	 jquery.ui.widget.js
 *	 jquery.ui.button.js
 */
;(function($,doc){
	$.widget('ui.datagrid',{
		// plugin options
		options: {
			limit:5
			,mapper:[]
			,height:200
			,jsonStore:{
				// ajax params
				params: {}
				// is ajax
				,url: ''
				// json
				,data:{}
			}
			,pagination: true
			,toolBarButtons:false
			,refresh: false
			,onSelectRow: false
			,onComplete: false
			,onLoad: false
			,rowHover: true
			,rowClick: true
			,rowNumber: false
			,ajaxMethod: 'POST'
			,autoRender: true
			,autoLoad: true
			,title: ''
			,classThead: 'ui-state-default'
			,containerBorder: true
			,fit: false
		}
		,_create: function() {
			// plugin params elements
			this.uiDataGrid = $(this._getMarkup());
			this.uiDataGridChilds = this.uiDataGrid.children();
			this.uiDataGridTables = this.uiDataGridChilds.find('table');
			this.uiDataGridThead = $(this.uiDataGridTables[0].tHead);
			this.uiDataGridTheadBody = $(this.uiDataGridTables[1].tHead);
			this.uiDataGridTbody = $(this.uiDataGridTables[1].tBodies[0]);
			this.uiDataGridTfoot = (this.options.pagination || $.isArray(this.options.toolBarButtons))
				? $(this.uiDataGridTables[2].tBodies[0])
				: $([]);
			this.uiDataGridScroll = this.uiDataGridTables.eq(0).parent().next();
			
			// plugin params
			this._offset = 0;
			this._totalPages = 0;
			this._selectedRows = [];
			
			this._tbodyEvents();
			
			delete this.uiDataGridTables;
			delete this.uiDataGridChilds;
		}
		,_init: function() {
			if (this.options.autoRender) {
				 this.render();
			}
		}
		,_setOption: function(option,value) {
			$.Widget.prototype._setOption.apply(this,arguments);
		}
		,_getMarkup: function() {
			var _div = document.createElement('div'),markup = '';
			_div.className = 'ui-data-grid-container ui-widget'+((this.options.containerBorder) ? ' ui-widget-content ui-corner-all' : '');
			_div.style.cssText = 'padding:1px';
			
			if (this.options.title !== '') {
				markup += '<div style="text-align: center; padding: 0.4em 0pt" class="ui-widget-header ui-corner-all">'
						+this.options.title
					+'</div>'
				+'<div>';
			}
			
			markup += '<div>'
					+'<table cellspacing="0" cellpadding="0" class="ui-datagrid" role="grid">'
						+'<thead>'
							+'<tr role="rowheader"></tr>'
						+'</thead>'
					+'</table>'
				+'</div>'
				+'<div class="ui-widget-content" style="height:'+this.options.height+'px;overflow-y:scroll;overflow-x:hidden;border:0 !important">'
					+'<table cellspacing="0" cellpadding="0" class="ui-datagrid ui-datagrid-tbody" role="grid">'
						+'<thead>'
							+'<tr role="rowheader"></tr>'
						+'</thead>'
						+'<tbody></tbody>'
					+'</table>'
				+'</div>';
			
			if (this.options.pagination || $.isArray(this.options.toolBarButtons)) {
				markup += '<div class="ui-data-grid-toolbar ui-widget ui-state-default ui-corner-all" style="margin-top:1px">'
					+'<table cellspacing="0" cellpadding="0" style="width:100%;background:none">'
						+'<tbody>'
							+'<tr style="background:none">'
								+'<td style="padding:1px;text-align:left;border:none">&nbsp;</td>';
			
				if (this.options.pagination) {
					markup += '<td style="text-align:right;padding:1px;border:0">'									
						+'<span style="margin-right:5px"></span>'
					+'</td>';
				}
			
				markup += '</tr>'
							+'</tbody>'
						+'</table>'
					+'</div>';
			}
			
			if (this.options.title !== '') {
				markup += '</div>';
			}
			
			markup += '</div>';
			
			_div.innerHTML = markup;
			markup = null;
			
			return _div;
		}
		,_createToolButtons: function() {
			var ap = $(this.uiDataGridTfoot[0].rows[0].cells).eq(-1)[0];
				
			$.each(['first','prev','next','end'],function(i,v){
				$(doc.createElement('button'))
					.attr('name','data-grid-button-'+v)
					.text(v)
					.button({
						icons: {
							primary: 'ui-icon-seek-'+v
						}
						,text:false
					})
					.appendTo(ap);
			});
			
			ap = null;
			return this;
		}
		,_disableToolButtons: function() {
			$(this.uiDataGridTfoot[0].rows[0].cells).eq(-1)
				.children(':button')
				.removeClass('ui-state-hover ui-state-focus')
				.button('disable');
			
			return this;
		}
		,_createColumns: function() {
			for(var cls = 'ui-widget '+this.options.classThead,aux,row = [],_th,i=0;_th = this.options.mapper[i++];) {
				aux = document.createElement('th');
				aux.className = cls;
				
				if (i > 1) {
					aux.style.borderLeftWidth = '0';
				}
				var html = undefined !== _th.alias ? _th.alias : _th.name
					,$helper = $(document.createElement('div'))
						.addClass('ui-widget ui-state-default')
						.css({overflow:'scroll',position:'absolute',left:0})
						.html(html)
						.appendTo(document.body);
				
				$(aux).attr('role','gridcell')[0].innerHTML = html;
				
				// css
				if ( undefined !== _th.css) {
				
					$(aux).css(_th.css);
					
					// ajuste do width
					var w = $(aux).width();
					if ( w > 0 ) {
						aux.style.width = (Math.max(w,$helper[0].scrollWidth))+'px';
					}
				}
				
				document.body.removeChild($helper[0]);
				$helper = null;
				row[row.length] = aux
			}
			
			aux = document.createElement('th');
			aux.innerHtml = '&nbsp';
			aux.className = cls;
			aux.style.cssText = 'border-left-width:0;width:17px;padding:0';
			row[row.length] = aux;
			
			if (this.options.rowNumber) {
				aux = document.createElement('th');
				aux.innerHTML = '&nbsp';
				aux.className = cls+' ui-datagrid-cell-rownumber';
				aux.style.cssText = 'width:20px;border-right-width:0';
				row.splice(0,0,aux)
			}
			
			
			$(
				$([this.uiDataGridThead[0].rows[0],this.uiDataGridTheadBody[0].rows[0]])
					// append rows
					.append(row)
					// get cells 
					.last()[0].cells
			).last().css('background','none'); // background disabled
			
			// garbage
			row = aux = r = null
		}
		,_createRows: function(json) {
			var theadThs = this.getThead()[0].rows[0].cells;
		
			this.clear();
			this.uiDataGridScroll.scrollTop(0);
			
			for(var cls = 'ui-widget ui-widget-content',row,cell,item,i=0,j=0;item = json.rows[i++];) {
				row = document.createElement('tr');
				row.style.cssText = this.options.rowClick ? 'cursor:pointer' : 'cursor:default';
				row.className = 'ui-datagrid-row-'+((i%2) ? 'odd' : 'even');

				if (this.options.rowNumber) {
					cell = document.createElement('td');
					cell.className = this.options.classThead;
					cell.style.cssText = 'width:20px;text-align:center;vertical-align:middle;border-width:0 0 0 1px';
					cell.innerHTML = parseInt(this._offset) + i;
					row.appendChild(cell)
				}
				
				while (_td = this.options.mapper[j++]) {
					cell = document.createElement('td');
					cell.className = cls;
					
					// default
					cell.style.cssText = 'border-width:0 1px 0 1px;background:0;text-align:'+theadThs[j].style.textAlign;
					
					if (j > 1) {
						cell.style.borderLeftWidth = '0';
					}
					
					// apply the css text-align
					((undefined != _td.css.textAlign) && $(cell).css('textAlign',_td.css.textAlign));
					
					// cell content
					cell.innerHTML = $.isFunction(_td.map)
						? _td.map(item[_td.name]) // aplica uma fun��o no valor do campo
						: ($.isFunction(window[_td.globalFunction]))
							? window[_td.globalFunction](item[_td.name])
							: item[_td.name]; // mapper.row.fieldName
						
					row.appendChild(cell)
				}
				
				row.appendChild(document.createElement('th'));
				this.uiDataGridTbody[0].appendChild(row);
				
				// reset
				j = 0;
				row = cell = null
			}
			$(this.uiDataGridTbody[0].rows).last().children().css('border-bottom-width','1px');
			row = cell = theadThs = null;
			i = y = 0
		}
		,_ajax: function() {
			var self = this;
			
			// ajax
			if (self.options.jsonStore.url != '') {
			
				// serialize
				// literal object (isPlainObject (json))
				if ('string' === typeof self.options.jsonStore.params) {
					self.options.jsonStore.params = (0 === self._offset)
						? self.options.jsonStore.params+'&limit='+self.options.limit+'&offset='+self._offset
						: self.options.jsonStore.params.replace(/(&offset=)(.+)/,'&offset='+self._offset)
				} else {
					self.options.jsonStore.params.limit = self.options.limit;
					self.options.jsonStore.params.offset = self._offset
				}
				
				// disable button toolbar
				if (self.options.pagination) {
					self._disableToolButtons();
				}
				
				$.ajax({
					type: self.options.ajaxMethod.toLowerCase()
					,url: self.options.jsonStore.url.replace(/\?.*/,'')
					,data: self.options.jsonStore.params
					,dataType: 'json'
					,success: function(json) {
						
						if (undefined !== json.error) {
							alert(json.error);
							return false;
						}
						
						if (undefined === json.numRows || json.numRows == 0) {
							return false;
						}
						
						if (self.options.pagination) {
						
							self._totalPages = Math.ceil(json.numRows / self.options.limit);
							var currentPage = (self._offset == 0 ) ? 1 : ((self._offset / self.options.limit) + 1)
								,infoPages = currentPage+' de '+self._totalPages+' ('+json.numRows+')';
							
							// ultimo td
							$.each($(self.uiDataGridTfoot[0].rows[0].cells).eq(-1).children(),function(){
								if (/span/i.test(this.tagName)) {
									this.innerHTML = infoPages
								} else {
									(/data-grid-button-(first|prev)/.test(this.name))
										? (self._offset > 0 && this.disabled && $(this).button('enable'))
										: (self._totalPages > currentPage && this.disabled && $(this).button('enable'))
								}
							})
						}
						
						self._createRows(json)
					}
				})
			} else {
				self._createRows(self.options.jsonStore.data)
			}

			($.isFunction(self.options.onLoad) && self.options.onLoad())
		}
		,render: function() {
			var self = this;
			
			if (self.element.children('div:first').hasClass('ui-data-grid-container')) {
				self.resetOffset();
				self.load()
			} else {
				
				if ($.isArray(self.options.toolBarButtons)) {
					$.each(self.options.toolBarButtons,function(i,b){
						
						(function(){
							this.innerHTML = b.label;
							if ($.isFunction(b.fn)) {
								$(this).bind('click',function(){
									b.fn.call(this,self.element);
									$(this).blur()
								});
							}
							
							$(this).button({icons:{primary:(undefined === b.icon) ? null : 'ui-icon-'+b.icon}});
							self.uiDataGridTfoot[0].rows[0].cells[0].appendChild(this);
							
						}).call(document.createElement('button'));
					});
				}
				
				// create ui-datagrid
				self.uiDataGrid.appendTo(self.element);
				
				// create columns
				self._createColumns();
				
				// dimensions
				var w = self.uiDataGrid.width()
					h = self.uiDataGridThead.outerHeight();
				
				// grid scorll width
				self.uiDataGridScroll.width(w);
				self.uiDataGridTheadBody
					.parent()
					.width(w)
					.css('marginTop',-h);
				w = h = null;

				
				if (self.options.pagination) {
				
					// create and disable buttons 
					self._createToolButtons()._disableToolButtons();
					
					// prev next event
					$(self.uiDataGridTfoot[0].rows[0].cells).eq(-1).delegate('button','click',function(){
						if (!this.disabled) {
							self[this.name.replace(/data-grid-button-/,'')+'Page']();
							self._selectedRows = [];
							self.load()
						}
					});
				}
				
				self.resize();

				// load
				(self.options.autoLoad && self.load());
				
				// onComplete callback
				($.isFunction(self.options.onComplete) && self.options.onComplete.call(self.uiDataGridTbody[0]));
			}
			
			return this
		}
		,nextPage: function() {
			this._offset += this.options.limit
		}
		,prevPage: function() {
			this._offset -= this.options.limit
		}
		,endPage: function() {
			this._offset = (this._totalPages * this.options.limit) - this.options.limit
		}
		,firstPage: function() {
			this._offset = 0
		}
		,_tbodyEvents: function() {
			var self = this,ev = [];
			
			if (this.options.rowHover) {
				ev[ev.length] = 'mouseover';
				ev[ev.length] = 'mouseout'
			}
			
			if (this.options.rowClick) {
				ev[ev.length] = 'click'
			}
			
			if (ev.length > 0) {
			
				self.uiDataGridTbody.undelegate().delegate('tr',ev.join(' '),function(event){
					('click' === event.type)
						? self._clickRow(this,event)
						: $(this)[(('mouseover' ===  event.type) ? 'addClass' : 'removeClass')]('ui-state-hover')
				})
			}
			
			ev = null
		}
		,_clickRow: function(tr,event) {
			var self = this;
			if ($(tr).hasClass('ui-state-highlight')) {
				$(tr).removeClass('ui-state-highlight');
				
				for(var i=0,row;row=self._selectedRows[i++];) {
					if (tr === row) {
						self._selectedRows.splice(--i,1);
						break
					}
				}
				
			} else {
				$(tr).addClass('ui-state-highlight');
				self._selectedRows[self._selectedRows.length] = tr;
				($.isFunction(self.options.onSelectRow) && self.options.onSelectRow.call(tr,[self.element[0]]));
			}
		}
		,resize: function() {
			var self = this;
			// fit to parent
			if (self.options.fit) {
				
				(function(){
					var h = self.uiDataGrid.outerHeight() - self.element.height();
					this.height(this.height() - h +'px');
				}).call(self.uiDataGridScroll);
				
			}
			self = null;
			return this
		}
		,getSelectedRows: function() {
			return this._selectedRows
		}
		,clearSelectedRows: function() {
			
			for(var i=0,row;row=this._selectedRows[i++];) {
				$(row).removeClass('ui-state-highlight');
			}
			
			this._selectedRows = []
		}
		,load: function() {
			this._ajax()
			return this
		}
		,widget: function() {
			return this.uiDataGrid
		}
		,destroy: function() {
			$.Widget.prototype.destroy.call(this);
			this.element.empty()
		}
		,getOffset: function() {
			return this._offset
		}
		,resetOffset: function() {
			this._offset = 0
		}
		,getThead: function(callback) {
			return ($.isFunction(callback))
				? callback.call(this.uiDataGridThead[0])
				: this.uiDataGridThead
		}
		,getTbody: function(callback) {
			return ($.isFunction(callback))
				? callback.call(this.uiDataGridTbody[0])
				: this.uiDataGridTbody
		}
		,getTFoot: function(callback) {
			return ($.isFunction(callback))
				? callback.call(this.uiDataGridTfoot[0])
				: this.uiDataGridTfoot
		}
		,clear: function() {
			this.uiDataGridTbody.empty();
		}
	})
})(jQuery,document);
(function(d){d.extend(d.ui.datagrid.prototype.options,{rowHover:false,rowClick:false,classThead:'ui-state-default-datagrid'})})(jQuery);