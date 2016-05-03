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
			closeModal : (e) ->
				#Cancel the link behavior  
				e.preventDefault()
				$('#mask, .window').hide()
				$('.modal_box').hide()
			closeClickOutside : () ->
				$(this).hide()
				$('.modal_box').hide()
			closeRecoveryModal : () ->
				$('#modal_recovery_password').hide()
			closeNewPassModal : () ->
				$('#modal_new_password').hide()
			closeErrorMessage : () ->
				dom.errorMessage.addClass 'hide'
		functions = 
			validateData: ->

				return

		initialize = ->
			catchDom()
			suscribeEvents()
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
			error: '.error_box'
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
			closeTooltip : () ->
				dom.tooltip.hide()
			showAsociateCard : () ->
				dom.boxTooltip.hide()
				dom.contentAsociate.show()
			hideAsociateCard : (e) ->
				e.stopPropagation()
				dom.boxTooltip.show()
				dom.contentAsociate.hide()
			asociateCard : (e) ->
				e.preventDefault()
				if dom.asociateForm.parsley().isValid()
					dom.contentAsociate.hide()
					dom.loading.show()
					setTimeout ->
						# Active success response
						functions.successAsociate()
						# Active error response
						#functions.errorAsociate()
					, 2000
					# agregar un settimeout para que se oculte el success u error
					# luego de eso recargar
					return false
				else
					dom.asociateForm.parsley().validate()
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
			showTooltipBonus : () ->
				$(this).addClass 'active'
				$(this).parent().parent().children(st.tooltipBonus).show()
			hideTooltipBonus : () ->
				$(this).removeClass 'active'
				$(this).parent().parent().children(st.tooltipBonus).hide()
			editCardName : () ->
				if $(this).hasClass 'active'
					$(this).parent().children(st.nameCard).text $(this).parent().children(st.inputCardName).val()
					$(this).removeClass 'active'
					$(this).parent().children(st.nameCard).show()
					$(this).parent().children(st.inputCardName).hide()
				else
					$(this).addClass 'active'
					$(this).parent().children(st.nameCard).hide()
					$(this).parent().children(st.inputCardName).show()

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


	open_tooltip().init()
	modal_login().init()
	return
