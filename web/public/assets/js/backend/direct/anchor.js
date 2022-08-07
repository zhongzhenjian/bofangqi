define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/anchor/index' + location.search,
                    add_url: 'direct/anchor/add',
                    edit_url: 'direct/anchor/edit',
                    del_url: 'direct/anchor/del',
                    multi_url: 'direct/anchor/multi',
                    table: 'anchor',
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
                        {field: 'name', title: __('Name')},
                        {field: 'sex', title: __('Sex'), searchList: {"0":__('Sex 0'),"1":__('Sex 1')}, formatter: Table.api.formatter.normal},
                        {field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'level', title: __('Level')},
                        {field: 'content', title: __('Content')},
                        {field: 'fans', title: __('Fans')},
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