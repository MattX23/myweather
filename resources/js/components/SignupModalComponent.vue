<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ messages.modal.signup }}</h5>
                <button type="button" id="close-modal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div v-if="success" class="modal-body">
                Success!
            </div>
            <span v-if="!success">
                <div v-if="!status" class="modal-body">
                    {{ messages.modal.signup_body }}
                </div>
                <div v-else class="modal-body">
                    {{ messages.modal.unsub_body }}
                </div>
            </span>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ cancelText }}</button>
                <span v-if="!success">
                    <button v-if="!status" type="submit" class="btn btn-success" @click="signUp">{{ messages.buttons.sign_up }}</button>
                    <button v-else type="submit" class="btn btn-danger" @click="signUp">{{ messages.buttons.unsubscribe }}</button>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            signedUp: {
                type: Boolean
            },
            messages: {
                type: Object
            }
        },
        data() {
            return {
                cancelText: this.messages.buttons.cancel,
                status: this.signedUp,
                success: false
            }
        },
        methods: {
            signUp() {
                const data = {
                    status: !this.signedUp,
                }

                axios.post('/api/mailinglist/subscription', data)
                    .then(() => {
                        this.success = true;
                        this.cancelText = this.messages.buttons.close;

                        window.setTimeout(() => {
                            this.success = false;
                            this.status = !this.status;
                        }, 2000)
                    });
            },
        }
    }
</script>
