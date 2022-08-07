define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'ext/ext/index' + location.search,
                    add_url: 'ext/ext/add',
                    edit_url: 'ext/ext/edit',
                    del_url: 'ext/ext/del',
                    multi_url: 'ext/ext/multi',
                    table: 'extension',
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
                        // {field: 'user_id', title: __('User_id')},
	                    {field: 'user.username', title: __('推广人')},
	                    {field: 'users.username', title: __('被推广人')},
	                    {field: 'money', title: __('佣金')},
	                    {field: 'cretae_time', title: __('Cretae_time'), operate:'RANGE', addclass:'datetimerange'}
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
