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

		catchDom = ->
			dom.btn = $(st.btn)
			dom.btnClose = $(st.btnClose)
			dom.modalOutside = $(st.modalOutside)
			dom.btnRecovery = $(st.btnRecovery)
			dom.btnChangePass = $(st.btnChangePass)
			dom.errorMessage = $(st.errorMessage)
			dom.closeErrorMessage = $(st.closeErrorMessage)
			return
		suscribeEvents = () ->
			dom.btn.on 'click', events.openModal
			dom.btnClose.on 'click', events.closeModal
			dom.modalOutside.on 'click', events.closeClickOutside
			dom.btnRecovery.on 'click', events.closeRecoveryModal
			dom.btnChangePass.on 'click', events.closeNewPassModal
			dom.closeErrorMessage.on 'click', events.closeErrorMessage
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

	modal_login().init()
	return
