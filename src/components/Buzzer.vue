<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">Ronde {{config.round}}</div>
            <div class="col-md-12">
                <template v-if="buzz == false">
                    <div class="buzzer red"></div>
                </template>
                <template v-if="buzz == true">
                    <div class="buzzer green"></div>
                </template>
            </div>
            <div class="col-md-2" v-for="id in config.groupe">
                Groupe #{{ id }}<br />
                <input type="checkbox" :disabled="disabled" @click.once="sendClick(id)" name="buzzer1"/>
            </div>
        </div>
    </div>
</template>

<script>
    var qs = require('qs');
    export default {
        name: 'Buzzer',
        data: function () {
            return {
                config: {},
                groupe: 1,
                alert: {
                    msg: '',
                    classes: 'alert-success'
                },
                buzz: false,
                disabled: false,
                interval: null
            }
        },
        mounted: function () {
            this.$http.post('/api.php', qs.stringify({
                action: 'getConfig'
            }))
            .then((response) => {
                this.config = response.data
                this.config.groupe = parseInt(response.data.groupe)
            })
            .catch((err) => {
                //console.info(this.errors)
                console.error(err);
            })
        },
        methods: {
            sendClick: function (id) {
                this.$http.post('/api.php', qs.stringify({
                    action: 'registerClick',
                    groupe: id,
                    //round: round
                }))
                .then((response) => {
                    if (response.data === true) {
                        this.buzz = true
                        this.disabled = true
                    }
                })
                .catch((err) => {
                    //console.info(this.errors)
                    console.error(err)
                })
            },
            getRound: function() {
                this.$http.post('/api.php', qs.stringify({
                    action: 'getRound',
                }))
                .then((response) => {
                    console.log(response)
                   /* if (response.data === true) {
                        this.config.round = 
                        this.buzz = false
                        this.disabled = false
                    }*/
                })
                .catch((err) => {
                    //console.info(this.errors)
                    console.error(err)
                })
            }
        },
        ready: function () {
            this.getRound();

            this.interval = setInterval(function () {
                this.getRound();
            }.bind(this), 5000);
        },

        beforeDestroy: function () {
            clearInterval(this.interval);
        }
    }
</script>

<style>
body {
    background-color:black;
    color: white;
}
.buzzer {
    height: 25px;
    width: 25px;
    border-radius: 50%;
}
.buzzer.red {
    background-color: red;
}
.buzzer.green {
    background-color: #070;
}
</style>