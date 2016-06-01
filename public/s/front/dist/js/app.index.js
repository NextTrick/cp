$(function() {
  var modal_login, open_tooltip, user_account, recargas;
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
      closeLegalModal: '.modal_box_legal .modal_content h3 span',
      closeAsociateCardModal: '#how_asociate_card .modal_content h3 span',
      offersLogin : '.offers_login',
      menuIcon: '.menu_icon'
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
      dom.closeAsociateCardModal = $(st.closeAsociateCardModal);
      dom.offersLogin = $(st.offersLogin);
      dom.menuIcon = $(st.menuIcon);
    };
    suscribeEvents = function() {
      dom.btn.on('click', events.openModal);
      dom.btnClose.on('click', events.closeModal);
      dom.closeLegalModal.on('click', events.closeModal);
      dom.closeAsociateCardModal.on('click', events.closeModal);
      dom.modalOutside.on('click', events.closeClickOutside);
      dom.btnRecovery.on('click', events.closeRecoveryModal);
      dom.btnChangePass.on('click', events.closeNewPassModal);
      dom.closeErrorMessage.on('click', events.closeErrorMessage);
      dom.watchLegal.on('click', events.openModal);
      dom.offersLogin.on('click', events.openMessage);
      dom.menuIcon.on('click', events.openMenu);
    };
    events = {
      openMenu: function(){
        if($('#menuMovil').hasClass('ui-active')){
          $('#menuMovil').removeClass('ui-active');
          $('header').removeClass('menu_active');
          dom.menuIcon.children('i').removeClass('icon-close');
          dom.menuIcon.children('i').addClass('icon-menu');
          
        }
        else{
          $('#menuMovil').addClass('ui-active');
          $('header').addClass('menu_active');
          dom.menuIcon.children('i').removeClass('icon-menu');
          dom.menuIcon.children('i').addClass('icon-close');
        }
      },
      openMessage : function(){
        $('.success_message').show();
        setTimeout(function(){
          $('.success_message').hide();
        } , 5000);
      },
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
        
        if ($("#email_recuperar").parsley().isValid()) {
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
        }
        else{
          $("#email_recuperar").parsley().validate();
        }
        
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
      $('body').on('click', st.watchMore, events.watchMore);
      //dom.activeTooltipBonus.hover(events.showTooltipBonus, events.hideTooltipBonus);
      $('body').on('mouseenter', st.activeTooltipBonus, events.showTooltipBonus);
      $('body').on('mouseleave', st.activeTooltipBonus, events.hideTooltipBonus);
      $('body').on('click', st.editCardName, events.editCardName);
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
          //$(this).parent().parent().parent().css('-webkit-transform','rotateY(0deg)');
          $(this).parent().parent().parent().addClass('gira_atras');
          $(this).parent().parent().parent().removeClass('gira_adelante');
        } else {
          //$(this).parent().parent().parent().css('-webkit-transform','rotateY(180deg)');
          $(this).parent().parent().parent().addClass('gira_adelante');
          $(this).parent().parent().parent().removeClass('gira_atras');
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
        
        if ($(this).hasClass('active')) {
          var nombre = $(this).parent().children('.input_name').val();
          if(nombre != ''){
            var duplicate_box, sufix;
            duplicate_box = $(this).parent().parent().parent().parent().children('.duplicate_box');
            
            //alert(duplicate_box.children('p').text())
            duplicate_box.children('p').children('strong').text('"' + nombre + '" ');
            //alert(duplicate_box.html())
            sufix = $(this).data('sufix');

            $(this).parent().children(st.nameCard).text($(this).parent().children(st.inputCardName).val());
            $(this).removeClass('active');
            $(this).parent().children(st.nameCard).show();
            $(this).parent().children(st.inputCardName).hide();
            $('#edit_nombre_' + sufix).val($.trim($('#org_nombre_'+sufix).html()));
            
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
          }
          else{
            $(this).removeClass('active');
            $(this).parent().children(st.nameCard).show();
            $(this).parent().children(st.inputCardName).hide();
          }
          
        } else {
            $(this).parent().children(st.inputCardName).val($(this).parent().children(st.nameCard).text());
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
      menuAccountMobile: '.user_option_mobile ul li .menu_options',
      topPage : 'footer .top'
    };
    catchDom = function() {
      dom.userAccount = $(st.userAccount);
      dom.menuOptions = $(st.menuOptions);
      dom.userAccountMobile = $(st.userAccountMobile);
      dom.menuAccountMobile = $(st.menuAccountMobile);
      dom.topPage = $(st.topPage);
    };
    suscribeEvents = function() {
      dom.userAccount.on('click', events.openLogoutOption);
      dom.userAccountMobile.on('click', events.openMenu);
      dom.topPage.on('click', events.moveTop);
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
      },
      moveTop: function(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
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
      equalAddress: '.equal_address',
      rucInput : '#ruc',
      btnPagar : '#btnPagar',
      formPago : '#formPago'
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
      dom.rucInput = $(st.rucInput);
      dom.btnPagar = $(st.btnPagar);
      dom.formPago = $(st.formPago);
    };
    suscribeEvents = function() {
      dom.optionBoleta.on('change', events.watchOpenBoletaForm);
      dom.optionFactura.on('change', events.watchOpenFacturaForm);
      dom.watchDetail.on('click', events.watchDetail);
      dom.hiddenDetail.on('click', events.hiddenDetail);
      dom.cardOption.on('click', events.changeCard);
      dom.equalAddress.on('change', events.copy);
      dom.rucInput.on( 'keydown' , events.ingresarRuc);
      dom.rucInput.on( 'keyup' , events.salirRuc);
      dom.btnPagar.on('click', events.pagar);

    };
    events = {
      pagar: function(e) {
        if(dom.formPago.parsley().isValid()){
          e.preventDefault();
          if(!dom.btnPagar.hasClass('btn_disabled')){
            dom.btnPagar.addClass('btn_disabled');
            $.ajax({
              type: "POST",
              url: baseUrl + 'carrito/pagar',
              data: $('#formPago').serialize(),
              dataType: 'json',
              success: function(response) {
                $('#token_csrf').val(response.token);
                if (response.success) {
                    dom.btnPagar.removeClass('btn_disabled');
                    $('.error_message').hide();
                    window.location.href = response.data.redirect;
                } else {
                  dom.btnPagar.removeClass('btn_disabled');
                  $('#messageError').html(response.message);
                  $('.error_message').show();
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  $('#messageError').html('Lo sentimos, no se pudo completar el proceso, por favor inténtalo más tarde');
                  $('.error_message').show();
              }
            });
          }
        }
        
      },
      watchOpenBoletaForm: function(e) {
        dom.contentBoleta.show();
        dom.contentFactura.hide();
        dom.formPago.parsley().destroy();
        dom.formPago.parsley({
          excluded: '.content_factura input'
        });
      },
      watchOpenFacturaForm: function(e) {
        dom.contentBoleta.hide();
        dom.contentFactura.show();
        dom.formPago.parsley().destroy();
        dom.formPago.parsley({
          excluded: '.content_boleta input'
        });
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
        if ($(this).hasClass('pagoefectivo1')) {
          $(this).addClass('active');
          $('.pagoefectivo2').removeClass('active');
          $('.visa').removeClass('active');
          dom.peOption.prop('checked', true);
          dom.visaOption.prop('checked', false);
        }
        if ($(this).hasClass('pagoefectivo2')) {
          $(this).addClass('active');
          $('.pagoefectivo1').removeClass('active');
          $('.visa').removeClass('active');
          dom.peOption.prop('checked', true);
          dom.visaOption.prop('checked', false);
        }
        if ($(this).hasClass('visa')) {
          $(this).addClass('active');
          $('.pagoefectivo1').removeClass('active');
          $('.pagoefectivo2').removeClass('active');
          dom.visaOption.prop('checked', true);
          dom.peOption.prop('checked', false);
        }
      },
      copy: function() {
        $('.factura_address').val($('.fiscal_address').val());
      },
      ingresarRuc: function(e) {
        if ($(this).val().length >= 11) { 
          $(this).val($(this).val().substr(0, 11));
        }
      },
      salirRuc: function(e){
        if ($(this).val().length >= 11) { 
                $(this).val($(this).val().substr(0, 11));
            }
      },
    };
    functions = {
      initial: function() {
        console.log("aaaaaaaa");
        dom.formPago.parsley({
          excluded: '.content_factura input'
        });
      }
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
      functions.initial();
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
      removeItem: '.remove_icon',
      changeCant: '.change_cant',
      changeCard: '.change_card'
    };
    catchDom = function() {
      dom.cartPageHeight = $(st.cartPageHeight);
      dom.leftColHeight = $(st.leftColHeight);
      dom.removeItem = $(st.removeItem);
      dom.changeCant = $(st.changeCant);
      dom.changeCard = $(st.changeCard);
    };
    suscribeEvents = function() {
      dom.removeItem.on('click', events.removeItem);
      dom.changeCant.on('change', events.changeCant);
      dom.changeCard.on('change', events.changeCard);
    };
    events = {
      removeItem: function(e) {
        var prefix = $(this).parent().data('prefix');
        $.ajax({
            type: "POST",
            url: baseUrl+'carrito/eliminar',
            data:{id:$('#id_'+prefix).val(), tarjeta:$('#tarjeta_'+prefix).val()},
            dataType: 'json',
            async:false,
            success: function(data){
                if (data.success) {
                    location.reload();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
      },
      changeCant: function(e) {
        var prefix = $(this).parent().parent().data('prefix');
        $.ajax({
            type: "POST",
            url: baseUrl+'carrito/modificar',
            data:{id:$('#id_'+prefix).val(), cantidad:$('#cantidad_'+prefix).val(), tarjeta:$('#tarjeta_'+prefix).val()},
            dataType: 'json',
            async:false,
            success: function(data){
                if (data.success) {
                    location.reload();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
      },
      changeCard: function(e) {
        var prefix = $(this).parent().parent().parent().data('prefix');
        var oldTarjeta = $('#tarjeta_'+prefix).data('pre');
        var newTarjeta = $('#tarjeta_'+prefix).val();
        $('#tarjeta_'+prefix).data('pre', newTarjeta);

        $.ajax({
            type: "POST",
            url: baseUrl+'carrito/modificar',
            data:{id:$('#id_'+prefix).val(), cantidad:$('#cantidad_'+prefix).val(), tarjeta:newTarjeta, old_tarjeta:oldTarjeta},
            dataType: 'json',
            async:false,
            success: function(data){
                if (data.success) {
                    location.reload();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
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
      $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if(scroll > 200){
          $('.right_options').addClass('moveTop');
        }
        else{
          $('.right_options').removeClass('moveTop');
        }
        // Do something
      });
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
  recargas = function() {
    var catchDom, dom, events, functions, initialize, st, suscribeEvents;
    dom = {};
    st = {
      openDetail: '.offers .col_3 .box_white .breadcrumb span',
      watchDetailBar : '.icon_arrow'
    };
    catchDom = function() {
      dom.openDetail = $(st.openDetail);
      dom.watchDetailBar = $(st.watchDetailBar);
    };
    suscribeEvents = function() {
      dom.openDetail.on('click', events.openDetail);
      dom.watchDetailBar.on('click', events.watchDetailBar);
      $(window).scroll(function() {
         if($(window).scrollTop() + $(window).height() > $(document).height()-100) {
             $('.fixed_bottom_bar').css('position', 'static');
         }
         else{
            $('.fixed_bottom_bar').css('position', 'fixed');
         }
      });
      
    };
    events = {
      openDetail: function(e) {
        if ($(this).hasClass('active')) {
          $(this).removeClass('active');
          $(this).parent().parent().children('.detail').hide();
          $(this).parent().parent().parent().removeClass('auto');
        } else {
          $(this).addClass('active');
          $(this).parent().parent().children('.detail').show();
          $(this).parent().parent().parent().addClass('auto');
        }
      },
      watchDetailBar : function(){
        if(dom.watchDetailBar.hasClass('active')){
          dom.watchDetailBar.removeClass('active');
          $('.bottom_bar .hide').hide();
        }
        else{
          dom.watchDetailBar.addClass('active');
          $('.bottom_bar .hide').css('display', 'block');
        }
      }
    };
    functions = {
      ancla: function() {
        
        if(location.hash == '#recarga'){
          console.log('recarga');
          //$(document).animate({ scrollTop: $('.recarga_title').offset().top }, 1000);
          $(document).scrollTop( $("#recarga_title").offset().top - 50 ); 
        }
        else if(location.hash == '#promocion'){
          console.log('promocion');
          //$(document).animate({ scrollTop: $('.promocion_title').offset().top }, 1000);
          $(document).scrollTop( $("#promocion_title").offset().top - 160 ); 
        }
      }
    };
    initialize = function() {
      catchDom();
      suscribeEvents();
      functions.ancla();
    };
    return {
      init: initialize
    };
  };
  mis_datos().init();
  user_account().init();
  open_tooltip().init();
  modal_login().init();
  pagos().init();
  carrito().init();
  recargas().init();
});
