define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/directfollow/index' + location.search,
                    add_url: 'direct/directfollow/add',
                    edit_url: 'direct/directfollow/edit',
                    del_url: 'direct/directfollow/del',
                    multi_url: 'direct/directfollow/multi',
                    table: 'direct_follow',
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
                        {field: 'anchorid', title: __('Anchorid')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'anchor.id', title: __('Anchor.id')},
                        {field: 'anchor.name', title: __('Anchor.name')},
                        {field: 'anchor.sex', title: __('Anchor.sex')},
                        {field: 'anchor.image', title: __('Anchor.image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'anchor.level', title: __('Anchor.level')},
                        {field: 'anchor.content', title: __('Anchor.content')},
                        {field: 'anchor.fans', title: __('Anchor.fans')},
                        {field: 'anchor.create_time', title: __('Anchor.create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'anchor.update_time', title: __('Anchor.update_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'user.mobile', title: __('User.mobile')},
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