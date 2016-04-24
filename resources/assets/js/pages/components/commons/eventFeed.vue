<style>
    div.calendarDate{
        margin-left: 15px;
        border: 2px solid magenta
    }

    .date {
        display: block;
        width: 100px;
        /*height: 110px;*/
        margin: 5px auto;
        margin-left: 15px;
        background: #fff;
        text-align: center;
        font-family: 'Helvetica', sans-serif;
        position: relative;
    }

    .date .binds {
        position: absolute;
        height: 15px;
        width: 60px;
        background: transparent;
        border: 2px solid #999;
        border-width: 0 5px;
        top: -6px;
        left: 0;
        right: 0;
        margin: auto;
    }

    .date .month {
        background: #555;
        display: block;
        padding: 8px 0;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        border-bottom: 2px solid #333;
        box-shadow: inset 0 -1px 0 0 #666;
    }

    .date .day {
        display: block;
        margin: 0;
        padding: 10px 0;
        /*font-size: 48px;*/
        box-shadow: 0 0 3px #ccc;
        position: relative;
    }

    .date .day::after {
        content: '';
        display: block;
        height: 100%;
        width: 96%;
        position: absolute;
        top: 3px;
        left: 2%;
        z-index: -1;
        box-shadow: 0 0 3px #ccc;
    }

    .date .day::before {
        content: '';
        display: block;
        height: 100%;
        width: 90%;
        position: absolute;
        top: 6px;
        left: 5%;
        z-index: -1;
        box-shadow: 0 0 3px #ccc;
    }
    p.eventName{
        font-weight: 500;
        margin-bottom: 5px;
    }
    p.eventLocation{
        margin-bottom: 5px;
    }
</style>
<template>
    <div class="feed-container">
        <div class="clearfix">
            <div class="feed-owner">
                <img class="avatar" :src="feed.organiser.avatar" :alt="feed.name">
                <p class="name">{{feed.organiser.name}}</p>
                <p class="time">
                    <small>{{feed.created_at | parseDateToHuman}}</small>
                </p>
            </div>
            <div class="row clearfix">
                <div class="col-xs-3 col-sm-2 date">
                    <span class="blinds"></span>
                    <span class="month">{{feed.startDateTime | parseMonth}}</span>
                    <h2 class="day">{{feed.startDateTime | parseDay}}</h2>
                </div>
                <div class="col-xs-8 col-sm-9 pull-right">
                    <p class="eventName">{{feed.name}}</p>
                    <p class="eventLocation"><small>{{feed.location}}</small></p>
                    <content-container
                            :content="feed.description"
                            :max-char="150"
                    ></content-container>
                </div>
            </div>

            <button
                    class="pull-right unstyled"
                    v-show="feed.numberOfComments>0"
                    @click.prevent="">
            </button>
        </div>
        <hr>
        <div class="actions">
            <ul class="list-inline">
                <li>
                    <button class="unstyled"
                            :class="{'btn btn-primary':joinEvent}"
                            @click.prevent="clickJoinEvent"><i class="fa fa-calendar-o"></i>
                        Join
                    </button>
                </li>
                <li>
                    <button class="unstyled"><i class="fa fa-share-alt" aria-hidden="true"></i>
                        Share
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import ContentContainer from './content.vue';
    export default{
        props:{
            feed:{
                type: Object
            }
        },
        data: function(){
            return {
                joinEvent: false
            }
        },
        filters: {
            parseDateToHuman: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
            },
            parseMonth: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").format("MMM");
            },
            parseDay: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").format("D");
            }
        },
        components:{
            ContentContainer
        },
        methods:{
            clickJoinEvent: function(){
                if(!this.joinEvent)
                    this.$dispatch("joinEvent", this.feed)
            }
        },
        events:{
            jointedEvent: function (eventId) {
                if(this.feed.id == eventId)
                        this.joinEvent = true;
            }
        }
    }
</script>