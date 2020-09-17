<template>
    <div>
        <div v-for="status in statuses" :key="status.id" v-text="status.body"></div>
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
        }
    }
</script>