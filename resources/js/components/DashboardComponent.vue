<template>
    <div class="mainPlace">
        <b-row>
            <b-col>
                <b-table v-if="currentUser.role == 'admin'" striped hover :items="[currentUser]" :fields="fields"></b-table>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <router-link v-if="currentUser.role='admin'" to="shop">Add Item</router-link>
            </b-col>
        </b-row>
    </div>
</template>

<script>

    
    import { mapActions, mapGetters } from "vuex";

    export default {
        name: 'dashboard',
        components: {
            
        },
        data() {
            return {
                users: [],

                fields: [
                    {
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'role',
                        sortable: true
                    },
                    {
                        key: 'email',
                        sortable: true
                    },
                ]
            }
        },

        computed: mapGetters(['isAuthenticated', 'currentUser']),
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

    // .mainPlace {
    //     background-color: $test;
    //     color: black;
    // }
    
</style>