<template>
    <b-container>
        <b-row>
            <b-col v-for="item in items" :key='item' cols="4">
                <b-card
                    
                    :title="item.name"
                    img-src="https://picsum.photos/600/300/?image=25"
                    img-alt="Image"
                    img-top
                    tag="article"
                    style="max-width: 20rem; height: 30rem;"
                    class="mb-2">
                    <b-card-text>
                    {{ item.description }}, 
                    {{ item.price }}
                    </b-card-text>

                    <b-button href="#" variant="primary" style="position: absolute; bottom: 0;">Add to cart</b-button>
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
            // make call to get all items
            axios.get('/api/items').then((response) => {
                this.items = response.data.data;
            });
        }
    }
</script>

<style lang="scss" scoped>
    // this allows use of variables set in sass. Try one today!
    @import "../../sass/_variables.scss";
    
</style>