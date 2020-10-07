<template>
    <li class="nav-item dropdown">
        <a 
            class="nav-link dropdown-toggle" 
            :class="count ? 'text-primary font-weight-bold': ''"
            href="#" id="navbarDropdownNotifications" 
            role="button" 
            data-toggle="dropdown" 
            aria-haspopup="true" 
            aria-expanded="false"
            dusk="notifications"
        >
            <slot></slot> <span dusk="notifications-count">{{ count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotifications">
            <div class="dropdown-header text-center">Notificaciones</div>
            <notification-list-item 
                v-for="notification in notifications"
                :notification="notification"
                :key="notification.id"
            />     
        </div>
    </li> 

</template>

<script>
    import NotificationListItem from './NotificationListItem';

    export default {
        components: { NotificationListItem },
        data() {
            return {
                notifications: [],
                count: ''
            }
        },
        created() { //execute before mounted()
            if(this.isAuthenticated) {
                console.log(this.currentUser);
                Echo.private(`App.Models.User.${this.currentUser.id}`)
                    .notification(notification => {
                        console.log(notification.type);
                        this.count++;
                        this.notifications.push({
                            id: notification.id,
                            data: {
                                link: notification.link,
                                message: notification.message
                            }
                        });
                    })
            }

            axios.get('/notifications')
            .then(res => {
                this.notifications = res.data;
                this.unreadNotifications();
            })

            EventBus.$on('notification-read', () => {
                if(this.count === 1){
                    return this.count = '';
                }
                return this.count--;
            })
            
            EventBus.$on('notification-unread', () => {
                return this.count++;
            })
        },
        methods: {
            unreadNotifications(){
                this.count = this.notifications.filter(notification => {
                    return notification.read_at === null;
                }).length || '';
            }
        }
    }
</script>