/*Email validation code*/
$("#save,#update").click(function(e) {
    var base_url = $("#base_url").val().trim();
    var flag = true;
    var this_id = this.id;
    var name = document.getElementById("name").value.trim();
    var q_id = document.getElementById("q_id").value.trim();


    var flag = true;

    function check_field(id) {

        if (!$("#" + id).val().trim()) //Also check Others????
        {
            $('#' + id + '_msg').fadeIn(200).show().html('Required Field').addClass('required');
            $('#' + id).css({ 'background-color': '#E8E2E9' });
            flag = false;
        } else {
            $('#' + id + '_msg').fadeOut(200).hide();
            $('#' + id).css({ 'background-color': '#FFFFFF' }); //White color
        }
    }
    check_field("name");

    if (confirm("Do you wants to save?")) {
        e.preventDefault();
        data = new FormData($('#departments-form')[0]); //form name
        /*Check XSS Code*/
        if (!xss_validation(data)) { return false; }

        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $("#" + this_id).attr('disabled', true); //Enable Save or Update button
        $.ajax({
            type: 'POST',
            url: base_url + 'branchs/save_or_update',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                //alert(result);//return;
                if (result == "success") {
                    window.location = base_url + "branchs";
                } else if (result == "failed") {
                    toastr["error"]("Sorry! Failed to save Record.Try again!");
                } else {
                    toastr["error"](result);
                }
                $("#" + this_id).attr('disabled', false); //Enable Save or Update button
                $(".overlay").remove();
                return;
            }
        });
    }

});


//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {

    if (kevent.keyCode == 13) {
        $("#" + target).focus();
    }

}

//Delete Record start
function delete_branch(q_id) {
    var base_url = $("#base_url").val();
    if (confirm("Are you sures ?")) {
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post("branchs/delete_branch", { q_id: q_id }, function(result) {
            //alert(result);return;
            if (result == "success") {
                location.reload();
            } else if (result == "failed") {
                toastr["error"]("Failed to Delete .Try again!");
            } else {
                toastr["error"](result);
            }
            $(".overlay").remove();
            return false;
        });
    } //end confirmation
}
//Delete Record end