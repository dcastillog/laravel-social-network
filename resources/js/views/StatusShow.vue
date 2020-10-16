<template>
    <div class="container">
        <status-list-item 
            :status="status"
        />
    </div> 
</template>

<script>
    export default {
        data() {
            return {
                status: ''
            }
        },
        mounted(){
            axios.get(`/statuses/${this.$route.params.id}`)
                .then(res => {
                    this.status = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }

</script>