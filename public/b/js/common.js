
var common = {
    ajaxError: 'Error, vuelva a actualizar la página por favor.',
    deleteRemote: function(){
        $('.delete-remote').click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                dataType: 'json',
                success: function(data){
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert(common.ajaxError);
                }
            });
        });
    },
    parseSlugName:function(str) {
        str = str.replace(/^\s+|\s+$/g, '');
        str = str.toLowerCase();
        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to   = "aaaaeeeeiiiioooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
          str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        str = str.replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        return str;
    }
};


