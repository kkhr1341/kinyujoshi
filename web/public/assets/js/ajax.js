new function () {
	ajax = {
		post: function(url, data, callback, show_ld) {
			if (typeof ld == 'undefined' && (typeof show_ld == 'undefined' || show_ld)) {
				var loader_overlay = loader.show('body');
			}
			var excallback = function(data) {
				if (data.api_status == "error") {
					loader.hide(loader_overlay);
					ts.error(data.message);
				}
				else if (data.data == "login") {
					location.href = "/login";
				}
				else {
					loader.hide(loader_overlay);
					callback(data);
				}
			};
			var jqxhr = $.ajax({
				type:"post",
				url:url,
				data:data,
				timeout:120000,
				dataType: "json",
				success:excallback
			});
			return jqxhr;
		}
	};
	
	ts = {
		info : function(message, callback, title) {
			toastr.options.positionClass = 'toast-top-full-width';
			toastr.options.fadeOut = 250;
			toastr.options.fadeIn = 250;
			toastr.options.timeOut = 1500;
			toastr.options.onHidden = callback;
			toastr.info(message, title);
		},

		success : function(message, callback, title) {
			toastr.options.positionClass = 'toast-top-full-width';
			toastr.options.fadeOut = 250;
			toastr.options.fadeIn = 250;
			toastr.options.timeOut = 1500;
			toastr.options.onHidden = callback;
			toastr.success(message, title);
		},

		warning : function(message, callback, title) {
			toastr.options.positionClass = 'toast-top-full-width';
			toastr.options.fadeOut = 250;
			toastr.options.fadeIn = 250;
			toastr.options.timeOut = 1500;
			toastr.options.onHidden = callback;
			toastr.warning(message, title);
		},

		error : function(message, callback, title) {
			toastr.options.positionClass = 'toast-top-full-width';
			toastr.options.fadeOut = 250;
			toastr.options.fadeIn = 250;
			toastr.options.timeOut = 1500;
			toastr.options.onHidden = callback;
			toastr.error(message, title);
		}
	};
}