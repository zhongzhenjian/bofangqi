define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'coll/coll/index' + location.search,
                    add_url: 'coll/coll/add',
                    edit_url: 'coll/coll/edit',
                    del_url: 'coll/coll/del',
                    multi_url: 'coll/coll/multi',
                    table: 'collection',
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
                        {field: 'userid', title: __('Userid')},
                        {field: 'videoid', title: __('Videoid')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'user.id', title: __('User.id')},
                        {field: 'video.id', title: __('Video.id')},
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