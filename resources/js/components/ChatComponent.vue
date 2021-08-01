<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">
                    {{ dialog.subject }} Dialog
                </div>
                <div class="card-body p-0">
                    <ul
                        class="list-unstyled"
                        style="height:570px; overflow-y:scroll; overflow-x:hidden; background-color:#F0FFF0"
                        v-chat-scroll

                    >
                        <li
                            class="p-2"
                            v-for="(message, index) in messages"
                            :key="index"
                        >
                        <div class="row">
                            <div class="col-6">
                                <div v-if="(message.sender) == 0 && (message.check_image) == 0">
                                    <strong class="text-muted" v-if="(dialog.client.fname)">{{ dialog.client.fname }}</strong>
                                    <strong class="text-muted" v-else>{{ dialog.client.email }}</strong>
                                    <div class="bg-info p-2" style="border-radius:5px; color:white; width:19vw">
                                        <span >{{ message.body }}</span>
                                    </div>
                                </div>
                                <div v-else-if="(message.sender) == 0 && (message.check_image) == 1">
                                    <strong class="text-muted" v-if="(dialog.client.fname)">{{ dialog.client.fname }}</strong>
                                    <strong class="text-muted" v-else>{{ dialog.client.email }}</strong>
                                    <div class="bg-info p-2" style="border-radius:5px; color:white; width:19vw">
                                        <img :src="message.body" style="width:213px;height:200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div v-if="(message.sender) == 1">
                                    <strong class="text-muted" style="float:right">{{ message.user.name }}</strong>
                                    <br>
                                    <div class="bg-secondary p-2" style="border-radius:5%; color:white;">
                                        <span>{{ message.body }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input
                            @keydown="sendTypingEvent"
                            @keyup.enter="sendMessage"
                            v-model="newMessage"
                            type="text"
                            name="message"
                            placeholder="Enter your message..."
                            class="form-control"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <span class="text-muted" v-if="activeUser"
                    >{{ activeUser.name }} is typing...</span
                >
            </div>
        </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul id="online-users">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user", "id"],
    data() {
        return {
            messages: [],
            dialog: "",
            newMessage: "",
            users: [],
            activeUser: false,
            typingTimer: false
        };
    },
    created() {
        let onlineUsersLength=0;
        this.fetchMessages();
        Echo.join("chat")
            .here(user => { onlineUsersLength = user.length;
                if(user.length >1){
                    $('#no-online-users').css('display','none');
                }
                let userId= $('meta[name=user-id]').attr('content');
                user.forEach(function(row){
                    if(row.id== userId){
                    return;
                    }
                    $('#online-users').append(`<li id="user-${row.id}">${row.name}</li>`);
                })
            })
            .joining(user => {
                this.users.push(user);
                let userId= $('meta[name=user-id]').attr('content');
                this.users.forEach(function(row){
                    if(row.id== userId){
                    return;
                    }
                    $('#online-users').append(`<li id="user-${row.id}">${row.name}</li>`);
                })
            })
            .leaving(user => {
                this.users = this.users.filter(u => u.id != user.id);
                $('#user-'+ user.id).remove();
                console.log('#user-'+ user.id);
            })
            .listen("ChatEvent", event => {
                this.messages.push(event.chat);
            })
            .listenForWhisper("typing", user => {
                this.activeUser = user;
                if (this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }
                this.typingTimer = setTimeout(() => {
                    this.activeUser = false;
                }, 1000);
            });
    },
    methods: {
        fetchMessages() {
            console.log(process.env.NODE_ENV);
            axios.post("/getMessages", {
                dialog_id:this.id
            }).then(response => {
                this.messages = response.data[0];
                this.dialog = response.data[1];
            });
        },
        sendMessage() {
            if (this.newMessage.length != 0) {

                axios.post("/messages", {
                    body: this.newMessage,
                    dialog_id: this.id
                });
                this.messages.push({
                    body: this.newMessage,
                    user: this.user,
                    sender: 1
                });
                console.log(this.messages);
                this.newMessage = "";
            }
        },
        sendTypingEvent() {
            Echo.join("chat").whisper("typing", this.user);
            console.log(this.user.name + " is typing now");
        }
    }
};
</script>
