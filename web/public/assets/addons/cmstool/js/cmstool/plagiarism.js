define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {

            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"),function(res){
                    Fast.api.open("cmstool/plagiarism/run","仿站进度（完成<span id='jindu'>0%</span>）");
                    return false;
                });
            }
        }
    };
    return Controller;
});