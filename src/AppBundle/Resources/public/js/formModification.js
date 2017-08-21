// When name gets selected ...
$(document).on('change', '#appbundle_vehicle_name', function() {
    var $name = $('#appbundle_vehicle_name');
    //var $token = $('#appbundle_vehicle__token');

    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected name value.
    var data = {};
    data[$name.attr('name')] = $name.val();
    //data[$name.attr('name')] = $name.val();

    // Submit data via AJAX to the form's action path.
    $.ajax({
        url : $form.attr('action'),
        type: $form.attr('method'),
        data : data,
        success: function(html) {

            // Replace current form ...
            $('#appbundle_vehicle').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#appbundle_vehicle')
            );
            // Position field now displays the appropriate positions.
        }
    });
});