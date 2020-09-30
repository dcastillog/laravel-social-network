<template>
    <div class="card border-0 mb-3 shadow-sm" >
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <img class="mr-3 shadow-sm avatar" src="https://aprendible.com/images/default-avatar.jpg" :alt="status.user.name">
                <div>
                    <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
                    <span class="small text-muted" v-text="status.ago"></span>
                </div>
            </div>
            <p class="card-text text-secondary" v-text="status.body"></p>
        </div>

        <div class="card-footer p-2 d-flex justify-content-between align-items-center">
            <like-button 
                dusk="btn-like"
                :model="status" 
                :url="`/statuses/${status.id}/likes`"
            />
            
            <div class="text-secondary mr-2">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer">
            <div v-for="comment in comments" :key="comment.id" class="mb-3">
                <div class="d-flex">
                    <img class="rounded shadow-sm mr-2" width="34px" height="34px" :src="comment.user.avatar" :alt="comment.user.name">
                    <div class="flex-grow-1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-2 text-secondary">
                                <a :href="comment.user.link"><strong>{{ comment.user.name }}</strong></a>   
                                {{ comment.body }}
                            </div>     
                        </div>
                        <small class="badge badge-pill badge-primary py-1 px-2 mt-1 float-right"
                                dusk="comment-likes-count">
                            <i class="fa fa-thumbs-up"></i>
                            {{ comment.likes_count }}
                        </small>   
                        <like-button 
                            dusk="btn-comment-like"
                            class="btn-comments-like"
                            :url="`/comments/${comment.id}/likes`"
                            :model="comment" 
                        />
                    </div>
                </div>
            </div>
           
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
        </div>
    </div>
</template>

<script>
    import LikeButton from './LikeButton';
    export default {
        props: {
            status: {
                type: Object,
                required: true
            },
        },
        components: { LikeButton },
        data(){
            return {
                newComment: '',
                comments: this.status.comments
            }
        },
        methods: {
            addComment(){
                axios.post(`/statuses/${this.status.id}/comments`, {body: this.newComment})
                .then(res => {
                    this.newComment = '';
                    this.comments.push(res.data.data);
                })
                .catch(err => {
                    console.log(status);
                    console.log(err);
                })  
            },
        }
    }
</script>

