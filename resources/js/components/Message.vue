<template>
    <div>
        <span v-text="formatTimestamp(message.dateTime) + ':' + message.message + '.' + message.username"></span>
        <br>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        methods: {
            formatTimestamp(timestamp) {
                let date = new Date(timestamp * 1000);
                let day = date.getDate();
                let month = date.toLocaleString('en', {month: "short"});
                let hour = (date.getHours() < 10 ? '0' : '') + date.getHours();
                let minute = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

                let formatted_date = day + ' ' + month + ' ' + hour + ':' + minute;
                return formatted_date;
            }
        }
    }
</script>