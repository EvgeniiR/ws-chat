require('bootstrap');

window.Vue = require('vue');

Vue.component('messages-view', require('./components/MessagesView.vue'));
Vue.component('chatbox', require('./components/Chatbox.vue'));
Vue.component('users-table', require('./components/UsersTable.vue'));

const app = new Vue({
    el: '#app'
});