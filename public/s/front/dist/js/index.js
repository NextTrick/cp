$(function() {
  var modal_login;
  modal_login = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      btn: 'a[name=modal]',
      btnClose: '.modal_box .close',
      modalOutside: '#mask',
      btnRecovery: '#btn_recovery',
      btnChangePass: '#btn_change_password',
      errorMessage: '.error_message',
      closeErrorMessage: '.error_message .icon'
    };
    catchDom = function() {
      dom.btn = $(st.btn);
      dom.btnClose = $(st.btnClose);
      dom.modalOutside = $(st.modalOutside);
      dom.btnRecovery = $(st.btnRecovery);
      dom.btnChangePass = $(st.btnChangePass);
      dom.errorMessage = $(st.errorMessage);
      dom.closeErrorMessage = $(st.closeErrorMessage);
    };
    suscribeEvents = function() {
      dom.btn.on('click', events.openModal);
      dom.btnClose.on('click', events.closeModal);
      dom.modalOutside.on('click', events.closeClickOutside);
      dom.btnRecovery.on('click', events.closeRecoveryModal);
      dom.btnChangePass.on('click', events.closeNewPassModal);
      dom.closeErrorMessage.on('click', events.closeErrorMessage);
    };
    events = {
      openModal: function(e) {
        var id, maskHeight, maskWidth, winH, winW;
        e.preventDefault();
        id = $(this).attr('href');
        maskHeight = $(document).height();
        maskWidth = $(window).width();
        $('#mask').css({
          'width': maskWidth,
          'height': maskHeight
        });
        $('body').animate({
          scrollTop: 0
        }, '500');
        $('#mask').fadeIn(500);
        $('#mask').fadeTo("slow", 0.9);
        winH = $(window).height();
        winW = $(window).width();
        $(id).css('top', 20);
        $(id).css('left', winW / 2 - $(id).width() / 2);
        return $(id).fadeIn(1000);
      },
      closeModal: function(e) {
        e.preventDefault();
        $('#mask, .window').hide();
        return $('.modal_box').hide();
      },
      closeClickOutside: function() {
        $(this).hide();
        return $('.modal_box').hide();
      },
      closeRecoveryModal: function() {
        return $('#modal_recovery_password').hide();
      },
      closeNewPassModal: function() {
        return $('#modal_new_password').hide();
      },
      closeErrorMessage: function() {
        return dom.errorMessage.addClass('hide');
      }
    };
    functions = {
      validateData: function() {}
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  modal_login().init();
});
