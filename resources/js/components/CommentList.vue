<template>
    <div>
        <transition-group name="comment-list-transition">
            <comment-list-item 
                v-for="comment in comments" 
                :comment="comment"
                :key="comment.id" 
                class="mb-3" 
            />

        </transition-group>
    </div>
</template>

<script>
    import CommentListItem from './CommentListItem';

    export default {
        components: {CommentListItem},
        props: {
            comments: {
                type: Array,
                required: true
            },
            statusId: {
                type: Number,
                required: true
            }
        },
        mounted(){
            Echo.channel(`statuses.${this.statusId}.comments`).listen('CommentCreated', ({comment}) => {
                this.comments.push(comment)
            });

            //escuchamos el evento desde StatusListItem
            EventBus.$on(`statuses.${this.statusId}.comments`, comment => {
                this.comments.push(comment);
            });
        }
    }
</script>

<style scoped>
    .comment-list-transition-move {
        transition: all .2s;
    }
</style>