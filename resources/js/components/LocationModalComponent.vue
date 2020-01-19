<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ messages.search.new_location }}</h5>
                <button type="button" id="close-modal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <city-search
                    :preferred-location="preferredLocation"
                    :modal="true"
                    :permanent="true"
                    :messages="messages">
                </city-search>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../eventbus/event-bus';

    export default {
        props: {
            preferredLocation: {
                type: Object
            },
            messages: {
                type: Object
            }
        },
        created() {
            EventBus.$on('close-modal', function() {
                document.getElementById('close-modal').click();
            });
        }
    }
</script>
