<template>
    <div>
        <div class="col-xl-8 center-block" id="chatbox">
            <div v-for="(message) in messages">
                <span v-text="formatTimestamp(message.dateTime) + ':' + message.message + '.' + message.username"></span>
                <br>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['messages'],

        data() {
            return{
                chatbox: undefined
            }
        },

        created: function() {
            this.$nextTick(function () {
                this.chatbox = this.$el.querySelector("#chatbox");
            })
        },

        updated: function () {
            this.$nextTick(function () {
                this.scrollChatboxDownIfUserWasAtTheBottom();
            })
        },

        methods: {
            formatTimestamp(timestamp) {
                let date = new Date(timestamp * 1000);
                let day = date.getDate();
                let month = date.toLocaleString('en', {month: "short"});
                let hour = (date.getHours() < 10 ? '0' : '') + date.getHours();
                let minute = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

                let formatted_date = day + ' ' + month + ' ' + hour + ':' + minute;
                return formatted_date;
            },

            scrollChatboxDownIfUserWasAtTheBottom() {
                let scrollHeight = this.chatbox.scrollHeight;
                let currentScrollPosition = this.chatbox.scrollTop;
                let offsetHeight = this.chatbox.offsetHeight;

                let userScrollMaxValue = scrollHeight - offsetHeight;

                let scrollProportion = (currentScrollPosition / userScrollMaxValue);
                if (scrollProportion > 0.8 || // on bottom
                    scrollProportion < 0.025) // on Top
                {
                    this.chatbox.scrollTop = userScrollMaxValue;
                }
            }
        }
    }
</script>