<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="locationModal" aria-hidden="true">
    <signup-modal
        :signed-up="{{ $user->is_mail ? 'true' : 'false' }}"
        :messages="{{ $messages }}">
    </signup-modal>
</div>
