<template>
    <div>
        <div v-if="localFriendshipStatus === 'pending'">
            <span v-text="sender.name"></span>Te ha enviado una solicitud de amistad
            <button @click="acceptFriendshipRequest" dusk="accept-friendship">Aceptar solicitud</button>
            <button @click="denyFriendshipRequest" dusk="deny-friendship">Denegar solicitud</button>
        </div>
        <div v-else-if="localFriendshipStatus === 'accepted'">
            Tú y <span v-text="sender.name"></span> son amigos
        </div>
        <div v-else-if="localFriendshipStatus === 'denied'">
            Solicitud denegada de <span v-text="sender.name"></span>
        </div>
        <div v-if="localFriendshipStatus === 'deleted'">Solicitud eliminada</div>
        <button v-else dusk="delete-friendship" @click="deleteFriendship">Eliminar solicitud</button>
    </div>
</template>

<script>
    export default {
        props: {
            sender: {
                type: Object,
                required: true
            },
            friendshipStatus: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                localFriendshipStatus: this.friendshipStatus
            }
        },
        methods: {
            acceptFriendshipRequest(){
                axios.post(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status; //'accepted'
                })
                .catch(err => {
                    console.log(err.response.data);
                });
            },
            denyFriendshipRequest(){
                axios.delete(`/accept-friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status; //'denied'
                })
                .catch(err => {
                    console.log(err.response.data);
                });
            },
            deleteFriendship(){
                axios.delete(`/friendships/${this.sender.name}`)
                .then(res => {
                    this.localFriendshipStatus = res.data.friendship_status; //'deleted'
                })  
                .catch(err => {
                    console.log(err.response.data);
                })
            }
        }
    }
</script>