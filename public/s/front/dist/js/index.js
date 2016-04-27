$(function() {
  var modal_login, open_tooltip;
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
  open_tooltip = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      addCard: '.add_card',
      tooltip: '.tooltip',
      boxTooltip: '.show_tooltip',
      contentAsociate: '.content_asociate_card',
      btnCancel: '.btn_cancel',
      loading: '.loading',
      btnAsociateCard: '.btn_asociate_card',
      asociateForm: '.asociate_form',
      success: '.success_box',
      error: '.error_box',
      watchMore: '.watch_more',
      topCardContent: '.top_card',
      showMoreContent: '.show_more_content',
      tooltipBonus: '.tooltip_bonus',
      activeTooltipBonus: '.show_more_content .line .left span',
      editCardName: '.card_title .edit_icon',
      nameCard: '.card_title .text',
      inputCardName: '.card_title .input_name'
    };
    catchDom = function() {
      dom.addCard = $(st.addCard);
      dom.tooltip = $(st.tooltip);
      dom.boxTooltip = $(st.boxTooltip);
      dom.contentAsociate = $(st.contentAsociate);
      dom.btnCancel = $(st.btnCancel);
      dom.loading = $(st.loading);
      dom.btnAsociateCard = $(st.btnAsociateCard);
      dom.asociateForm = $(st.asociateForm);
      dom.success = $(st.success);
      dom.error = $(st.error);
      dom.watchMore = $(st.watchMore);
      dom.tooltipBonus = $(st.tooltipBonus);
      dom.activeTooltipBonus = $(st.activeTooltipBonus);
      dom.editCardName = $(st.editCardName);
      dom.nameCard = $(st.nameCard);
      dom.inputCardName = $(st.inputCardName);
    };
    suscribeEvents = function() {
      dom.addCard.hover(events.openTooltip, events.closeTooltip);
      dom.addCard.on('click', events.showAsociateCard);
      dom.btnCancel.on('click', events.hideAsociateCard);
      dom.btnAsociateCard.on('click', events.asociateCard);
      dom.watchMore.on('click', events.watchMore);
      dom.activeTooltipBonus.hover(events.showTooltipBonus, events.hideTooltipBonus);
      dom.editCardName.on('click', events.editCardName);
    };
    events = {
      openTooltip: function() {
        return dom.tooltip.show();
      },
      closeTooltip: function() {
        return dom.tooltip.hide();
      },
      showAsociateCard: function() {
        dom.boxTooltip.hide();
        return dom.contentAsociate.show();
      },
      hideAsociateCard: function(e) {
        e.stopPropagation();
        dom.boxTooltip.show();
        return dom.contentAsociate.hide();
      },
      asociateCard: function(e) {
        e.preventDefault();
        if (dom.asociateForm.parsley().isValid()) {
          dom.contentAsociate.hide();
          dom.loading.show();
          setTimeout(function() {
            return functions.successAsociate();
          }, 2000);
          return false;
        } else {
          return dom.asociateForm.parsley().validate();
        }
      },
      watchMore: function() {
        if ($(this).hasClass('active')) {
          $(this).parent().parent().children(st.topCardContent).show();
          $(this).parent().parent().children(st.showMoreContent).hide();
          $(this).text('Ver más');
          return $(this).removeClass('active');
        } else {
          $(this).parent().parent().children(st.topCardContent).hide();
          $(this).parent().parent().children(st.showMoreContent).show();
          $(this).text('Ver menos');
          return $(this).addClass('active');
        }
      },
      showTooltipBonus: function() {
        $(this).addClass('active');
        return $(this).parent().parent().children(st.tooltipBonus).show();
      },
      hideTooltipBonus: function() {
        $(this).removeClass('active');
        return $(this).parent().parent().children(st.tooltipBonus).hide();
      },
      editCardName: function() {
        if ($(this).hasClass('active')) {
          $(this).parent().children(st.nameCard).text($(this).parent().children(st.inputCardName).val());
          $(this).removeClass('active');
          $(this).parent().children(st.nameCard).show();
          return $(this).parent().children(st.inputCardName).hide();
        } else {
          $(this).addClass('active');
          $(this).parent().children(st.nameCard).hide();
          return $(this).parent().children(st.inputCardName).show();
        }
      }
    };
    functions = {
      successAsociate: function() {
        dom.contentAsociate.hide();
        dom.loading.hide();
        dom.success.show();
      },
      errorAsociate: function() {
        dom.contentAsociate.hide();
        dom.loading.hide();
        dom.error.show();
      }
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  open_tooltip().init();
  modal_login().init();
});
