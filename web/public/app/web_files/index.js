
/**
 * 区分pc或者移动端内容
 */
function showPcOrMobileContent() {
//   if (!mobile()) { // PC 端显示pc相关内容
//     $('.dur-pc-website').removeClass('hide');
//     $('.dur-mobile-website').addClass('hide');

//   } else { // 移动端显示移动端内容
//     $('.dur-mobile-website').removeClass('hide');
//     $('.dur-pc-website').addClass('hide');
//   }
}


/**
 * 判断是否为手机端
 * @returns {boolean}
 */
function mobile() {
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(
      navigator.userAgent)) {
    return true;
  } else {
    return false;
  }
}

/**
 * 显示testflight 安装弹窗
 */
function showPopup(className) {
  var ele = $('.' + className);
  ele.removeClass('hide');
  ele.addClass('show');
}

/**
 * 显示testflight 安装弹窗
 */
function hidePopup(className) {
  var ele = $('.' + className);
  ele.removeClass('show');
  ele.addClass('hide');
}


/**
 * 初始化swiper
 */
function initSwiper() {
  var current_slider_index = localStorage.getItem('current_slider_index');
  var swiper = new Swiper('.swiper-container', {
    direction: 'vertical',
    initialSlide: current_slider_index
  });
  swiper.on('slideChange', function() {
    var index = this.activeIndex;
    localStorage.setItem('current_slider_index', index == '3' ? '3' : '0');
    if (index == 1) { // 切换到第二页
      $('.dur-image-layer-1').addClass('dur-image-layer-1-active');
      $('.dur-image-layer-2').addClass('dur-image-layer-2-active');
      $('.dur-image-layer-3').addClass('dur-image-layer-3-active');
    } else {
      $('.dur-image-layer-1').removeClass('dur-image-layer-1-active');
      $('.dur-image-layer-2').removeClass('dur-image-layer-2-active');
      $('.dur-image-layer-3').removeClass('dur-image-layer-3-active');
    }

    // 切换到第三页
    if (index == 2) {
      $('.dur-step-3-animation').addClass('dur-step3-image-animation');
      $('.dur-step-3-animation-image').addClass('dur-step-3-animation-image-active');
      $('.dur-step-3-animation-text').addClass('dur-step-3-animation-text-active');
    } else {
      $('.dur-step-3-animation').removeClass('dur-step3-image-animation');
      $('.dur-step-3-animation-image').removeClass('dur-step-3-animation-image-active');
      $('.dur-step-3-animation-text').removeClass('dur-step-3-animation-text-active');
    }
  });
}


/**
 * 初始化必要按钮点击
 *
 */
function initBtnClick() {

  $('.btn-down-home-android').on('click', function() {
    if (isiOS()) {
      $('body').dalutoast('您使用的是苹果手机,请使用H5版本');
    } else {
      window.location.href = window.apkurl
    //   $('body').dalutoast('点击了安卓下载');
      // showPopup('dur-android-tips-box');
    }
  });
  $(".btn-down-home-ios").on('click',function(){
      window.location.href = window.h5url
  })
  $('.btn-down').on('click', function() {
    if (isAndroid()) {
         window.location.href = window.apkurl
    //   $('body').dalutoast('安卓点击了下载');
      // showPopup('dur-android-tips-box');
    }else{
        window.location.href = window.h5url
    //   $('body').dalutoast('ios点击了下载');
    }
  });
  $('.btn-down-android').on('click', function() {
    hidePopup('dur-android-tips-box');
  });
}

/**
 * 保存到桌面
 */
function saveToDesktop() {
  window.location.href = './static/config/fq.mobileconfig'
}
