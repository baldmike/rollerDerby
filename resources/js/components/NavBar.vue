<template>
    <div id="navig">
        <b-navbar toggleable="md" type="light" variant="light" fixed="top">
            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
            <b-collapse is-nav id="nav_collapse">
                <b-navbar-brand to="/dashboard">Dashboard</b-navbar-brand>
            
                <b-navbar-nav>
                    <b-nav-item v-if="isAuthenticated" to="shop">Shop</b-nav-item>
                </b-navbar-nav>

                <b-navbar-nav>
                    <b-nav-item v-if="isAuthenticated" to="users">Users</b-nav-item>
                </b-navbar-nav>

                <b-navbar-nav>
                    <b-nav-item v-if="isAuthenticated" to="add-item">Add Item</b-nav-item>
                </b-navbar-nav>
                    
                <b-navbar-nav class="ml-auto">
                    
                    <b-nav-item v-if="isAuthenticated && currentUser" @click="logout" right>Logout - {{ currentUser.name }} </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>    
</template>

<script>

    import { mapActions, mapGetters } from "vuex";

    export default {
        name: "NavBar",
        methods: {

            logout() {
                this.$store.dispatch('logout');
            }
        },
        
        computed: {
            currentRoute() {
                console.log(this.$route.name);
                return this.$route.name;
            },...mapGetters(['isAuthenticated', 'currentUser'])
        },
            
        created() {
            this.$store.dispatch('refreshUserData');
        }
            
    }
</script>

<style>
    #navig {
        margin-bottom: 70px;
    }
</style>
