var baseUrl = 'http://' + window.location.host;

jQuery(document).ready(function() {
    var loading = '<span class="loading">&nbsp;<i class="fa fa-spinner fa-spin"></i></span>';
    jQuery('.nav a.members').click(function() {
        jQuery.ajax({
            type: "GET",
            datatype: "json",
            url: baseUrl + "/members",
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

    jQuery('#MemberModal').on('hidden.bs.modal', function(){
        jQuery('.modal-body').html('');
    })
})

function detailMember(id) {
    jQuery('h5.modal-title').text('Member Detail');
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/members/" + id,
        success: function(member) {
            jQuery('.modal-body').html(member.html);
        }
    })
}

function editMember(id) {
    jQuery('h5.modal-title').text("Update Member Detail");
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/members/" + id + "/edit",
        success: function(member) {
            jQuery('.modal-body').html(member.html);
            position = jQuery('.modal-body #update-member #position').attr('value');
            jQuery('.modal-body #update-member #position').val(position);
            gender = jQuery('.modal-body #update-member #gender').attr('value');
            jQuery('.modal-body #update-member #gender').val(gender);
        }
    })
}

function updateMember(id) {
    id = jQuery('#update-member').attr('data-id');
    jQuery.ajax({
        type: 'POST',
        datatype: 'json',
        url: baseUrl + "/members/" + id,
        data: jQuery('#update-member').serialize(),
        success: function(member) {
            jQuery('h5.modal-title').text("Update Member");
            jQuery('.modal-body').html("Update success");
            jQuery('table.members tbody tr#' + id).html(member.html);
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

function createMember() {
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: "http://testapp.com/members/create",
        success: function(member) {
            jQuery('.modal-body').html(member.html);
            jQuery('#MemberModal').modal('show');
        }
    })
}
