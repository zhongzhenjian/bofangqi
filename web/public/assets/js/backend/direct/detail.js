define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'direct/detail/index' + location.search
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
                        // {checkbox: true},
                        {field: 'housename', title: '房间名称'},
                        {field: 'title', title: '主播名称'},
                        // {field: 'title', title: '主播名称'},
                        {field: 'img', title:'主播头像', events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'address', title: '播放地址',formatter: Table.api.formatter.url},
                        {field: 'is_tuijian', title:'是否推荐', formatter: Table.api.formatter.status, searchList: {'0': '未推荐', '1': '已推荐'}},
	                    {
		                    field: 'buttons',
		                    width: "120px",
		                    title: '操作',
		                    table: table,
		                    events: Table.api.events.operate,
		                    buttons: [
			                    {
				                    name: 'ajax',
				                    text: '推荐',
				                    title: '推荐',
				                    classname: 'btn btn-success btn-edit btn-ajax',
				                    icon: '',
				                    url: 'direct/detail/tuijian?title={title}&housename={housename}&img={img}&address={address}&houseimg={houseimg}&roomurl={roomurl}&xuhao={xuhao}',
				                    success: function (data) {
				                        alert('133');
					                    console.log(data);
				                    },
				                    visible: function (row) {
					                    //返回true时按钮显示,返回false隐藏
					                    return true;
				                    }
			                    },
			                    {
				                    name: 'addtabs',
				                    text: '取消推荐',
				                    title: '取消推荐',
				                    classname: 'btn btn-danger btn-del btn-ajax',
				                    // confirm:'您确定要取消吗',
				                    icon: '',
				                    url: 'direct/detail/canceltuijian?title={title}&housename={housename}&img={img}&address={address}&houseimg={houseimg}&roomurl={roomurl}&xuhao={xuhao}',
				                    success: function (data) {
					                    //Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
				                    },
				                    visible: function (row) {
					                    //返回true时按钮显示,返回false隐藏
					                    return true;
				                    }
			                    },
		                    ],
		                    formatter: Table.api.formatter.buttons
	                    },
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
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