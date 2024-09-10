<div class="mail-result mx-3 d-none rounded" style="background-color: #d1e7dd;">
    <h4 id="mail-result" class="pt-3 px-3" style="color: #0f5132;">
    </h4>
</div>
<div class="mail-result-error mx-3 d-none rounded" style="background-color: #f8d7da;">
    <h4 id="mail-result-error" class="pt-3 px-3" style="color: #842029;">
    </h4>
</div>
<div class="modal-body">
    <input id="authEmail" type="hidden" name="authEmail" class="form-control"
        value="{{ isset(Auth::user()->email) ? Auth::user()->email : 'Empty@email.com' }}">
    <input id="authName" type="hidden" name="authName" class="form-control"
        value="{{ isset(Auth::user()->name) ? Auth::user()->name : 'Empty-name' }}">
    <div class="mb-3 required">
        <label class="control-label" for="phone">
            My Friend's Email Address
        </label>
        <input id="postSendEmail" type="text" name="postSendEmail" class="form-control" placeholder="YourFriend@.com"
            required>
    </div>
    <div class="mb-3 required">
        <label class="control-label" for="body">
            Message <span class="text-count">(500 max)</span> <sup>*</sup>
        </label>
        <textarea id="postSendMessage" name="postSendMessage" rows="5" class="form-control" style="height: 150px;"
            placeholder="Hi , You are still available?" required></textarea>

    </div>
</div>
<script>
    function PostSendMail() {
        $('#mail-result').text('');
        var inputauthName = $('#authName').val();
        var inputauthEmail = $('#authEmail').val();
        var inputEmail = $('#postSendEmail').val();
        var inputMessage = $('#postSendMessage').val();
        if (inputEmail && inputMessage) {
            $.ajax({
                type: "post",
                url: "{{ url('post-send-mail') }}",
                data: {
                    authName: inputauthName,
                    authEmail: inputauthEmail,
                    email: inputEmail,
                    message: inputMessage,
                    url: window.location.href
                },
                success: function(response) {
                    $('.mail-result-error').addClass('d-none');
                    $('.mail-result').removeClass('d-none');
                    $('#mail-result').append(response.message);
                    // location.reload();
                }
            });
        } else {
            $('.mail-result').addClass('d-none');
            $('.mail-result-error').removeClass('d-none');
            $('#mail-result-error').text('Error! Please enter a Input');
        }
    }
</script>
