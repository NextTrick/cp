$ ->
	modal_login = () ->
		dom = {}
		st =
			btn : 'a[name=modal]'
			btnClose : '.modal_box .close'
			modalOutside : '#mask'
			btnRecovery : '#btn_recovery'
			btnChangePass : '#btn_change_password'
			errorMessage : '.error_message'
			closeErrorMessage : '.error_message .icon'
			watchLegal : '.watch_legal'

		catchDom = ->
			dom.btn = $(st.btn)
			dom.btnClose = $(st.btnClose)
			dom.modalOutside = $(st.modalOutside)
			dom.btnRecovery = $(st.btnRecovery)
			dom.btnChangePass = $(st.btnChangePass)
			dom.errorMessage = $(st.errorMessage)
			dom.closeErrorMessage = $(st.closeErrorMessage)
			dom.watchLegal = $(st.watchLegal)
			return
		suscribeEvents = () ->
			dom.btn.on 'click', events.openModal
			dom.btnClose.on 'click', events.closeModal
			dom.modalOutside.on 'click', events.closeClickOutside
			dom.btnRecovery.on 'click', events.closeRecoveryModal
			dom.btnChangePass.on 'click', events.closeNewPassModal
			dom.closeErrorMessage.on 'click', events.closeErrorMessage
			dom.watchLegal.on 'click', events.openModal
			return
		events =
			openModal : (e) ->
				e.preventDefault()
				#Get the A tag 
				id = $(this).attr('href') 
				functions.openModalById(id)
				return
			closeModal : (e) ->
				#Cancel the link behavior  
				e.preventDefault()
				$('#mask, .window').hide()
				$('.modal_box').hide()
				return
			closeClickOutside : () ->
				$(this).hide()
				$('.modal_box').hide()
				return
			closeRecoveryModal : () ->
				$.ajax
					type : "POST"
					url : baseUrl + 'recuperar-password'
					data : 
						email : $('#email_recuperar').val() 
						token : $('#token_csrf').val()
					dataType : 'json'
					success : (data) ->
						$('#token_csrf').val(data.token)
						if data.success
							#$('#error_recuperar_password').html('')
							functions.openModalById('#modal_recovery_response')
							$('#modal_recovery_password').hide()
						else
							$('#error_recuperar_password').html(data.message)
						return
					error: (XMLHttpRequest, textStatus, errorThrown) ->
						return
				return
				#$('#modal_recovery_password').hide()
			closeNewPassModal : () ->
				$('#modal_new_password').hide()
				functions.openModalById('#modal_new_password_response')
				return
			closeErrorMessage : () ->
				dom.errorMessage.addClass 'hide'
				return
		functions = 
			openModalById: (id)->
				#Get the screen height and width  
				maskHeight = $(document).height()
				maskWidth = $(window).width()

				#Set height and width to mask to fill up the whole screen  
				$('#mask').css
					'width'  : maskWidth
					'height' : maskHeight
				
				$('body').animate { scrollTop: 0 }, '500'
				#transition effect      
				$('#mask').fadeIn(500)
				$('#mask').fadeTo("slow",0.9)
				
				#Get the window height and width  
				winH = $(window).height()
				winW = $(window).width()
				       
				#Set the popup window to center  
				$(id).css('top',  20)
				$(id).css('left', winW/2-$(id).width()/2)
				
				#transition effect  
				$(id).fadeIn(1000)
				return
			openModalNewPassword : () ->
				if $('#modal_new_password').data('open') == 1
					functions.openModalById('#modal_new_password')
				return
			openModalSigninResponse : () ->
				if $('#modal_response_signin').data('open') == 1
					functions.openModalById('#modal_response_signin')
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			functions.openModalNewPassword()
			functions.openModalSigninResponse()
			return

		return init: initialize 


	open_tooltip = () ->
		dom = {}
		st =
			addCard : '.add_card'
			tooltip : '.tooltip'
			boxTooltip : '.show_tooltip'
			contentAsociate : '.content_asociate_card'
			btnCancel : '.btn_cancel'
			loading : '.loading'
			btnAsociateCard : '.btn_asociate_card'
			asociateForm : '.asociate_form'
			success : '.success_box'
			error : '.error_box'
			duplicate : '.duplicate_box'
			watchMore : '.watch_more'
			topCardContent : '.top_card'
			showMoreContent : '.show_more_content'
			tooltipBonus :  '.tooltip_bonus'
			activeTooltipBonus : '.show_more_content .line .left span'
			editCardName : '.card_title .edit_icon'
			nameCard : '.card_title .text'
			inputCardName : '.card_title .input_name'

		catchDom = ->
			dom.addCard = $(st.addCard)
			dom.tooltip = $(st.tooltip)
			dom.boxTooltip = $(st.boxTooltip)
			dom.contentAsociate = $(st.contentAsociate)
			dom.btnCancel = $(st.btnCancel)
			dom.loading = $(st.loading)
			dom.btnAsociateCard = $(st.btnAsociateCard)
			dom.asociateForm = $(st.asociateForm)
			dom.success = $(st.success)
			dom.error = $(st.error)
			dom.watchMore = $(st.watchMore)
			dom.tooltipBonus = $(st.tooltipBonus)
			dom.activeTooltipBonus = $(st.activeTooltipBonus)
			dom.editCardName = $(st.editCardName)
			dom.nameCard = $(st.nameCard)
			dom.inputCardName = $(st.inputCardName)

			return
		suscribeEvents = () ->
			dom.addCard.hover events.openTooltip, events.closeTooltip
			dom.addCard.on 'click', events.showAsociateCard
			dom.btnCancel.on 'click', events.hideAsociateCard
			dom.btnAsociateCard.on 'click', events.asociateCard
			dom.watchMore.on 'click', events.watchMore
			dom.activeTooltipBonus.hover events.showTooltipBonus, events.hideTooltipBonus
			dom.editCardName.on 'click', events.editCardName
			return
		events =
			openTooltip : () ->
				dom.tooltip.show()
				return
			closeTooltip : () ->
				dom.tooltip.hide()
				return
			showAsociateCard : () ->
				dom.boxTooltip.hide()
				dom.contentAsociate.show()
				return
			hideAsociateCard : (e) ->
				e.stopPropagation()
				dom.boxTooltip.show()
				dom.contentAsociate.hide()
				return
			asociateCard : (e) ->
				e.preventDefault()
				duplicate_box = $(this).parent().parent().children('.duplicate_box')
				if dom.asociateForm.parsley().isValid()
					dom.contentAsociate.hide()
					dom.loading.show()
					$.ajax
						type : "POST"
						url : $('#form_asociar_nueva_tarjeta').attr('action')
						data : $('#form_asociar_nueva_tarjeta').serialize()
						dataType : 'json'
						success : (data) ->
							if data.success == false && data.type == 'existe_nombre'
								alert 'el nombre ya esta en uso'
								duplicate_box.show()
								dom.contentAsociate.hide()
							else 
								if data.success
									functions.successAsociate()
								else
									functions.errorAsociate()
							return
						error: (XMLHttpRequest, textStatus, errorThrown) ->
							functions.errorAsociate()
							return
					###setTimeout ->
						# Active success response
						functions.successAsociate()
						# Active error response
						#functions.errorAsociate()
					, 2000
					# agregar un settimeout para que se oculte el success u error
					# luego de eso recargar
					return false ###
				else
					dom.asociateForm.parsley().validate()
				return
			watchMore : () ->
				if $(this).hasClass 'active'
					$(this).parent().parent().children(st.topCardContent).show()
					$(this).parent().parent().children(st.showMoreContent).hide()
					$(this).text 'Ver más'
					$(this).removeClass 'active'
				else
					$(this).parent().parent().children(st.topCardContent).hide()
					$(this).parent().parent().children(st.showMoreContent).show()
					$(this).text 'Ver menos'
					$(this).addClass 'active'
				return
			showTooltipBonus : () ->
				$(this).addClass 'active'
				$(this).parent().parent().children(st.tooltipBonus).show()
				return
			hideTooltipBonus : () ->
				$(this).removeClass 'active'
				$(this).parent().parent().children(st.tooltipBonus).hide()
				return
			editCardName : () ->
				duplicate_box = $(this).parent().parent().parent().children('.duplicate_box')
				if $(this).hasClass 'active'
					$(this).parent().children(st.nameCard).text $(this).parent().children(st.inputCardName).val()
					$(this).removeClass 'active'
					$(this).parent().children(st.nameCard).show()
					$(this).parent().children(st.inputCardName).hide()
					sufix = $(this).data('sufix');
					$.ajax
						type: "POST"
						url: baseUrl+'mis-tarjetas/editar-nombre'
						data: 
							nombre: $('#edit_nombre_'+sufix).val() 
							numero: $('#edit_numero_'+sufix).val()
						dataType: 'json'
						success : (data) ->
							if data.success
								# si el nombre no es el mismo
							else
								duplicate_box.show()
							return
						error : (XMLHttpRequest, textStatus, errorThrown) ->
							return
				else
					$(this).addClass 'active'
					$(this).parent().children(st.nameCard).hide()
					$(this).parent().children(st.inputCardName).show()
				return
		functions = 
			successAsociate: ->
				dom.contentAsociate.hide()
				dom.loading.hide()
				dom.success.show()
				return
			errorAsociate: ->
				dom.contentAsociate.hide()
				dom.loading.hide()
				dom.error.show()
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			return

		return init: initialize 

	user_account = () ->
		dom = {}
		st =
			userAccount : '.user_account'
			logout : '.logout'

		catchDom = ->
			dom.userAccount = $(st.userAccount)
			dom.logout = $(st.logout)
			return
		suscribeEvents = () ->
			dom.userAccount.on 'click', events.openLogoutOption
			return
		events =
			openLogoutOption : (e) ->
				e.preventDefault()
				if dom.logout.hasClass 'active'
					dom.logout.removeClass 'active'
				else
					dom.logout.addClass 'active'
				return
		functions = 
			successAsociate: ->
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			return

		return init: initialize 

	recargas = () ->
		dom = {}
		st =
			less : '.cant_box .less'
			more : '.cant_box .more'

		catchDom = ->
			dom.less = $(st.less)
			dom.more = $(st.more)
			return
		suscribeEvents = () ->
			dom.less.on 'click', events.substract
			dom.more.on 'click', events.add
			return
		events =
			substract : (e) ->
				actual = $(this).next('input')
				if actual.val() > 0
					actual.val(parseInt(actual.val())-1)
				return
			add : (e) ->
				actual = $(this).prev('input')
				actual.val(parseInt(actual.val())+1)
				return
		functions = 
			example: ->
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			return

		return init: initialize 

	pagos = () ->
		dom = {}
		st =
			optionBoleta : '.voucher .boleta'
			optionFactura : '.voucher .factura'
			contentBoleta : '.content_boleta'
			contentFactura : '.content_factura'
			watchDetail : '.watch_detail'
			hiddenDetail : '.hidden_detail'
			itemDetail : '.item .detail'
			cardOption : '.card'
			peOption: '.cards_option .pe'
			visaOption: '.cards_option .visa'

		catchDom = ->
			dom.optionBoleta = $(st.optionBoleta)
			dom.optionFactura = $(st.optionFactura)
			dom.contentBoleta = $(st.contentBoleta)
			dom.contentFactura = $(st.contentFactura)
			dom.watchDetail = $(st.watchDetail)
			dom.hiddenDetail = $(st.hiddenDetail)
			dom.itemDetail = $(st.itemDetail)
			dom.cardOption = $(st.cardOption)
			dom.peOption = $(st.peOption)
			dom.visaOption = $(st.visaOption)
			return
		suscribeEvents = () ->
			dom.optionBoleta.on 'change', events.watchOpenBoletaForm
			dom.optionFactura.on 'change', events.watchOpenFacturaForm
			dom.watchDetail.on 'click', events.watchDetail
			dom.hiddenDetail.on 'click', events.hiddenDetail
			dom.cardOption.on 'click', events.changeCard
			return
		events =
			watchOpenBoletaForm : (e) ->
				dom.contentBoleta.show()
				dom.contentFactura.hide()
				return
			watchOpenFacturaForm : (e) ->
				dom.contentBoleta.hide()
				dom.contentFactura.show()
				return
			watchDetail : ->
				$(this).hide()
				dom.itemDetail.show()
				dom.hiddenDetail.show()
				return
			hiddenDetail : ->
				$(this).hide()
				dom.itemDetail.hide()
				dom.watchDetail.show()
				return
			changeCard : ->
				if $(this).hasClass 'pagoefectivo'
					$(this).addClass 'active'
					$(this).next().removeClass 'active'
					dom.peOption.prop 'checked', true
					dom.visaOption.prop 'checked', false
				if $(this).hasClass 'visa'
					$(this).addClass 'active'
					$(this).prev().removeClass 'active'
					dom.visaOption.prop 'checked', true
					dom.peOption.prop 'checked', false
				return
		functions = 
			example: ->
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			return

		return init: initialize 
	carrito = () ->
		dom = {}
		st =
			cartPageHeight : '.cart_page'
			leftColHeight : '.cart_page > .right'
			removeItem : '.remove_icon'
		catchDom = ->
			dom.cartPageHeight = $(st.cartPageHeight)
			dom.leftColHeight = $(st.leftColHeight)
			dom.removeItem = $(st.removeItem)
			return
		suscribeEvents = () ->
			dom.removeItem.on 'click', events.removeItem
			return
		events =
			removeItem : (e) ->
				$(this).parent().parent().remove()
				return
			
		functions = 
			height : ->
				dom.leftColHeight.height dom.cartPageHeight.height()
				return

		initialize = ->
			catchDom()
			suscribeEvents()
			functions.height()
			return

		return init: initialize 

	carrito().init()
	pagos().init()
	recargas().init()
	user_account().init()
	open_tooltip().init()
	modal_login().init()
	return
