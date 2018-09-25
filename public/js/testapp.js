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

function deleteMember(id) {
    jQuery.ajax({
        type: "DELETE",
        datatype: "json",
        url: "http://testapp.com/members/" + id,
        success: function(member) {
            jQuery('h5.modal-title').text("Delete Member");
            jQuery('.modal-body').html(member.message);
            jQuery('#MemberModal').modal('show');
            jQuery('table.members tbody tr#' + id).remove();
        }
    })
}
