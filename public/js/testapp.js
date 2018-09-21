jQuery(document).ready(function() {
    var html = '';
    var loading = '<span class="loading">&nbsp;<i class="fa fa-spinner fa-spin"></i></span>';
    jQuery('.nav a.members').click(function() {
        jQuery.ajax({
            type: "GET",
            datatype: "json",
            url: "http://testapp.com/members",
            beforeSend: function() {
                jQuery('.nav a.members').append(loading);
            },
            success: function(members) {
                jQuery('.nav a.members span.loading').remove();
                jQuery('table.members tbody').html(members.html);
                html = '';
            }
        });
    });
})
