<template>
    <b-table striped :items="results" :fields="fields" />
</template>

<script>
    var qs = require('qs');
    export default {
        name: 'results',
        data: function () {
            return {
                results: [],
                fields: ['groupe', 'time'],
                timer: '',
                round: 0
            }
        },
        mounted: function () {
           this.getResults(this.getRound())  
           //this.timer = setInterval(() => {this.getResults(this.getRound()}, 5000)
        },
        methods: {
            getResults: function (round) {
                this.$http.post('/api.php', qs.stringify({
                    action: 'getResults',
                    round: round
                }))
                .then((response) => {
                    this.results = response.data
                })
                .catch((err) => {
                    console.error(err);
                })
            },
            getRound: function() {
                this.$http.post('/api.php', qs.stringify({
                    action: 'getRound',
                }))
                .then((response) => {
                    this.round = response.data
                    return this.round
                })
                .catch((err) => {
                    console.error(err);
                })
            }
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>
