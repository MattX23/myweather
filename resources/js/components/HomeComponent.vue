<template>
    <div class="col-md-12">
        <div class="text-center">
            <city-search
                :preferred-location="location"
                :messages="messages">
            </city-search>
        </div>
        <my-weather
            :preferred-location="location"
            :messages="messages">
        </my-weather>
    </div>
</template>

<script>
    import { EventBus } from '../eventbus/event-bus';

    export default {
        props: {
            location: {
                type: Object
            },
            messages: {
                type: Object
            }
        },
        created() {
            EventBus.$on('search-complete', function() {
                EventBus.$emit('reset-search');
            });
        }
    }
</script>
