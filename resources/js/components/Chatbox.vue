<template>
   <div class="container">
       <div class="row">
           <div class="col-xl-8">
               <messages-view :messages="messages"></messages-view>
               <textarea class="w-100" @keydown.enter.prevent="sendMessage()" id="textbox" v-model="chatboxMessage"></textarea>
               <button class="w-100 btn-send" @click="sendMessage()">Send message</button>
           </div>
           <div class="col-xl-4">
               <div class="sticky-top">
                   <users-table :users="users"></users-table>
               </div>
           </div>
       </div>
   </div>
</template>

<script>
    import ChatClientRequestBuilder from '../services/ChatClientRequestBuilder';

    export default {
        data() {
            return{
                messages: [],
                websocket: undefined,
                chatClient: undefined,
                authenticated: undefined,
                username: undefined,
                users: [],
                chatboxMessage: ''
            }
        },

        created() {
            this.initWebsocketConnection();
        },

        methods: {
            initWebsocketConnection() {
                this.websocket = new WebSocket("ws:my_token@" + window.location.host + "/ws/");
                this.chatClient = new ChatClientRequestBuilder(this.websocket);
                this.websocket.keepalive = true;

                self = this;

                this.websocket.onopen = function () {
                    console.log('Connected!');
                    self.users = [];
                    self.messages = [];
                    self.authenticate();
                };

                this.websocket.onclose = function (event) {
                    if (event.wasClean) {
                        console.log('Connection closed withoud errors');
                    } else {
                        console.log('Connection interrupted');
                    }
                    console.log('Code: ' + event.code + ' reason: ' + event.reason);
                    console.log('Trying to reconnect');
                    self.initWebsocketConnection();
                };

                this.websocket.onmessage = function (event) {
                    console.log(event);
                    self.parseResponse(JSON.parse(event.data));
                };

                this.websocket.onerror = function (error) {
                    console.log("Error " + error.message);
                };
            },

            authenticate() {
                while (this.username === null ||
                    this.username === undefined ||
                    (! this.username)
                ) {
                    this.username = prompt('Enter you name', 'New user');
                    if(this.username === null) { return; }
                    this.username = this.username.trim();
                }

                this.chatClient.login(this.username);
            },

            parseResponse(data) {
                switch (data.type) {
                    case 'login':
                        if (data.body.result === true) {
                            this.authenticated = true;
                            this.username = data.body.username;
                        }
                        else {
                            alert('Authentication with username' + data.body.username + ' failed: ' + data.body.message);
                            this.username = false;
                            this.authenticate();
                        }
                        break;
                    case 'messages':
                        this.parseMessages(data.body);
                        break;
                    case 'error':
                        alert('Error: ' + data.body.message);
                        break;
                    case 'users':
                        this.parseUsersResponse(data.body);
                        break;
                }
            },

            parseMessages(body) {
                if (body.messages !== undefined) {
                    let messagesArray = [];
                    body.messages.forEach(function (data) {
                        messagesArray.push(data);
                    });
                    messagesArray.sort(
                        function sortMessagesByDateTime(message1, message2) {
                            return message1.dateTime - message2.dateTime;
                        }
                    );
                    this.messages = this.messages.concat(messagesArray);
                }
            },

            sendMessage() {
                if(this.authenticated) {
                    this.chatClient.sendMessage(this.chatboxMessage);
                    this.chatboxMessage = '';
                } else {
                    this.authenticate();
                }
            },

            parseUsersResponse(responseBody) {
                self = this;
                switch (responseBody.action) {
                    case 'new users':
                        responseBody.users.forEach(function (connectedUser) {
                            self.users.forEach(function (currentUser, index, arr) {
                                if(Number(currentUser.id) === Number(connectedUser.id)) {
                                    arr.splice(index, 1); // Fix doubling users
                                }
                            });
                        });
                        this.users = this.users.concat(responseBody.users);
                        break;
                    case 'disconnected':
                        responseBody.users.forEach(function (disconnectedUser) {
                            self.users.forEach(function (currentUser, index, arr) {
                                if(Number(currentUser.id) === Number(disconnectedUser.id)) {
                                    arr.splice(index, 1);
                                }
                            });
                        });
                        break;
                }
            }
        }
    }
</script>