<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <i class="fa fa-address-book text-primary m-1"></i>
            Laranet
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mr-5">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{name: 'friendRequests'}">
                        <i class="fa fa-user-friends"></i>
                    </router-link>
                </li>
                <notification-list>
                    <i class="fa fa-bell"></i>
                </notification-list>
            </ul>
        </div>
    </nav>

</template>