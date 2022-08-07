define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	
	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'bang/zfb/index' + location.search,
					add_url: 'bang/zfb/add',
					edit_url: 'bang/zfb/edit',
					del_url: 'bang/zfb/del',
					multi_url: 'bang/zfb/multi',
					table: 'banging',
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
						// {field: 'userid', title: __('Userid')},
						{field: 'user.username', title: __('User.username')},
						{field: 'user.mobile', title: __('User.mobile')},
						// {field: 'name', title: __('Name')},
						// {field: 'bandcard', title: __('Bandcard')},
						// {field: 'khh', title: __('Khh')},
						{field: 'zfb', title: __('Zfb')},
						{field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
						{field: 'class', title: __('Class'), formatter: Table.api.formatter.status, searchList: {'0': __('待审核'), '1': __('已通过'),'2':'已拒绝'}},
						{
							field: 'buttons',
							operate:false,
							width: "120px",
							title: __('审核操作'),
							table: table,
							events: Table.api.events.operate,
							buttons: [
								{
									name: 'ajax',
									text: __('通过'),
									title: __('通过'),
									classname: 'btn btn-success btn-edit btn-ajax',
									icon: '',
									url: 'bang/bang/tong?tong=1',
									success: function (data) {
										console.log(data);
									},
									visible: function (row) {
										//返回true时按钮显示,返回false隐藏
										return true;
									}
								},
								{
									name: 'addtabs',
									text: __('拒绝'),
									title: __('拒绝'),
									classname: 'btn btn-danger btn-del btn-ajax',
									confirm:'您确定要拒绝吗',
									icon: '',
									url: 'bang/bang/tong?tong=2',
									callback: function (data) {
										Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
									},
									visible: function (row) {
										//返回true时按钮显示,返回false隐藏
										return true;
									}
								},
							],
							formatter: Table.api.formatter.buttons
						},
						// {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
					]
				]
			});
			//绑定TAB事件
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				// var options = table.bootstrapTable(tableOptions);
				var typeStr = $(this).attr("href").replace('#', '');
				var options = table.bootstrapTable('getOptions');
				options.pageNumber = 1;
				options.queryParams = function (params) {
					// params.filter = JSON.stringify({type: typeStr});
					params.type = typeStr;
					
					return params;
				};
				table.bootstrapTable('refresh', {});
				return false;
				
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
