define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/directadv/index' + location.search,
                    add_url: 'direct/directadv/add',
                    edit_url: 'direct/directadv/edit',
                    del_url: 'direct/directadv/del',
                    multi_url: 'direct/directadv/multi',
                    table: 'direct_adv',
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
                        {field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'url', title: __('Url'), formatter: Table.api.formatter.url},
	                    {field: 'status', title: __('分类'), searchList: {"0":__('顶部广告'),"1":__('底部广告')}, formatter: Table.api.formatter.normal},
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
