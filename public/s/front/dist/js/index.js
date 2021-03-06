$(function() {
  var carrito, mis_datos, modal_login, open_tooltip, pagos, recargas, user_account;
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
      closeErrorMessage: '.error_message .icon',
      watchLegal: '.watch_legal',
      closeLegalModal: '#modal_watch_legal .modal_content h3 span'
    };
    catchDom = function() {
      dom.btn = $(st.btn);
      dom.btnClose = $(st.btnClose);
      dom.modalOutside = $(st.modalOutside);
      dom.btnRecovery = $(st.btnRecovery);
      dom.btnChangePass = $(st.btnChangePass);
      dom.errorMessage = $(st.errorMessage);
      dom.closeErrorMessage = $(st.closeErrorMessage);
      dom.watchLegal = $(st.watchLegal);
      dom.closeLegalModal = $(st.closeLegalModal);
    };
    suscribeEvents = function() {
      dom.btn.on('click', events.openModal);
      dom.btnClose.on('click', events.closeModal);
      dom.closeLegalModal.on('click', events.closeModal);
      dom.modalOutside.on('click', events.closeClickOutside);
      dom.btnRecovery.on('click', events.closeRecoveryModal);
      dom.btnChangePass.on('click', events.closeNewPassModal);
      dom.closeErrorMessage.on('click', events.closeErrorMessage);
      dom.watchLegal.on('click', events.openModal);
    };
    events = {
      openModal: function(e) {
        var id;
        e.preventDefault();
        id = $(this).attr('href');
        functions.openModalById(id);
      },
      closeModal: function(e) {
        e.preventDefault();
        $('#mask, .window').hide();
        $('.modal_box').hide();
      },
      closeClickOutside: function() {
        $(this).hide();
        $('.modal_box').hide();
      },
      closeRecoveryModal: function() {
        $.ajax({
          type: "POST",
          url: baseUrl + 'recuperar-password',
          data: {
            email: $('#email_recuperar').val(),
            token: $('#token_csrf').val()
          },
          dataType: 'json',
          success: function(data) {
            $('#token_csrf').val(data.token);
            if (data.success) {
              functions.openModalById('#modal_recovery_response');
              $('#modal_recovery_password').hide();
            } else {
              $('#error_recuperar_password').html(data.message);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {}
        });
      },
      closeNewPassModal: function() {
        $('#modal_new_password').hide();
        functions.openModalById('#modal_new_password_response');
      },
      closeErrorMessage: function() {
        dom.errorMessage.addClass('hide');
      }
    };
    functions = {
      openModalById: function(id) {
        var maskHeight, maskWidth, winH, winW;
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
        $(id).fadeIn(1000);
      },
      openModalNewPassword: function() {
        if ($('#modal_new_password').data('open') === 1) {
          functions.openModalById('#modal_new_password');
        }
      },
      openModalSigninResponse: function() {
        if ($('#modal_response_signin').data('open') === 1) {
          functions.openModalById('#modal_response_signin');
        }
      }
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
      functions.openModalNewPassword();
      functions.openModalSigninResponse();
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
      duplicate: '.duplicate_box',
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
        dom.tooltip.show();
      },
      closeTooltip: function() {
        dom.tooltip.hide();
      },
      showAsociateCard: function() {
        dom.boxTooltip.hide();
        dom.contentAsociate.show();
      },
      hideAsociateCard: function(e) {
        e.stopPropagation();
        dom.boxTooltip.show();
        dom.contentAsociate.hide();
      },
      asociateCard: function(e) {
        var duplicate_box;
        e.preventDefault();
        duplicate_box = $(this).parent().parent().children('.duplicate_box');
        if (dom.asociateForm.parsley().isValid()) {
          dom.contentAsociate.hide();
          dom.loading.show();
          $.ajax({
            type: "POST",
            url: $('#form_asociar_nueva_tarjeta').attr('action'),
            data: $('#form_asociar_nueva_tarjeta').serialize(),
            dataType: 'json',
            success: function(data) {
              if (data.success === false && data.type === 'existe_nombre') {
                alert('el nombre ya esta en uso');
                duplicate_box.show();
                dom.contentAsociate.hide();
              } else {
                if (data.success) {
                  functions.successAsociate();
                } else {
                  functions.errorAsociate();
                }
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              functions.errorAsociate();
            }
          });

          /*setTimeout ->
          						 * Active success response
          						functions.successAsociate()
          						 * Active error response
          						#functions.errorAsociate()
          					, 2000
          					 * agregar un settimeout para que se oculte el success u error
          					 * luego de eso recargar
          					return false
           */
        } else {
          dom.asociateForm.parsley().validate();
        }
      },
      watchMore: function() {
        if ($(this).hasClass('active')) {
          $(this).parent().parent().children(st.topCardContent).show();
          $(this).parent().parent().children(st.showMoreContent).hide();
          $(this).text('Ver más');
          $(this).removeClass('active');
        } else {
          $(this).parent().parent().children(st.topCardContent).hide();
          $(this).parent().parent().children(st.showMoreContent).show();
          $(this).text('Ver menos');
          $(this).addClass('active');
        }
      },
      showTooltipBonus: function() {
        $(this).addClass('active');
        $(this).parent().parent().children(st.tooltipBonus).show();
      },
      hideTooltipBonus: function() {
        $(this).removeClass('active');
        $(this).parent().parent().children(st.tooltipBonus).hide();
      },
      editCardName: function() {
        var duplicate_box, sufix;
        duplicate_box = $(this).parent().parent().parent().children('.duplicate_box');
        if ($(this).hasClass('active')) {
          $(this).parent().children(st.nameCard).text($(this).parent().children(st.inputCardName).val());
          $(this).removeClass('active');
          $(this).parent().children(st.nameCard).show();
          $(this).parent().children(st.inputCardName).hide();
          sufix = $(this).data('sufix');
          $.ajax({
            type: "POST",
            url: baseUrl + 'mis-tarjetas/editar-nombre',
            data: {
              nombre: $('#edit_nombre_' + sufix).val(),
              numero: $('#edit_numero_' + sufix).val()
            },
            dataType: 'json',
            success: function(data) {
              if (data.success) {

              } else {
                duplicate_box.show();
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {}
          });
        } else {
          $(this).addClass('active');
          $(this).parent().children(st.nameCard).hide();
          $(this).parent().children(st.inputCardName).show();
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
  user_account = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      userAccount: '.user_account',
      menuOptions: '.menu_options',
      userAccountMobile: '.user_option_mobile ul li .user_icon',
      menuAccountMobile: '.user_option_mobile ul li .menu_options'
    };
    catchDom = function() {
      dom.userAccount = $(st.userAccount);
      dom.menuOptions = $(st.menuOptions);
      dom.userAccountMobile = $(st.userAccountMobile);
      dom.menuAccountMobile = $(st.menuAccountMobile);
    };
    suscribeEvents = function() {
      dom.userAccount.on('click', events.openLogoutOption);
      dom.userAccountMobile.on('click', events.openMenu);
    };
    events = {
      openLogoutOption: function(e) {
        e.preventDefault();
        if (dom.userAccount.hasClass('active')) {
          dom.userAccount.removeClass('active');
          dom.menuOptions.hide();
        } else {
          dom.userAccount.addClass('active');
          dom.menuOptions.show();
        }
      },
      openMenu: function() {
        if (dom.menuAccountMobile.hasClass('active')) {
          dom.menuAccountMobile.removeClass('active');
        } else {
          dom.menuAccountMobile.addClass('active');
        }
      }
    };
    functions = {
      successAsociate: function() {}
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  recargas = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      less: '.cant_box .less',
      more: '.cant_box .more',
      detailContent: '.offers .col_3 .box_white .detail',
      openDetail: '.offers .col_3 .box_white .breadcrumb .detail'
    };
    catchDom = function() {
      dom.less = $(st.less);
      dom.more = $(st.more);
      dom.openDetail = $(st.openDetail);
    };
    suscribeEvents = function() {
      dom.less.on('click', events.substract);
      dom.more.on('click', events.add);
      dom.openDetail.on('click', events.openDetail);
    };
    events = {
      substract: function(e) {
        var actual;
        actual = $(this).next('input');
        if (actual.val() > 0) {
          actual.val(parseInt(actual.val()) - 1);
        }
      },
      add: function(e) {
        var actual;
        actual = $(this).prev('input');
        actual.val(parseInt(actual.val()) + 1);
      },
      openDetail: function(e) {
        if ($(this).hasClass('active')) {
          $(this).removeClass('active');
          $(this).parent().parent().children('.detail').hide();
        } else {
          $(this).addClass('active');
          $(this).parent().parent().children('.detail').show();
        }
      }
    };
    functions = {
      example: function() {}
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  pagos = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      optionBoleta: '.voucher .boleta',
      optionFactura: '.voucher .factura',
      contentBoleta: '.content_boleta',
      contentFactura: '.content_factura',
      watchDetail: '.watch_detail',
      hiddenDetail: '.hidden_detail',
      itemDetail: '.item .detail',
      cardOption: '.card',
      peOption: '.cards_option .pe',
      visaOption: '.cards_option .visa',
      equalAddress: '.equal_address'
    };
    catchDom = function() {
      dom.optionBoleta = $(st.optionBoleta);
      dom.optionFactura = $(st.optionFactura);
      dom.contentBoleta = $(st.contentBoleta);
      dom.contentFactura = $(st.contentFactura);
      dom.watchDetail = $(st.watchDetail);
      dom.hiddenDetail = $(st.hiddenDetail);
      dom.itemDetail = $(st.itemDetail);
      dom.cardOption = $(st.cardOption);
      dom.peOption = $(st.peOption);
      dom.visaOption = $(st.visaOption);
      dom.equalAddress = $(st.equalAddress);
    };
    suscribeEvents = function() {
      dom.optionBoleta.on('change', events.watchOpenBoletaForm);
      dom.optionFactura.on('change', events.watchOpenFacturaForm);
      dom.watchDetail.on('click', events.watchDetail);
      dom.hiddenDetail.on('click', events.hiddenDetail);
      dom.cardOption.on('click', events.changeCard);
      dom.equalAddress.on('change', events.copy);
    };
    events = {
      watchOpenBoletaForm: function(e) {
        dom.contentBoleta.show();
        dom.contentFactura.hide();
      },
      watchOpenFacturaForm: function(e) {
        dom.contentBoleta.hide();
        dom.contentFactura.show();
      },
      watchDetail: function() {
        $(this).hide();
        $(this).next().show();
        $(this).parent().prev().show();
      },
      hiddenDetail: function() {
        $(this).hide();
        $(this).prev().show();
        $(this).parent().prev().hide();
      },
      changeCard: function() {
        if ($(this).hasClass('pagoefectivo')) {
          $(this).addClass('active');
          $(this).next().removeClass('active');
          dom.peOption.prop('checked', true);
          dom.visaOption.prop('checked', false);
        }
        if ($(this).hasClass('visa')) {
          $(this).addClass('active');
          $(this).prev().removeClass('active');
          dom.visaOption.prop('checked', true);
          dom.peOption.prop('checked', false);
        }
      },
      copy: function() {
        $('.factura_address').val($('.fiscal_address').val());
      }
    };
    functions = {
      example: function() {}
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  carrito = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      cartPageHeight: '.cart_page',
      leftColHeight: '.cart_page > .right',
      removeItem: '.remove_icon'
    };
    catchDom = function() {
      dom.cartPageHeight = $(st.cartPageHeight);
      dom.leftColHeight = $(st.leftColHeight);
      dom.removeItem = $(st.removeItem);
    };
    suscribeEvents = function() {
      dom.removeItem.on('click', events.removeItem);
    };
    events = {
      removeItem: function(e) {
        $(this).parent().parent().remove();
      }
    };
    functions = {
      height: function() {
        dom.leftColHeight.height(dom.cartPageHeight.height());
      }
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
      functions.height();
    };
    return {
      init: initialize
    };
  };
  mis_datos = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      btnChangeImage: '.change_user_image'
    };
    catchDom = function() {
      dom.btnChangeImage = $(st.btnChangeImage);
    };
    suscribeEvents = function() {
      dom.btnChangeImage.on('click', events.changeImage);
    };
    events = {
      changeImage: function(e) {
        $('.image_file').click();
      }
    };
    functions = {
      example: function() {}
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
    };
    return {
      init: initialize
    };
  };
  mis_datos().init();
  carrito().init();
  pagos().init();
  recargas().init();
  user_account().init();
  open_tooltip().init();
  modal_login().init();
});
