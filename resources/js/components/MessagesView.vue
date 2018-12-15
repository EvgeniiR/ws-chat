<template>
    <div>
        <div class="w-100" id="chatbox">
            <div v-for="(message) in messages">
                <span v-html="formatTimestamp(message.dateTime) + ':' + message.username+ '. ' + formatMessage(message.message)"></span>
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
            },

            formatMessage(message) {
                var urlRegexPattern = '(?!mailto:)(?:(?:http|https|ftp)://)(?:\\S+(?::\\S*)?@)?(?:(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[0-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))|localhost)(?::\\d{2,5})?(?:(/|\\?|#)[^\\s]*)?';
                var urlRegex = new RegExp(urlRegexPattern, 'ugi');
                return message.replace(urlRegex, '<a href="$&">$&</a>');
            }
        }
    }
</script>
