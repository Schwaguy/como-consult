// Como Consult Scripts
(function( $ ) {
	'use strict';
	var $form = $('#virtual-consult');
	
	// If we need mobile adjustments
	/*let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	if (isMobile) {
		$('.formpage.desktop').addClass('noShow');
	} else {
		$('.formpage.mobile').addClass('noShow');
	}*/
	
	$('.modal-trigger a').click(function() {
  		$('#consultModal').modal('show');
		return false;
	});
	
	// Hide Precessing overlaoy by default
	$("#processing").addClass('hide');
	
	// Resize and upload images
	$('.img-upload').on('change', fileUpload);
	function fileUpload(event) { 
		var $imgPreview = $(this).parent('.img-upload-wrap').children('.img-upload-preview');
		var $imgPathField = $(this).parent('.img-upload-wrap').children('.img-path');
		var $currentFormPage = $(this).parents('.formpage');
		var file = event.target.files[0];
		var fieldName = event.target.name;
		var data = new FormData(); 
		if (!file.type.match('image.*')) {              
			alert("Please choose an image file of type PNG or JPG.");
		} else {
			$("#processing").removeClass('hide');
			var maxFileSize = 524288; // 512K
			//var maxFileSize = 262144; // 256K
			ImageTools.resize(file, maxFileSize, function(blob, success, errMessage) {
				if (success) {
					//data.append('file', blob, file.name);
					data.append('file', blob, file.name);
					data.append('fieldName', fieldName);
					var xhr = new XMLHttpRequest();
					var targetScript = '/wp-content/plugins/como-consult/public/inc/imageUpload.php';
					xhr.open('POST', targetScript, true);
					xhr.send(data);
					xhr.onload = function () {
						var response = JSON.parse(xhr.response);
						if(xhr.status === 200 && response.status === 'ok'){
							var fileName = response.fileName;
							var fieldName = response.fieldName;
							var filePath = '/wp-content/uploads/client-consult-photos/'+ fileName;
							$imgPreview.attr('src', filePath);
							$imgPreview.fadeIn(500);
							$imgPathField.val(filePath);
							$("#processing").addClass('hide');
							/*setTimeout(function(){
								var h = $currentFormPage.height();
								$(".modal-body").css('height',h+80+'px');
							},250);*/
						} else {
							$("#processing").addClass('hide');
							alert(errMessage);
						}
					}
				}
			});
		}
	};
	$(document).on('click tap','.img-upload-preview',function() {
		$(this).parent('.img-upload-wrap').children('.img-upload').click();
	});
	
	$('.phone-field').mask('(999) 999-9999');
	var v = $form.validate({
		ignore: ".ignore",
		errorClass: "warning",
		onkeyup: false,
		onfocusout: false,
	});
	
	// By Default, show to first modal page
	$('.modal-body .formpage:first').removeClass('hidden');
	$('#consultModal').on('shown.bs.modal', function () {
		$(this).find('.modal-body').css({
			//width:'auto', //probably not needed
			height:'auto', //probably not needed
			'max-height':'100%'
		});
		$('body').find('.cpcta-flyin').removeClass('slidOut');
		$('body').find('.cpcta-flyin .cpcta-content-panel').css({display:'none'});
		//$('body').removeClass('modal-open');
		//$('.modal-backdrop').removeClass('show');
		/*setTimeout(function(){
			var h=$(".modal-body .formpage:first").height();
			$(".modal-body").css('height',h+80+'px');
			//$(".modal-body .formpage:first").css('height',h+'px');
		},250);*/
	});
	
	// Move to Next page
	function moveNext($this,resize=false) {
		var $thisPage = $this.parents('.formpage');
		var $nextPage = $thisPage.next('.formpage').not('.noShow');
		var nextID = $nextPage.attr('id');
		//console.log('nextID');
		//console.log(nextID);
		//$thisPage.addClass('hide').css('height',0);
		//$thisPage.addClass('hide-left');
			
		//var h=$nextPage.height();
		//$(".modal-body").css('height',h+80+'px');
		//$nextPage.css('height','auto').removeClass('hidden');
		//$nextPage.removeClass('hidden');
		
		$.when($thisPage.addClass('hide-left')).done(function() {
			$('input','#'+ nextID).removeClass('ignore');
			if (resize === true) {
				var h=$nextPage.height();
				$(".modal-body").css('height',h+150+'px');
				$nextPage.css('height','auto').removeClass('hidden');
			} else {
				$nextPage.css('height','auto').removeClass('hidden');
			}
		});
	}
	
	// Validate Current page and move to next
	$('.next-button').on('click', function () {
		if (v.form()) {
			moveNext($(this),false);
		}
	});
	
	// Reset Form
	function resetForm($form,redirect) {
		$form[0].reset();
		if (redirect) {
			$('.modal-body .formpage').not(':first').addClass('hidden');
			$('.modal-body .formpage:first').removeClass('hide-left');
		}
	}
		
	$('#consultModal .reset').on('click', function () {
		var y = confirm('WARNING: This will reset the consult form and you will need to start over.');
		if (y === true) {
			resetForm($form,true);
			$('#consultModal').modal('hide');
		}
	});
	
	$('#consultModal .close-button').on('click', function () {
		resetForm($form,true);
		$('#consultModal').modal('hide');
	});
	
	// Handle Form Submit			
	$("#virtual-consult").submit(function(e) {
		e.preventDefault(); 
		
		$("#processing").removeClass('hide');
		var ajaxUrl = $('#submitURL').val();
		var postData = new FormData(this);
		var currentElement = $("#virtual-consult input[type=submit]");
		
		// Display the key/value pairs (troubleshooting)
		//for (var pair of postData.entries()) {  console.log(pair[0]+ ': '+ pair[1]); }]
		
		$(this).find('input[type=file]').each(function(){
			postData.delete($(this).attr('name'));
		});
		
		//console.log('ajaxUrl: '+ ajaxUrl);
		
		$.ajax({
			type: 'POST',
			url: ajaxUrl,
			data: postData,
			dataType: 'json',
			crossDomain: false,
			async: true,
			cache: false,
			contentType: false,
            processData: false,
			timeout: 10000
		})
		.done(function(data){ 
			if (data.output) {
				if (data.output.response === 'messagesent') {
					$.when($("#processing").addClass('hide')).done(function() {
						moveNext(currentElement,true);
						resetForm($form,false);
					});
				} else {
					$('#feedback').html('<p>'+ data.output.feedback +'</p>');
					setTimeout(function() {
						$("#processing").removeClass('hide');
					}, 3000);
				}
			} else {
				console.log('NO ACCOUNT');
			}
		})
		.fail(function(xhr, status, error) { 
			console.log('ERROR');
			var err = JSON.parse(xhr.responseText);
			console.log(err.Message);
		});
	});
})( jQuery );