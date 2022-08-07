define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/direct/index' + location.search,
                    add_url: 'direct/direct/add',
                    edit_url: 'direct/direct/edit',
                    del_url: 'direct/direct/del',
                    multi_url: 'direct/direct/multi',
                    table: 'direct',
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
                        {field: 'anchor_id', title: __('Anchor_id')},
	                    {field: 'anchor.name', title: __('Anchor.name')},
	                    {field: 'anchor.image', title: __('Anchor.image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'room_number', title: __('Room_number')},
	                    {field: 'directclass.title', title: __('Directclass.title')},
                        {field: 'direct_name', title: __('Direct_name')},
                        {field: 'direct_image', title: __('Direct_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'online', title: __('Online')},
                        {field: 'switch', title: __('Switch'), table: table, formatter: Table.api.formatter.toggle},
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
