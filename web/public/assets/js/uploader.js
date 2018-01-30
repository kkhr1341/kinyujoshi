;(function($) {
    $.fn.uploader = function(url, options) {
        var Uploader, defaults;
        defaults = {
            before: new Function(),
            success: new Function(),
            error: new Function()
        };
        var params = $.extend(defaults, options);
        Uploader = function() {};
        Uploader.select = function() {
            var $file, d;
            d = new $.Deferred;
            $file = $('<input>', {
                type: 'file'
            });
            $file.on('change', function() {
                var fileData;
                fileData = $(this)[0].files[0];
                $file.off('change');
                d.resolve(fileData);
            });
            $file.trigger('click');
            return d.promise();
        };
        // Uploader.resizeImage = function(file, options) {
        //     var d, params;
        //     d = new $.Deferred;
        //     params = $.extend(defaults, options, {
        //         callback: function(data) {
        //             var f;
        //             f = $.canvasResize('dataURLtoBlob', data);
        //             d.resolve(f);
        //         }
        //     });
        //     $.canvasResize(file, params);
        //     return d.promise();
        // };
        Uploader.upload = function(apiUrl, name, data) {
            var d, formData;
            d = new $.Deferred;
            formData = new FormData;
            formData.append(name, data, "image.jpg");
            $.ajax({
                type: 'POST',
                url: apiUrl,
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false
            }).done(function(response) {
                d.resolve(response);
            }).fail(function(xhr) {
                d.reject(xhr);
            });
            return d.promise();
        };
        this.click(function(e) {
            e.preventDefault();
            Uploader.select()
                .then(function(data) {
                    params.before();
                    return Uploader.upload(url, 'file', data)
                })
                .then(function(response) {
                    params.success(response);
                })
                .fail(function(error) {
                    params.error(error);
                })
        })
    };
})(jQuery);

