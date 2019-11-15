	var subdomain = '';
	var widgetId = '';
	var metaUrl = '/admin/api/2019-10/metafields.json';
	$.getJSON(metaUrl, function(data) {
		$.each(data, function(index, value){
			$.each(value, function() {
				  if(this.key == 'subdomain') {
					subdomain = this.value;
				  }
				  if(this.key == 'widgetId') {
					widgetId = this.value;
				  }
			});
		});
		
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = 'https://' + subdomain +'.ngdesk.com/widgets/chat/' + widgetId + '/chat_widget.js';
		document.getElementsByTagName("head")[0].appendChild(script);		  
	});
	

