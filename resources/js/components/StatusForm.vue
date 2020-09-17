<template>
    <form @submit.prevent="submit">
        <div class="card-body">
            <textarea v-model="body" class="form-control border-0" name="body" placeholder="¿Qué estás pensando USUARIO?"></textarea>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" id="btnCreateStatus">Publicar estado</button>
        </div>
    </form>
</template>

<script>
    export default {
        data(){
            return {
                body: ''
            }
        },
        methods: {
            submit() {
                axios.post('/statuses', {body: this.body})
                    .then(res => {
                        EventBus.$emit('status-created', res.data) // Emitimos el evento bus
                        this.body='';
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>