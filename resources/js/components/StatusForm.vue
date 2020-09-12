<template>
    <form @submit.prevent="submit" method="POST">
        <div class="card-body">
            <textarea v-model="body" class="form-control border-0" name="body" placeholder="¿Qué estás pesssnsando USUARIO?"></textarea>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" id="btn-create-status">Publicar estado</button>
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
                        this.body='';
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>