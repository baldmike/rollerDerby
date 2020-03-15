<template>
    <div class="mainPlace">
        <b-row>
            <b-col>
                <b-table v-if="this.user.role == 'admin'" striped hover :items="users" :fields="fields"></b-table>

                {{ user }}
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
                user: null,
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
            axios.get('/api/user').then((response) => {
                this.user = response.data.data;
            })

            axios.get('/api/users').then((response) => {
                this.users = response.data.data;
            });
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