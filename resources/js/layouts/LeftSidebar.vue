<template>
    <div>
        <div class="profile-card">
            <img src="https://aprendible.com/images/default-avatar.jpg" alt="user" class="profile-photo" />
            <h5><a href="timeline.html" class="text-white">Sarah Cruiz</a></h5>
            <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> 1,299 followers</a>
        </div>

        <ul class="card shadow-sm border-0 nav-news-feed d-flex">
            
            <router-link :to="{name: 'home'}">
                <li><i class="fas fa-home"></i>Inicio</li>
            </router-link>

            <li><i class="icon ion-ios-videocam"></i><div><a href="newsfeed-videos.html">Explorar</a></div></li>
            
            <li><i class="icon ion-ios-people"></i><div><a href="newsfeed-people-nearby.html">Personas cerca</a></div></li>
            
            <router-link :to="{name: 'friends'}">
                <li><i class="fas fa-home"></i>Amigos</li>
            </router-link>

            
            <li><i class="icon ion-chatboxes"></i><div><a href="newsfeed-messages.html">Mensajes</a></div></li>
            
            <li><i class="icon ion-images"></i><div><a href="newsfeed-images.html">Galeria</a></div></li>
            
            <router-link :to="{name: 'profile', params: {slug: `@${this.currentUser.name}` }}">
                <li><i class="fas fa-home"></i>Mi perfil</li>
            </router-link>
        </ul>
    </div>
</template>