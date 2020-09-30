<template>
    <form @submit.prevent="submit" v-if="isAuthenticated">
        <div class="card-body">
            <textarea 
                v-model="body" 
                class="form-control border-0" 
                name="body" 
                :placeholder="`¿Qué estás pensando ${currentUser.name}?`" 
                required
            />
        </div>
        <div class="card-footer">
            <button 
                class="btn btn-primary" 
                id="btnCreateStatus"
            ><i class="fa fa-paper-plane mr-1"></i>Publicar estado</button>
        </div>
    </form>
    <div v-else class="card-body">
        <a href="/login">DEBES HACER LOGIN</a>
    </div>
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
                        EventBus.$emit('status-created', res.data.data) // Emitimos el evento bus (Se accede a data.data porl StatusResource)
                        this.body='';
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>