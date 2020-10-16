<template>
    <div class="card border-0 bg-light shadow-sm">
        <img :src="user.avatar" :alt="user.name" class="card-img-top img-fluid">
        <div class="card-body">
            
            <h5 class="card-title"><a href="#">{{ user.name }}</a></h5>
                <request-friendship-button v-show="this.currentUser.id !== user.id"
                    class="btn btn-primary btn-block"
                    dusk="request-friendship" 
                    :recipient="user"
                />
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object
        },
    }
</script>