$(function() {
  var modal_login, open_tooltip, user_account;
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
      watchLegal: '.watch_legal'
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
    };
    suscribeEvents = function() {
      dom.btn.on('click', events.openModal);
      dom.btnClose.on('click', events.closeModal);
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
          $.ajax({
            type: "POST",
            url: baseUrl+'modificar-password',
            data:{password:$('#password_new').val(), password_repeat:$('#password_repeat').val(), codigo_recuperacion:$('#codigo_recuperacion').val(),  token:$('#token_csrf').val()},
            dataType: 'json',
            success: function(data){
                $('#token_csrf').val(data.token);
                if (data.success) {
                    $('#modal_new_password').hide();
                    functions.openModalById('#modal_new_password_response');
                } else {
                    $('#error_new_password').html(data.message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
            }
        });
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
        $(this).children('.content_asociate_card').show()
        //dom.contentAsociate.show();
      },
      hideAsociateCard: function(e) {
        e.stopPropagation();
        dom.boxTooltip.show();
        dom.contentAsociate.hide();
      },
      asociateCard: function(e) {
        var duplicate_box;
        e.preventDefault();
        duplicate_box = $(this).parent().parent().parent().children('.duplicate_box');
        //alert(duplicate_box.html())
        if (dom.asociateForm.parsley().isValid()) {
          $(this).parent().parent().hide();
          var nombre = $(this).parent().parent().children('form').children('#nombre').val();
          //alert(nombre)
          $(this).parent().parent().parent().children('.loading').show();
          $.ajax({
            type: "POST",
            url: $('#form_asociar_nueva_tarjeta').attr('action'),
            data: $('#form_asociar_nueva_tarjeta').serialize(),
            dataType: 'json',
            success: function(data) {
              if (data.success === false && data.type === 'existe_nombre') {
                //alert('el nombre ya esta en uso' + duplicate_box.html());
                duplicate_box.children('p').children('strong').text('"' + nombre + '" ');
                
                duplicate_box.show();
                dom.loading.hide();
              } else {
                if (data.success) {
                  functions.successAsociate();
                  setTimeout(function(){location.reload();}, 4000);
                } else {
                  functions.errorAsociate();
                }
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              functions.errorAsociate();
            }
          });
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
        var nombre = $(this).parent().children('.input_name').val();
        //alert(duplicate_box.children('p').text())
        duplicate_box.children('p').children('strong').text('"' + nombre + '" ');
        //alert(duplicate_box.html())
        sufix = $(this).data('sufix');
        $('#edit_nombre_' + sufix).val($.trim($('#org_nombre_'+sufix).html()));
        if ($(this).hasClass('active')) {
          $(this).parent().children(st.nameCard).text($(this).parent().children(st.inputCardName).val());
          $(this).removeClass('active');
          $(this).parent().children(st.nameCard).show();
          $(this).parent().children(st.inputCardName).hide();
          
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
      logout: '.logout'
    };
    catchDom = function() {
      dom.userAccount = $(st.userAccount);
      dom.logout = $(st.logout);
    };
    suscribeEvents = function() {
      dom.userAccount.on('click', events.openLogoutOption);
    };
    events = {
      openLogoutOption: function(e) {
        e.preventDefault();
        if (dom.logout.hasClass('active')) {
          dom.logout.removeClass('active');
        } else {
          dom.logout.addClass('active');
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
  user_account().init();
  open_tooltip().init();
  modal_login().init();
});
