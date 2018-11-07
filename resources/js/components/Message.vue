<template>
    <div>
        <span v-text="message.username + message.dateTime + message.text"></span>
        <br>
    </div>

    <!--<div :id="'reply-'+id" class="card mb-3 mt-3">-->
        <!--<div class="card-header d-flex justify-content-between" :class="isBest ? 'success' : ''">-->
            <!--<h5>-->
                <!--<a :href="'/profiles/'+reply.owner.name"-->
                   <!--v-text="reply.owner.name"></a>-->
                <!--said <span v-text="ago"></span>-->
            <!--</h5>-->
        <!--</div>-->
    <!--</div>-->
</template>

<script>
    export default {
        props: ['message'],
    }
</script>