<template>
    <div @click="redirectIsGuest">
        <div class="card border-0 mb-3 shadow-sm" v-for="status in statuses" :key="status.id">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <img class="mr-3 shadow-sm avatar" src="https://aprendible.com/images/default-avatar.jpg" alt="Avatar">
                    <div>
                        <h5 class="mb-1" v-text="status.user_name"></h5>
                        <span class="small text-muted" v-text="status.ago"></span>
                    </div>
                </div>
                <p class="card-text text-secondary" v-text="status.body"></p>
            </div>
            <div class="card-footer p-2 d-flex justify-content-between align-items-center">
                <button 
                    v-if="status.is_liked" 
                    dusk="btn-unlike" 
                    class="btn btn-link"
                    @click="unlike(status)"
                ><strong>
                    TE GUSTA
                </strong></button>
                
                <button 
                    v-else 
                    dusk="btn-like" 
                    class="btn btn-link"
                    @click="like(status)"
                >   
                    <i class="far fa-thumbs-up text-primary mr-1"></i>
                    ME GUSTA
                </button>
                <div class="text-secondary mr-2">
                    <i class="far fa-thumbs-up"></i>
                    <span dusk="likes-count">{{ status.likes_count }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                statuses: []
            }
        },
        mounted() {
            axios.get('/statuses')
                .then(res => {
                    this.statuses = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
                
            EventBus.$on('status-created', status => {
                this.statuses.unshift(status); // unshift va a ordenar la lista de estados
            }); // Escuchamos el evento 
        },
        methods: {
            like(status) {
                axios.post(`/statuses/${status.id}/likes`)
                .then(res => {
                    status.is_liked = true;
                    status.likes_count++;
                })
            },
            unlike(status) {
                axios.delete(`/statuses/${status.id}/likes`)
                .then(res => {
                    status.is_liked = false;
                    status.likes_count--;
                })
            },   
        }
    }
</script>