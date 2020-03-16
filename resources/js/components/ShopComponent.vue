<template>
    <b-container>
        <b-row>
            <b-col>
                <b-card v-for="item in items" :key='item'>
                    <p><strong>{{ item.name }}</strong>, {{ item.description }}, ${{ item.price }}</p>
                </b-card>
            </b-col>
        </b-row>
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
                items: [],
            }
        },

        computed: mapGetters(['isAuthenticated', 'currentUser']),
        methods: {
            init() {
                
            },
        },
        created() {
            axios.get('/api/items').then((response) => {
                this.items = response.data.data;
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