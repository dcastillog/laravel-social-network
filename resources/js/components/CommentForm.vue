<template>
    <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
            <img class="rounded shadow-sm float-left mr-2" width="35px" :src="currentUser.user_avatar" :alt="currentUser.user_name">
            <div class="input-group">
                <textarea 
                    class="form-control border-0 shadow-sm" 
                    name="comment" 
                    rows="1"
                    placeholder="Escribe un comentario"
                    v-model="newComment"
                    required    
                />
                <div class="input-group-append">
                    <button class="btn btn-primary" dusk="btn-comment">Enviar</button> 
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            statusId: {
                type: Number,
                required: true
            }
        },
        data(){
            return {
                newComment: '',
            }
        },
        methods: {
            addComment(){
                axios.post(`/statuses/${this.statusId}/comments`, {body: this.newComment})
                .then(res => {
                    this.newComment = '';
                    EventBus.$emit(`statuses.${this.statusId}.comments`, res.data.data);
                })
                .catch(err => {
                    console.log(status);
                    console.log(err);
                })  
            },
        },
    }
</script>