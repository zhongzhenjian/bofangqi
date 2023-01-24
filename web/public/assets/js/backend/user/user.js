define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "用户名";};

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/user/index',
                    add_url: 'user/user/add',
                    edit_url: 'user/user/edit',
                    del_url: 'user/user/del',
                    multi_url: 'user/user/multi',
                    table: 'user',
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
                        {field: 'id', title: __('Id'), sortable: true},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
	                    {field: 'avatar', title: __('Avatar'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false},
	                    {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
	                    {field: 'bio', title: __('Bio'), operate: 'LIKE'},
	                    {field: 'gender', title: __('Gender'), operate: 'LIKE'},
	                    //{field: 'devicecode', title: __('设备码'), operate: 'LIKE'},
	                    {field: 'birthday', title: __('Birthday'), operate: 'LIKE'},
	                    {field: 'area', title: __('地区'), operate: 'LIKE'},
	                    {field: 'hl', title: __('婚恋'), operate: 'LIKE'},
	                    {field: 'jyyx', title: __('交友取向'), operate: 'LIKE'},
	                    {field: 'xqx', title: __('性取向'), operate: 'LIKE'},
	                    //{field: 'vip', title: __('vip等级'), formatter: Table.api.formatter.status, searchList: {'0': __('黄铜'), '1': __('白银'),'2':'黄金'}},
	                    {field: 'vip_time', title: __('vip到期时间'), operate: 'RANGE', addclass: 'datetimerange', sortable: true},
	                    //{field: 'integral', title: __('积分'), operate: 'LIKE'},
	                    {field: 'money', title: __('Money'), operate: 'LIKE'},
	                    {field: 'num', title: __('短视频次数'), operate: 'LIKE'},
	                    {field: 'num_t', title: __('长视频次数'), operate: 'LIKE'},
	                    {field: 'guanzhu', title: __('TA的关注'), operate: 'false'},
	                    {field: 'fensi', title: __('粉丝数'), operate: 'false'},
                        {field: 'agentlevel', title: __('代理层级'), operate: 'LIKE'},
                        {field: 'loginip', title: __('登录IP'), operate: 'LIKE'},
	                    //{field: 'agent', title: __('代理'), formatter: Table.api.formatter.status, searchList: {'0': __('非'), '1': __('是')}},
	                    //{field: 'number', title: __('推广码'), operate: 'LIKE'},
	                    //{field: 'photo', title: __('二维码'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false},
	                    {field: 'createtime', title: __('注册时间'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
	                    {field: 'status', title: __('Status'), formatter: Table.api.formatter.status, searchList: {normal: __('Normal'), hidden: __('Hidden')}},
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
