<template>
    <div class="test-container">
        <div class="not-started" v-if="!started">
            <button class="cms-btn darken" @click="start">{{ title }} <em class="fas fa-play"></em></button>
        </div>
        <div class="started" v-else>
            <h4>Ready: 
                <div 
                    class="ready-progress-bar"
                    :style="`background-position-x: ${100 - (ready / size * 100)}%`"
                    >{{ ready }} / {{ size }}</div>
            </h4>
            
            <h6>Fetching: {{ url }}</h6>
            <h6>Estimated time left: {{ estimated_time_left }}s</h6>
            <h6>Time from start: {{ time_from_start }}s</h6>

            <span class="hr-line hr-light mt-5 mb-5"></span>
        </div>
    </div>
   
</template>

<script>
const TEST_SIZE = 500

export default {
    name: "PerformanceTestRun",
    props: {
        title: String
    },
    data() {
        return {
            size: TEST_SIZE,
            started: false,
            started_at: 0,
            ready: 0,
            url: window.location.origin + '', // ?count-views=false
            estimated_time_left: 0,
            time_from_start: 0
        }
    },
    methods: {
        start() {
            this.started = true
            this.started_at = Date.now()

            this.checkEstimatedTimeLeft();

            for(let i = 0; i < TEST_SIZE; i++) {
                fetch(this.url).then(() => this.fetchReady())
            }
        },
        fetchReady() {
            this.ready++
            if(this.ready === TEST_SIZE) {
                window.location.reload();
            }
        },
        checkEstimatedTimeLeft() {
            const { ready } = this;
            const timeratio = Date.now() - this.started_at;
            const timeratio_perone = timeratio / ready;
            const estimated_timeleft = TEST_SIZE * timeratio_perone - timeratio;

            this.estimated_time_left = (estimated_timeleft / 1000).toFixed(2);
            this.time_from_start = (timeratio / 1000).toFixed(2);

            setTimeout(() => this.checkEstimatedTimeLeft(), 10);
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../../styles/config.scss";

    .cms-btn {
        em {
            margin-left: 6px;
        }
    }

    .started {
        .ready-progress-bar {
            display: inline;
            background: linear-gradient(-90deg, #0002 50%, $logo 50%);
            background-size: 200%;
            background-position-x: 100%;
            padding: 0 10px;
        }
    }
</style>