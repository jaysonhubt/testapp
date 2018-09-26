jQuery(document).ready(function() {
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
            }
        });
    });

    jQuery('.nav a.projects').click(function() {
        jQuery.ajax({
            type: "GET",
            datatype: "json",
            url: "http://testapp.com/projects",
            beforeSend: function() {
                jQuery('.nav a.projects').append(loading);
            },
            success: function(projects) {
                jQuery('.nav a.projects span.loading').remove();
                jQuery('table.projects tbody').html(projects.html);
            }
        });
    });
})
function detailMember(id) {
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: "http://testapp.com/members/" + id,
        success: function(member) {
            jQuery('.modal-body').html(member.html);
        }
    })
}
