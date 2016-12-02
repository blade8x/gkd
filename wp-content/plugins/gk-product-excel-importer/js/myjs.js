(function( $ ) {
	//alert(url.plugin_url);

    $("#file").change(function () {
        var fileExtension = ['xls', 'xlsx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only format allowed: "+fileExtension.join(', '));	
			$('#upload').attr('disabled','disabled');
        }else $('#upload').removeAttr('disabled');
    });
		
	$("#woo_importer").on("submit", function (e) {		
		e.preventDefault();	
				var data = new FormData();
				$.each($('#file')[0].files, function(i, file) {
					data.append('file', file);
					
				});	
				data.append('_wpnonce',$("#_wpnonce").val());
								
				$.ajax({
					url: $(this).attr('action'),
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					beforeSend: function() {
						$('#woo_importer').append("<img src='"+url.plugin_url+"/images/loader.gif' />");
					},					
					success: function(data){
						$('body').html(data);
						$("#woo_importer").fadeOut();						
					}
				});			
			});	
			//drag and drop
			$('.draggable').draggable({cancel:false});
			$( ".droppable" ).droppable({
			  drop: function( event, ui ) {
				$( this ).addClass( "ui-state-highlight" ).val( $( ".ui-draggable-dragging" ).val() );
				$( this ).attr('value',$( ".ui-draggable-dragging" ).attr('key'));
				// alert($(this).attr('key'));
			  }
			 
			});	
		
		
			$("#woo_process").submit(function(e) {
				e.preventDefault();
				if($("input[name='post_title']").val() !='' ){
					$.ajax({
						url: window.location.href,
						data:  $(this).serialize(),
						type: 'POST',
						beforeSend: function() {	
							$(window).scrollTop(0);
							$('#woo_process').append("<img src='"+url.plugin_url+"/images/loader.gif' />");
						},						
						success: function(data){
							$('body').html(data);
						}
					});
				}else alert('Title Selection is Mandatory.');
	
			});	
		
			
})( jQuery );