define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            var type=$("input[type='radio'][checked]").val();
            $(".c_type_"+type).show();
            Controller.api.bindevent();
        },
        temp:function(){
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cmstool/collect/temp',
                }
            });
            var table = $("#table");
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                columns: [
                    {field: 'id', title: __('ID')},
                    {field: 'name', title: __('模板名称')},
                    {field: 'engine', title: __('采集引擎')},
                    {field: 'active', title: __('队列中')},
                    {field: 'success', title: __('已完成')},
                    {
                        field: 'operate',
                        width: "200px",
                        title: __('Operate'),
                        table: table,
                        events: Table.api.events.operate,
                        buttons: [
                            {
                                name: 'check',
                                text: __('选择'),
                                classname: 'btn btn-xs btn-success btn-click',
                                icon: 'fa fa-check',
                                click: function (data,row) {
                                    parent.location.href="index?engine="+row.engine+"&id="+row.id;
                                }
                            },
                            {
                                name: 'check',
                                text: __('重置'),
                                classname: 'btn btn-xs btn-info btn-click',
                                icon: 'fa fa-reply',
                                confirm: '重置将清除所有的采集记录，你确定要重置吗？',
                                click: function (data,row) {
                                    Fast.api.ajax("cmstool/collect/reset?engine="+row.engine+"&id="+row.id,function (res) {
                                        location.reload();
                                    });
                                }
                            },
                            {
                                name: 'delete',
                                text: __('删除'),
                                classname: 'btn btn-xs btn-danger btn-click',
                                confirm: '你确定要删除吗？',
                                icon: 'fa fa-trash',
                                click: function (data,row) {
                                    Fast.api.ajax("cmstool/collect/delete?engine="+row.engine+"&id="+row.id,function (res) {
                                        location.reload();
                                    });
                                }
                            },
                        ],
                        formatter: Table.api.formatter.operate
                    },
                ],
                pagination: false,
                commonSearch: false,
                search: false,
                showExport: false,
                searchFormVisible:false
            });
        },
        queueview:function(){
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    active_url: 'cmstool/collect/active',
                    success_url: 'cmstool/collect/_success',
                }
            });
            var activeTable = $("#activeTable");
            // 初始化表格
            activeTable.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.active_url,
                columns: [
                    {field: 'id', title: __('ID')},
                    {field: 'url', title: __('URL')},
                ],
                commonSearch: false,
                search: false,
                showExport: false,
                searchFormVisible:false
            });

            var successTable = $("#successTable");
            // 初始化表格
            successTable.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.success_url,
                columns: [
                    {field: 'id', title: __('ID')},
                    {field: 'url', title: __('URL')},
                    {field: 'time', title: __('耗时')},
                    {field: 'status', title: __('状态'),formatter:function(res){
                            if(res==1)return '成功';
                            if(res==-1)return '失败';
                        }},
                    {field: 'error', title: __('错误')},
                ],
                commonSearch: false,
                search: false,
                showExport: false,
                searchFormVisible:false
            });
        },
        api: {
            bindevent: function () {
                var property=outproperty;
                if(property.length>0){
                    bootstrap();
                }
                function bootstrap(){
                    var html="";
                    for(var i=0;i<property.length;i++){
                        var pkey=property[i].pkey;
                        var pvalue=property[i].pvalue;
                        var str=$("#hidehtml").html();
                        str=str.replace("{pkey}",pkey);
                        str=str.replace("{_pkey}",pkey);
                        str=str.replace("{pvalue}",pvalue);
                        html+=str;
                    }
                    $("#property").html(html);
                }

                function check(key){
                    var check=false;
                    $("#property input[name='pkey']").each(function(){
                        var v=$(this).val();
                        if(key==v){
                            layer.msg("key不能重复");
                            check=true;
                        }
                    });
                    return check;
                }

                window.deleteProperty=function(pkey,e){
                    if($(e).attr("disabled"))return;
                    for(var i=0;i<property.length;i++){
                        var _pkey=property[i].pkey;
                        if(pkey==_pkey){
                            property.splice(i,1);
                        }
                    }
                    bootstrap();
                }

                window.stopCollect=function(){
                    $("input,select,textarea,.adddisabled").attr("disabled",false);
                    $("#start>i").removeClass("rotate");
                    $("#property").removeClass("grey");
                }

                $("form input[type='radio']").on('change',function () {
                    var type=$(this).val();
                    $(".c_type_1,.c_type_2,.c_type_3,.c_type_4").hide();
                    $(".c_type_"+type).show();
                });

                $("#queue").on('click',function () {
                    Fast.api.open('cmstool/collect/queueview','采集队列');
                });

                $("#stop").on('click',function () {
                    Fast.api.ajax("cmstool/collect/stop",function (res) {
                        layer.msg(res);
                        $("input,select,textarea,.adddisabled").attr("disabled",false);
                        $("#start>i").removeClass("rotate");
                        $("#property").removeClass("grey");
                        return false;
                    });
                });
                
                $("#changeTemp").on('click',function () {
                    Fast.api.open('cmstool/collect/temp','管理模板');
                });


                $("#addpropery").on('click',function(){
                    if($(this).attr("disabled"))return;
                    var html=$("#myModal").html();
                    html=html.replace("{propertype}","propertype");
                    layer.open({
                        title:'添加属性',
                        content:html,
                        area: ['600px', '280px'],
                        btn:['确认','取消'],
                        yes:function(res){
                            var changetype=$("form[name='propertype'] select")[0].value;
                            var pkey;
                            var pvalue;
                            if(changetype==1){
                                pkey=$("form[name='propertype'] input[type=text]")[0].value;
                                pvalue="/"+$("form[name='propertype'] input[type=text]")[1].value+"/";
                            }
                            if(changetype==2){
                                pkey=$("form[name='propertype'] input[type=text]")[0].value;
                                pvalue=$("form[name='propertype'] input[type=text]")[1].value;
                            }
                            var c=check(pkey);
                            if(c)return;
                            if(pkey=='' || pvalue==''){
                                layer.msg("属性与值都不能为空");
                                return false;
                            }
                            var obj={pkey:pkey,pvalue:pvalue};
                            property.push(obj);
                            bootstrap();
                            layer.close(res);
                        }
                    });
                });

                Form.api.bindevent($("form[role=form]"),function(res){
                    $("input,select,textarea,.adddisabled").attr("disabled",true);
                    $("#start>i").addClass("rotate");
                    $("#property").addClass("grey");
                    layer.msg(res);
                    setTimeout(function () {
                        Fast.api.open('cmstool/collect/log','采集日志');
                    },1000);
                    return false;
                });
            }
        }
    };
    return Controller;
});