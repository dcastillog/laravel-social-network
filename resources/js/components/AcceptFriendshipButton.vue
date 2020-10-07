<template>
    <div class="d-flex justify-content-between bg-light p-4 rounded mb-3 shadow">
        <div>            
            <div v-if="localFriendshipStatus === 'pending'">
                <span v-text="sender.name"></span>Te ha enviado una solicitud de amistad
            </div>

            <div v-if="localFriendshipStatus === 'accepted'">
                Tú y <span v-text="sender.name"></span> son amigos
            </div>
            
            <div v-if="localFriendshipStatus === 'denied'">
                Solicitud denegada de <span v-text="sender.name"></span>
            </div>
            <div v-if="localFriendshipStatus === 'deleted'">Solicitud eliminada de <span v-text="sender.name"></span></div>
        </div>

        <div>
            <button class="btn btn-sm btn-danger"  v-if="localFriendshipStatus !== 'deleted'" @click="deleteFriendship"   dusk="delete-friendship">Eliminar solicitud</button>
            <button class="btn btn-sm btn-primary" v-if="localFriendshipStatus === 'pending'" @click="acceptFriendshipRequest" dusk="accept-friendship">Aceptar solicitud</button>
            <button class="btn btn-sm btn-warning" v-if="localFriendshipStatus === 'pending'" @click="denyFriendshipRequest" dusk="deny-friendship">Denegar solicitud</button>
        </div>
        
        
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