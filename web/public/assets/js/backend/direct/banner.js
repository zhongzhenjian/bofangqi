define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/banner/index' + location.search,
                    add_url: 'direct/banner/add',
                    edit_url: 'direct/banner/edit',
                    del_url: 'direct/banner/del',
                    multi_url: 'direct/banner/multi',
                    table: 'direct_banner',
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
	                    {field: 'url', title: __('Url')},
	                    {field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange'},
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
