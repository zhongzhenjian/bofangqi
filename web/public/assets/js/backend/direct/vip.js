define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/vip/index' + location.search,
                    add_url: 'direct/vip/add',
                    edit_url: 'direct/vip/edit',
                    del_url: 'direct/vip/del',
                    multi_url: 'direct/vip/multi',
                    table: 'vip',
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
                        {field: 'direct_id', title: __('Direct_id')},
                        {field: 'name', title: __('Name')},
                        {field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'level', title: __('Level')},
                        {field: 'sex', title: __('Sex')},
                        {field: 'contribution', title: __('Contribution')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'direct.id', title: __('Direct.id')},
                        {field: 'direct.anchor_id', title: __('Direct.anchor_id')},
                        {field: 'direct.room_number', title: __('Direct.room_number')},
                        {field: 'direct.list', title: __('Direct.list')},
                        {field: 'direct.direct_name', title: __('Direct.direct_name')},
                        {field: 'direct.direct_image', title: __('Direct.direct_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'direct.direct_url', title: __('Direct.direct_url'), formatter: Table.api.formatter.url},
                        {field: 'direct.online', title: __('Direct.online')},
                        {field: 'direct.switch', title: __('Direct.switch'), table: table, formatter: Table.api.formatter.toggle},
                        {field: 'direct.create_time', title: __('Direct.create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'direct.update_time', title: __('Direct.update_time'), operate:'RANGE', addclass:'datetimerange'},
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