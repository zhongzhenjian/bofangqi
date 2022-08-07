/**
 * 返回上一个页面
 */
function back() {
    window.history.back();
}

/**
 * 判断手机类型是否为android系统
 */
function isAndroid() {
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    return isAndroid;
}

/**
 * 判断手机类型是否为ios系统
 */
function isiOS() {
    var u = navigator.userAgent;
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    return isiOS;
}


function openTab(url) {
    window.open(url,'_blank');
}

