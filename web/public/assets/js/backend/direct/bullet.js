define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	
	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'direct/bullet/index' + location.search,
					add_url: 'direct/bullet/add',
					edit_url: 'direct/bullet/edit',
					del_url: 'direct/bullet/del',
					multi_url: 'direct/bullet/multi',
					table: 'direct_bullet',
				}
			});
			
			var table = $("#table");
			
			// 初始化表格
			table.bootstrapTable({
				url: $.fn.bootstrapTable.defaults.extend.index_url,
				pk: 'id',
				sortName: 'id',
				columns: [
					[
						{checkbox: true},
						{field: 'id', title: __('Id')},
						{field: 'text', title: __('Text')},
						{field: 'create_time', title: __('Create_time'), operate: 'RANGE', addclass: 'datetimerange'},
						{field: 'update_time', title: __('Update_time'), operate: 'RANGE', addclass: 'datetimerange'},
						{
							field: 'operate',
							title: __('Operate'),
							table: table,
							events: Table.api.events.operate,
							formatter: Table.api.formatter.operate
						}
					]
				]
			});
			
			// 为表格绑定事件
			Table.api.bindevent(table);
		},
		add: function () {
			Controller.api.bindevent();
		},
		edit: function () {
			Controller.api.bindevent();
		},
		api: {
			bindevent: function () {
				Form.api.bindevent($("form[role=form]"));
			}
		}
	};
	return Controller;
});
