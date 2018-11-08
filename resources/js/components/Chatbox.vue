<template>
   <div>
       <div class="col-xl-8 center-block" id="chatbox">
           <div v-for="(message) in messages">
               <message :message="message"></message>
           </div>
       </div>
       <textarea class="col-xl-8 center-block" id="textbox" v-model="chatboxMessage"></textarea>
       <button class="col-xl-8 center-block btn-send" @click="sendMessage()">Send message</button>
   </div>
</template>

<script>
    import ChatClientRequestBuilder from '../services/ChatClientRequestBuilder';
    import Message from './Message.vue';

    export default {
        components: { Message },
        data() {
            return{
                messages: [],
                websocket: undefined,
                chatClient: undefined,
                authenticated: undefined,
                username: undefined,
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
                    self.login();
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
                    self.parseMessage(JSON.parse(event.data));
                };

                this.websocket.onerror = function (error) {
                    console.log("Error " + error.message);
                };
            },

            login() {
                if (this.username === undefined) {
                    this.username = prompt('Enter you name', 'New user');
                }

                this.chatClient.login(this.username);
            },

            parseMessage(data) {
                switch (data.type) {
                    case 'login':
                        if (data.body.result === true) {
                            this.authenticated = true;
                            this.username = data.body.username;
                        }
                        else {
                            alert('Authentication with username' + data.body.username + 'failed: ' + data.body.message);
                        }
                        break;
                    case 'messages':
                        this.parseMessages(data.body);
                        break;
                    case 'error':
                        alert('Error: ' + data.body.message);
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
                this.chatClient.sendMessage(this.chatboxMessage);

                this.chatboxMessage = '';
            }
        }
    }
</script>