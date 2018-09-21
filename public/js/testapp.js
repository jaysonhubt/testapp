jQuery(document).ready(function() {
    var html = '';
    jQuery('.nav a.members').click(function() {
        jQuery.ajax({
            type: "GET",
            datatype: "json",
            url: "http://testapp.com/members",
            beforeSend: function() {
                jQuery('.nav a.members').append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
            },
            success: function(members) {
                jQuery('.nav a.members span').remove();
                jQuery.each(members, function(index, obj){
                    gender = 'Female';
                    if (obj.gender == '1') {
                        gender = 'Male';
                    }

                    html += '<tr>';
                    html += '<td>' + obj.id + '</td>';
                    html += '<td>' + obj.name + '</td>';
                    html += '<td>' + obj.phone + '</td>';
                    html += '<td>' + obj.dob + '</td>';
                    html += '<td>' + obj.position + '</td>';
                    html += '<td>' + gender + '</td>';
                    html += '<td><button type="button" class="btn btn-primary">Edit</button></td>';
                    html += '<td><button type="button" class="btn btn-danger">Delete</button></td>';
                    html += '</tr>';
                })
                jQuery('table.members tbody').html(html);
                html = '';
            }
        });
    });
})
