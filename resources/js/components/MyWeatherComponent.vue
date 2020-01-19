<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="text-center bottom-buffer-md">
                <div class="card" v-if="loaded">
                    <div class="card-header">
                        <h5 class="top-buffer-sm">{{ messages.weather.preamble }} {{ displayCity.charAt(0).toUpperCase() + displayCity.slice(1) }}, UK</h5>
                    </div>
                    <div class="card-body">
                        <div @click="setDay(1)" class="today-block pointer">
                            <div>{{ weather.todayWeekday }}</div>
                            <div><span class="current-temp">{{ weather.temperature }}&deg</span></div>
                            <div class="row">
                                <div class="col-12 text-center top-buffer-md">
                                    <span class="feels-like"><i>{{ weather.weeklySummary }}</i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div @click="setDay(2)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.tomorrowHigh }}&deg</div>
                                <div>{{ weather.tomorrowWeekday }}</div>
                                <img :src="weather.tomorrowIcon" class="weather-icon">
                            </div>
                            <div @click="setDay(3)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.dayThreeHigh }}&deg</div>
                                <div>{{ weather.dayThreeWeekday }}</div>
                                <img :src="weather.dayThreeIcon" class="weather-icon">
                            </div>
                            <div @click="setDay(4)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.dayFourHigh }}&deg</div>
                                <div>{{ weather.dayFourWeekday }}</div>
                                <img :src="weather.dayFourIcon" class="weather-icon">
                            </div>
                            <div @click="setDay(5)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.dayFiveHigh }}&deg</div>
                                <div>{{ weather.dayFiveWeekday }}</div>
                                <img :src="weather.dayFiveIcon" class="weather-icon">
                            </div>
                            <div @click="setDay(6)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.daySixHigh }}&deg</div>
                                <div>{{ weather.daySixWeekday }}</div>
                                <img :src="weather.daySixIcon" class="weather-icon">
                            </div>
                            <div @click="setDay(7)" class="col text-center top-buffer-md days-block pointer">
                                <div>{{ weather.daySevenHigh }}&deg</div>
                                <div>{{ weather.daySevenWeekday }}</div>
                                <img :src="weather.daySevenIcon" class="weather-icon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" v-else>
                    <div class="card-header">
                        <h5 class="top-buffer-sm">{{ messages.loading }}</h5>
                    </div>
                    <div class="card-body">
                        {{ loadingText }}
                    </div>
                    <div v-if="loadingError" class="bottom-buffer-md">
                        <a href="javascript:void(0);" @click="refresh">{{ messages.try_again }}</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="top-buffer-sm">{{ messages.weather.details }} {{ selectedDay }} </h5>
                </div>
                <div class="card-body details-container">
                    <div v-if="loaded" class="row">
                        <div v-if="dayOfWeek === 1" class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.temperature }}:
                        </div>
                        <div v-if="dayOfWeek === 1" class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedTemp }}&deg
                        </div>
                        <div v-if="dayOfWeek === 1" class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.feels_like }}:
                        </div>
                        <div v-if="dayOfWeek === 1" class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedFeelsLike }}&deg
                        </div>
                        <div class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.temp_max }}:
                        </div>
                        <div class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedHigh }}&deg
                        </div>
                        <div class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.temp_min }}:
                        </div>
                        <div class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedLow }}&deg
                        </div>
                        <div class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.sunrise }}:
                        </div>
                        <div class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedSunrise }}
                        </div>
                        <div class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.sunrise }}:
                        </div>
                        <div class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedSunset }}
                        </div>
                        <div class="col-lg-8 col-md-4 col-6 top-buffer-sm">
                            {{ messages.weather.precipitation }}:
                        </div>
                        <div class="col-lg-4 col-md-2 col-6 top-buffer-sm">
                            {{ detailedRain }}
                        </div>

                        <div class="col-12 text-center top-buffer-md bottom-buffer-md">
                            {{ detailedSummary }}
                        </div>
                    </div>
                </div>
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
        data() {
            return {
                cityId: null,
                cityName: null,
                dayOfWeek: 1,
                detailedFeelsLike: "",
                detailedHigh: "",
                detailedLow: "",
                detailedRain: "",
                detailedSummary: "",
                detailedSunrise: "",
                detailedSunset: "",
                detailedTemp: "",
                displayCity: null,
                loaded: false,
                loadingError: false,
                searching: false,
                weather: {},
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.displayCity = this.preferredLocation.name;
                this.city = this.preferredLocation;

                const data = {
                    id: this.city.id,
                }

                if (this.city.id) this.setLocation(data);
            });
        },
        created() {
            EventBus.$on('set-new-temp', (data) => {
                this.displayCity = data.city;

                const payload = {
                    id: data.id
                }

                if (data.id) this.setLocation(payload);
            })
        },
        computed: {
            loadingText() {
                return this.loadingError ?
                    "Something went wrong loading weather data." :
                    "Fetching weather in " + this.displayCity;
            },
            selectedDay() {
                switch(this.dayOfWeek) {
                    case 1:
                        return "Today";
                    case 2:
                        return this.weather.tomorrowWeekday;
                    case 3:
                        return this.weather.dayThreeWeekday;
                    case 4:
                        return this.weather.dayFourWeekday;
                    case 5:
                        return this.weather.dayFiveWeekday;
                    case 6:
                        return this.weather.daySixWeekday;
                    case 7:
                        return this.weather.daySevenWeekday;
                }
            },
        },
        methods: {
            refresh() {
                document.location.reload(true);
            },
            setBackgroundImage(image) {
                document.querySelector('.main-body').style.backgroundImage = 'url('+image+')';
            },
            setDay(i) {
                this.dayOfWeek = i;
                switch(this.dayOfWeek) {
                    case 1:
                        this.detailedTemp = this.weather.temperature;
                        this.detailedFeelsLike = this.weather.feelsLike;
                        this.detailedHigh = this.weather.todayHigh;
                        this.detailedLow = this.weather.todayLow;
                        this.detailedSunrise = this.weather.todaySunriseTime;
                        this.detailedSunset = this.weather.todaySunsetTime;
                        this.detailedRain = this.weather.todayRain;
                        this.detailedSummary = this.weather.todaySummary;
                        return;
                    case 2:
                        this.detailedHigh = this.weather.tomorrowHigh;
                        this.detailedLow = this.weather.tomorrowLow;
                        this.detailedSunrise = this.weather.tomorrowSunriseTime;
                        this.detailedSunset = this.weather.tomorrowSunsetTime;
                        this.detailedRain = this.weather.tomorrowRain;
                        this.detailedSummary = this.weather.tomorrowSummary;
                        return;
                    case 3:
                        this.detailedHigh = this.weather.dayThreeHigh;
                        this.detailedLow = this.weather.dayThreeLow;
                        this.detailedSunrise = this.weather.dayThreeSunriseTime;
                        this.detailedSunset = this.weather.dayThreeSunsetTime;
                        this.detailedRain = this.weather.dayThreeRain;
                        this.detailedSummary = this.weather.dayThreeSummary;
                        return;
                    case 4:
                        this.detailedHigh = this.weather.dayFourHigh;
                        this.detailedLow = this.weather.dayFourLow;
                        this.detailedSunrise = this.weather.dayFourSunriseTime;
                        this.detailedSunset = this.weather.dayFourSunsetTime;
                        this.detailedRain = this.weather.dayFourRain;
                        this.detailedSummary = this.weather.dayFourSummary;
                        return;
                    case 5:
                        this.detailedHigh = this.weather.dayFiveHigh;
                        this.detailedLow = this.weather.dayFiveLow;
                        this.detailedSunrise = this.weather.dayFiveSunriseTime;
                        this.detailedSunset = this.weather.dayFiveSunsetTime;
                        this.detailedRain = this.weather.dayFiveRain;
                        this.detailedSummary = this.weather.dayFiveSummary;
                        return;
                    case 6:
                        this.detailedHigh = this.weather.daySixHigh;
                        this.detailedLow = this.weather.daySixLow;
                        this.detailedSunrise = this.weather.daySixSunriseTime;
                        this.detailedSunset = this.weather.daySixSunsetTime;
                        this.detailedRain = this.weather.daySixRain;
                        this.detailedSummary = this.weather.daySixSummary;
                        return;
                    case 7:
                        this.detailedHigh = this.weather.daySevenHigh;
                        this.detailedLow = this.weather.daySevenLow;
                        this.detailedSunrise = this.weather.daySevenSunriseTime;
                        this.detailedSunset = this.weather.daySevenSunsetTime;
                        this.detailedRain = this.weather.daySevenRain;
                        this.detailedSummary = this.weather.daySevenSummary;
                }
            },
            setLocation(data) {
                this.loaded = false;

                axios.post('/api/weather/get', data)
                    .then((response) => {
                        if (Object.keys(response.data).length !== 0){
                            this.weather = response.data;
                            this.setBackgroundImage(this.weather.image);
                            this.loaded = true;
                            this.setDay(1);

                            return;
                        }

                        this.loadingError = true;
                    })
            },
        }
    }
</script>
