define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	
	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'order/order/index' + location.search,
					add_url: 'order/order/add',
					edit_url: 'order/order/edit',
					del_url: 'order/order/del',
					multi_url: 'order/order/multi',
					table: 'order',
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
						{field: 'code', title: __('Code')},
						{field: 'user.username', title: __('User.username')},
						// {field: 'userid', title: __('Userid')},
						// {field: 'cardid', title: __('Cardid')},
						{
							field: 'pay_type',
							title: __('Pay_type'),
							formatter: Table.api.formatter.status,
							searchList: {'wechat': __('微信'), 'alipay': __('支付宝')}
						},
						{field: 'vipcard.name', title: __('Vipcard.name')},
						{field: 'price', title: __('Price'), operate: 'BETWEEN'},
						{
							field: 'list',
							title: __('状态'),
							formatter: Table.api.formatter.status,
							searchList: {'0': __('待支付'), '1': __('已支付'), '2': "支付失败"}
						},
						{field: 'create_time', title: __('Create_time'), operate: 'RANGE', addclass: 'datetimerange'},
						{field: 'pay_time', title: __('Pay_time'), operate: 'RANGE', addclass: 'datetimerange'},
						{field: 'image', title: __('支付二维码'), events: Table.api.events.image, formatter: Table.api.formatter.image},
						// {
						// 	field: 'operate',
						// 	title: __('Operate'),
						// 	table: table,
						// 	events: Table.api.events.operate,
						// 	formatter: Table.api.formatter.operate
						// }
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
