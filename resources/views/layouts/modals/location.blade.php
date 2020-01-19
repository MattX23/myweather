<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModal" aria-hidden="true">
    <location-modal
        :preferred-location="{{ $user->preferredLocation->location }}"
        :messages="{{ $messages }}">
    </location-modal>
</div>
