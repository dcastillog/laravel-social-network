<template>
    <div>
        <profile-card 
            :user="user"
        />
    </div>
</template>

<script>
    import ProfileCard from '../components/ProfileCard';

    export default {
        props: ['slug'],
        components: {
            ProfileCard
        },
        data() {
            return {
                user: '',
            }
        },
        mounted(){
            axios.get(`/${this.slug}`)
                .then(res => {
                    this.user = res.data.data;          
                }).catch(err => {
                    console.log(err);
                })
        }
    }
</script>