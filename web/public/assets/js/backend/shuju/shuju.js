define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'shuju/shuju/index' + location.search,
                    add_url: 'shuju/shuju/add',
                    edit_url: 'shuju/shuju/edit',
                    // del_url: 'shuju/shuju/del',
                    // multi_url: 'shuju/shuju/multi',
                    table: 'shuju',
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
                        {field: 'users', title: __('Users')},
                        {field: 'fangwens', title: __('Fangwens')},
                        {field: 'orders', title: __('Orders')},
                        {field: 'moneys', title: __('Moneys')},
                        {field: 'reg', title: __('Reg')},
                        {field: 'login', title: __('Login')},
                        {field: 'order_j', title: __('Order_j')},
                        {field: 'order_w', title: __('Order_w')},
                        {field: 'agent', title: __('Agent')},
                        {field: 'jine', title: __('Jine')},
                        {field: 'dw', title: __('Dw')},
                        {field: 'video', title: __('Video')},
                        {field: 'photo', title: __('Photo')},
                        {field: 'av', title: __('Av')},
                        {field: 'tvideo', title: __('Tvideo')},
                        {field: 'now', title: __('Now')},
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
