define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	
	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'leave/leave/index' + location.search,
					add_url: 'leave/leave/add',
					edit_url: 'leave/leave/edit',
					del_url: 'leave/leave/del',
					multi_url: 'leave/leave/multi',
					table: 'leaving',
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
						{field: 'user.username', title: __('User.username')},
						{field: 'user.mobile', title: __('User.mobile')},
						{field: 'content', title: __('Content')},
						{field: 'ip', title: __('Ip')},
						{field: 'create_time', title: __('Create_time'), operate: 'RANGE', addclass: 'datetimerange'},
						{
							field: 'buttons',
							width: "120px",
							title: __('后台回复'),
							table: table,
							events: Table.api.events.operate,
							buttons: [
								{
									name: 'detail',
									text: __('添加回复'),
									title: __('添加回复'),
									classname: 'btn btn-xs btn-success btn-dialog',
									icon: 'fa fa-list-alt',
									url: 'leave/leave/returns',
									callback: function (data) {
										console.log(data);
									},
									visible: function (row) {
										//返回true时按钮显示,返回false隐藏
										return true;
									}
								}
							],
							formatter: Table.api.formatter.buttons, operate: false
						},
						// {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
		returns: function () {
			$(document).on("click", ".btn-append", function(){
				Form.events.plupload("#add-form");
				Form.events.faselect("#add-form");
			});
			Controller.api.bindevent()
		},
		api: {
			bindevent: function () {
				Form.api.bindevent($("form[role=form]"));
			}
		}
	};
	return Controller;
});
