<template>
    <div @click="redirectIsGuest">
        <status-list-item 
            v-for="status in statuses" 
            :status="status"
            :key="status.id" 
        />
    </div>
</template>

<script>
    import StatusListItem from './StatusListItem'
    export default {
        components: { StatusListItem },
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