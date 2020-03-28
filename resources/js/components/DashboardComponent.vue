<template>
    <b-container>
        <h1>Your Dashboard.</h1>
    </b-container>
</template>

<script>

    import { mapActions, mapGetters } from "vuex";

    export default {
        name: 'dashboard',
        components: {
            
        },
        data() {
            return {
                
            }
        },

        computed: mapGetters(['isAuthenticated', 'currentUser']),
        isCurrentUser() {
            if (isAuthenticated) {
                return currentUser
            }

            return false;
        },
        methods: {
            init() {
                
            },
        },
        created() {
            axios.get('/api/users').then((response) => {
                this.users = response.data.data;
            });

            this.$store.dispatch('refreshUserData');
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../sass/_variables.scss";
</style>