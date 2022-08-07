define(['jquery', 'bootstrap', 'backend', 'table', 'form','selectpage'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'community/topping/index' + location.search,
                    add_url: 'community/topping/add',
                    // edit_url: 'community/topping/edit',
                    del_url: 'community/topping/del',
                    multi_url: 'community/topping/multi',
                    table: 'topping',
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
                        {field: 'communityid', title: __('Communityid')},
	                    {field: 'community.title', title: __('Community.title')},
	                    {field: 'list', title: __('类型'), searchList: {"0":__('短文'),"1":__('视频'),"2":__('图片'),"4":__('问答')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
	        $(document).on("change", "#c-list", function () {
		        $.post("community/topping/community",{
			        //搜索条件，上一个selectpage选择完后传过来的id作为此次搜索的条件
			        class:$('#c-list').val()
		        },function(result){
			        var str = '';
			        $.each(result, function (n, value) {
				        str += '<option value="' + n + '" {in name="key" value=""}selected{/in}>' + value + '</option>';
			        });
			        $('#c-list1').html(str);
		        });
	        });
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
