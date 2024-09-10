<script>
    
        $(document).ready(function() {
            var $checkButton = $(".checkall");
            var $checkbox = $(".defaultCheck1");
            var $customDelete = $(".customDelete");
            
            $checkButton.click(function() {
                var allChecked = true;
            
                $checkbox.each(function() {
                  if (!$checkbox.prop('checked')) {
                    allChecked = false;
                    return false;
                  }
                });
            
                $checkbox.prop('checked', !allChecked);
              });

            $customDelete.click(function() {
                var selectedPictures = [];

                // Loop through checkboxes and collect selected attributes
                $checkbox.each(function() {
                    if ($(this).prop("checked")) {
                        var dataUrl = $(this).attr("data-url");
                        var dataKey = $(this).attr("data-key");
                        selectedPictures.push({
                            dataUrl: dataUrl,
                            dataKey: dataKey
                        });
                    }
                });

                if (selectedPictures.length === 0) {
                    alert('No pictures selected for deletion.');
                    return;
                }

                if (confirm('Are you sure you want to delete the selected pictures?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('custom-delete-post-pictures') }}",
                        data: {
                            postId: $('.getCustomPostID').val(),
                            selectedPictures: selectedPictures
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred while deleting pictures.");
                        }
                    });
                }
            });
        });
        
</script>