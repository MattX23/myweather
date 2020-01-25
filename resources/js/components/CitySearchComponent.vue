<template>
    <div class="text-center bottom-buffer-md city-search">
        <div class="search-box">
            <input v-model="cityText" type="text" class="form-control" :placeholder="placeholder" @keyup.enter="searchLocations">
            <div class="city-error" v-if="searchError">{{ messages.no_data }}</div>
        </div>
        <button type="submit" class="btn btn-success top-buffer-sm" @click="searchLocations">{{ messages.buttons.search }}</button>
        <button v-if="modal" type="button" class="btn btn-secondary top-buffer-sm" data-dismiss="modal">{{ messages.buttons.cancel }}</button>
        <button v-if="searching && !modal" type="submit" class="btn btn-success top-buffer-sm" @click="showPreferredCity">{{ this.preferredLocation.name }}</button>
    </div>
</template>

<script>
    import {EventBus} from "../eventbus/event-bus";

    export default {
        props: {
            messages: {
                type: Object
            },
            modal: {
                type: Boolean
            },
            permanent: {
                type: Boolean
            },
            preferredLocation: {
                type: Object
            },
        },
        data() {
            return {
                cityId: null,
                cityText: null,
                searchError: false,
                searching: false,
            }
        },
        mounted() {
            EventBus.$on('reset-search', () => {
                this.cityId = null;
                this.searching = false;
            })
        },
        computed: {
            placeholder() {
                return this.modal ?
                    this.messages.search.preferred_location :
                    this.messages.search.new_weather;
            }
        },
        methods: {
            setSearching() {
                this.searching = this.cityId !== this.preferredLocation.id;
            },
            setPermanently() {
                const data = {
                    id: this.cityId,
                }

                if (!this.cityId) return;

                axios.post('/api/location/set', data)
                    .then(() => {
                        EventBus.$emit('search-complete', this.cityId);
                        EventBus.$emit('close-modal');
                    });
            },
            searchLocations() {
                this.searchError = false;

                const data = {
                    city: this.cityText
                }

                if (!this.cityText) return;

                axios.post('/api/location/get', data)
                    .then((response) => {
                        if (response.data) {
                            this.cityId = response.data;

                            if (this.permanent) this.setPermanently();

                            const data = {
                                id: this.cityId,
                                city: this.cityText,
                            }

                            this.setSearching();
                            this.cityText = '';

                            EventBus.$emit("set-new-temp", data);

                            return;
                        }

                        this.searchError = true;
                    });
            },
            showPreferredCity() {
                this.cityText = this.preferredLocation.name;

                this.searchLocations();
            }
        }
    }
</script>
