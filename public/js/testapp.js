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
            url: baseUrl + "/projects",
            beforeSend: function() {
                jQuery('.nav a.projects').append(loading);
            },
            success: function(projects) {
                jQuery('.nav a.projects span.loading').remove();
                jQuery('table.projects tbody').html(projects.html);
            }
        });
    });

    jQuery('#Modal').on('hidden.bs.modal', function(){
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

function confirmDeleteMember(id) {
    jQuery('#delete-button').removeClass('d-none');
    jQuery('h5.modal-title').text("Delete Member");
    jQuery('.modal-body').text('Do you want to delete this member?');
    jQuery('#Modal').modal('show');
    jQuery('#delete-button').attr('data-id',id);
}

function deleteMember() {
    id = jQuery('#delete-button').attr('data-id');
    jQuery('#delete-button').addClass('d-none');
    jQuery.ajax({
        type: "DELETE",
        datatype: "json",
        url: baseUrl + "/members/" + id,
        success: function(member) {
            jQuery('h5.modal-title').text("Delete Member");
            jQuery('.modal-body').html(member.message);
            jQuery('#Modal').modal('show');
            jQuery('table.members tbody tr#' + id).remove();
        }
    })
}

function createMember() {
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/members/create",
        success: function(member) {
            jQuery('.modal-body').html(member.html);
            jQuery('#Modal').modal('show');
        }
    })
}

function createMemberPost() {
    jQuery('#create-member small.has-error').text('');
    name = jQuery('#create-member input[name=name]').val();
    information = jQuery('#create-member textarea[name=information]').val();
    phone = jQuery('#create-member input[name=phone]').val();
    dob = jQuery('#create-member input[name=dob]').val();
    position = jQuery('#create-member select[name=position]').val();
    gender = jQuery('#create-member select[name=gender]').val();
    var avatar =jQuery('#create-member input[name=avatar]')[0].files[0];
    form = new FormData();
    form.append('name', name);
    form.append('information', information);
    form.append('phone', phone);
    form.append('dob', dob);
    form.append('position', position);
    form.append('gender', gender);
    form.append('avatar', avatar);
    jQuery.ajax({
        url: baseUrl + "/members",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (member) {
            jQuery('h5.modal-title').text("Create Member");
            jQuery('.modal-body').html("Create success");
            jQuery('table.members tbody').append(member.html);
        },
        error: function (result) {
            errors = result.responseJSON.errors;
            jQuery.each(errors, function(index, value) {
                jQuery('#create-member small#' + index + 'Error').text(value);
            })
        }
    })
}

function detailProject(id) {
    jQuery('h5.modal-title').text('Project Detail');
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/projects/" + id,
        success: function(project) {
            jQuery('.modal-body').html(project.html);
        }
    })
}

function editProject(id) {
    jQuery('h5.modal-title').text("Update Project Detail");
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/projects/" + id + "/edit",
        success: function(project) {
            jQuery('.modal-body').html(project.html);
            type = jQuery('.modal-body #update-project #type').attr('value');
            jQuery('.modal-body #update-project #type').val(type);
            status = jQuery('.modal-body #update-project #status').attr('value');
            jQuery('.modal-body #update-project #status').val(status);
        }
    })
}

function updateProject(id) {
    id = jQuery('#update-project').attr('data-id');
    jQuery.ajax({
        type: 'POST',
        datatype: 'json',
        url: baseUrl + "/projects/" + id,
        data: jQuery('#update-project').serialize(),
        success: function(project) {
            jQuery('h5.modal-title').text("Update Project");
            jQuery('.modal-body').html("Update success");
            jQuery('table.projects tbody tr#' + id).html(project.html);
        }
    })
}

function createProject() {
    jQuery.ajax({
        type: "GET",
        datatype: "json",
        url: baseUrl + "/projects/create",
        success: function(project) {
            jQuery('.modal-body').html(project.html);
            jQuery('#Modal').modal('show');
        }
    })
}

function createProjectPost() {
    jQuery.ajax({
        type: 'POST',
        datatype: 'json',
        url: baseUrl + "/projects",
        data: jQuery('#create-project').serialize(),
        success: function(project) {
            jQuery('h5.modal-title').text("Create Project");
            jQuery('.modal-body').html("Create success");
            jQuery('table.projects tbody').append(project.html);
        },
        error: function (result) {
            errors = result.responseJSON.errors;
            jQuery.each(errors, function(index, value) {
                jQuery('#create-project small#' + index + 'Error').text(value);
            })
        }
    })
}
