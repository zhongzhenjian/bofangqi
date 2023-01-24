define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
	$.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "视频标题";};

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'video/dvideo/index' + location.search,
                    add_url: 'video/dvideo/add',
                    edit_url: 'video/dvideo/edit',
                    del_url: 'video/dvideo/del',
                    multi_url: 'video/dvideo/multi',
                    table: 'video',
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
                        {field: 'title', title: __('Title')},
                        {field: 'video_image', title: __('Video_image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'url', title: __('Url'), formatter: Table.api.formatter.url},
	                    // {field: 'actress.name', title: __('演员')},
	                    {field: 'subordinate.name', title: __('视频分类'),operate: false},
                        {
                            field: 'mosaic',
                            title: __('马赛克'),
                            formatter: Table.api.formatter.status,
                            searchList: {'1': __('有码'), '2': __('无码')},
                             sortable: true
                        },
                        {
                            field: 'duration',
                            title: __('视频长短'),
                            formatter: Table.api.formatter.status,
                            searchList: {'short': __('短视频'), 'long': __('长视频')},
                            sortable: true
                        },
                        {
                            field: 'area',
                            title: __('地区'),
                            formatter: Table.api.formatter.status,
                            searchList: {'TaiWan ': __('台湾'), 'OuMei': __('欧美'), 'RiBen': __('日本'), 'GuoChan': __('国产'), 'HanGuo': __('韩国')}
                        },
                        // {field: 'belong.name', title: __('所属')},
                        {field: 'comments', title: __('Comments'),sortable: true},
                        {field: 'play_times', title: __('播放次数'),sortable: true},
                        {field: 'score', title: __('评分(0~10)')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', sortable: true},
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
