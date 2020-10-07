<template>
    <div @click="redirectIsGuest">
        <transition-group name="status-list-transition">
            <status-list-item 
                v-for="status in statuses" 
                :status="status"
                :key="status.id" 
            />
        </transition-group>
    </div>
</template>

<script>
    export default {
        props: {
            url: String
        },
        data() {
            return {
                statuses: []
            }
        },
        mounted() {
            axios.get(this.getUrl)
                .then(res => {
                    this.statuses = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
                
            EventBus.$on('status-created', status => {
                this.statuses.unshift(status); // unshift va a ordenar la lista de estados
            }); // Escuchamos el evento 

            Echo.channel('statuses').listen('StatusCreated', ({status}) => {
                this.statuses.unshift(status)
            });
        },
        computed: {
            getUrl(){
                return this.url ? this.url : '/statuses';
            }
        }
        
    }
</script>

<style>
    .status-list-transition-move {
        transition: all .8s;
    }
</style>