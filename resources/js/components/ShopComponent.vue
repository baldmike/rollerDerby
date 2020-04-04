<template>
    <b-container>
        <b-row>
            <b-col v-for="item in items" :key='item.id' cols="3">
                <b-card
                    :title="item.name"
                    :img-src="item.image"
                    @click="showSelectedItemModal(item)"
                    item="'item.id'"
                    img-alt="Image"
                    img-top
                    tag="article"
                    style="max-width: 20rem; height: 30rem;"
                    class="mb-2">
                    <b-card-text>
                        <p>
                            ${{ item.price }}
                        </p>
                    </b-card-text>
                    <b-button href="#">Add to cart</b-button>
                </b-card>
            </b-col>
        </b-row>

         <!-- Show Animal Modal Component -->
            <b-modal ref="selectedItemModal" :item="'item'" ok-only ok-title="Close" ok-variant="light" no-close-on-backdrop>
                <b-row>
                    <b-col>
                        <h3 class="headline">{{ selectedItem.name }}</h3>
                        <h6>{{ selectedItem.description }}</h6>
                    </b-col>
                    <b-col>
                        ${{ selectedItem.price}}
                        <b-button href="#">Add to cart</b-button>
                    </b-col>
                </b-row>
            </b-modal>
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
                selectedItem: '',
            }
        },

        computed: mapGetters(['isAuthenticated', 'currentUser']),
        methods: {
            init() {
                
            },
            showSelectedItemModal(item) {
                this.selectedItem = item;
                this.$refs.selectedItemModal.show();
            },
            hideModal () {
                this.$refs.selectedItemModal.hide();
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