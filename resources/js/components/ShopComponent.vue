<template>
    <div class="mainPlace">
        <b-row>
            <b-col>
                <h1>Shop Component</h1>

                {{ items }}
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