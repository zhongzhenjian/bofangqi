//此方法返回日期
function today(AddDayCount) {
    const dd = new Date();
    dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
    let y = dd.getFullYear();
    let m = dd.getMonth()+1;//获取当前月份的日期
    let d = dd.getDate();
    //判断月
    if (m < 10) {
        m = "0" + m;
    }
    //判断日
    if (d < 10) {
        d = "0" + d;
    }
    return y + "-" + m + "-" + d;
}


define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	$.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "IP地址";};

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mom/mom/index' + location.search,
                    add_url: 'mom/mom/add',
                    //edit_url: 'mom/mom/edit',
                    del_url: 'mom/mom/del',
                    multi_url: 'mom/mom/multi',
                    table: 'monitor',
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
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime, defaultValue: today(0) + " 00:00:00 - " + today(0) + ' 23:59:59', operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'id', title: __('Id')},
                        {field: 'ip', title: __('Ip')},
	                    {field: 'address', title: __('地址')},
	                    {field: 'user.username', title: __('User.username')},
	                    {field: 'user.mobile', title: __('手机号')},
                        {field: 'num', title: __('Num')},
	                    {field: 'class', title: __('类型'),formatter: Table.api.formatter.status, searchList: {'0': __('游客'), '1': __('会员'), '2': __('VIP'), '3': __('过期VIP')}},

                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
	        //绑定TAB事件
	        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		        // var options = table.bootstrapTable(tableOptions);
		        var typeStr = $(this).attr("href").replace('#', '');
		        var options = table.bootstrapTable('getOptions');
		        options.pageNumber = 1;
		        options.queryParams = function (params) {
			        // params.filter = JSON.stringify({type: typeStr});
			        params.type = typeStr;
			
			        return params;
		        };
		        table.bootstrapTable('refresh', {});
		        return false;
		
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



