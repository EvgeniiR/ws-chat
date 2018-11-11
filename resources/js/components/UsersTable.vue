<template>
    <div>
        <table id="users-table">
            <tr class="m-auto">
                <td><b>ID</b></td>
                <td><b>USERNAME</b></td>
            </tr>
            <tr class="m-auto" v-for="(user) in users">
                <td v-text="user.id"></td>
                <td v-text="user.name"></td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['users']
    }
</script>