define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'exchange/exchange/index' + location.search,
                    add_url: 'exchange/exchange/add',
                    edit_url: 'exchange/exchange/edit',
                    del_url: 'exchange/exchange/del',
                    multi_url: 'exchange/exchange/multi',
                    table: 'exchange',
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
                        {field: 'class', title: __('Class'), searchList: {"0":__('Class 0'),"1":__('Class 1'),"2":__('Class 2')}, formatter: Table.api.formatter.normal},
                        {field: 'list', title: __('List'), searchList: {"0":__('List 0'),"1":__('List 1')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        // {field: 'userid', title: __('Userid')},
                        {field: 'user.username', title: __('兑换人')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
