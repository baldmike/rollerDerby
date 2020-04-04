<template>
    <b-container>
        <b-row>
            <b-col>
                <b-form>
                    <h6 v-if="$v.form.$dirty">Fields marked with a red <span style="color: red;">X</span> are required</h6>

                    <h2 class="center">Add a New Item to the Store</h2>

                    <b-row>
                        <b-col>
                            <b-form-group>
                                <label for="itemName" class="label">Item Name</label>
                                <b-form-input
                                        id="itemName"
                                        :class="{ 'has-danger': $v.form.itemName.$invalid && $v.form.itemName.$dirty, 'has-success': !$v.form.itemName.$invalid }"
                                        v-model="form.itemName"
                                        maxlength="40"
                                        required/>
                            </b-form-group>
                        </b-col>

                        <b-col>
                            <b-form-group>
                                <label for="itemDescription" class="label">Item Description</label>
                                <b-form-textarea
                                        id="itemDescription"
                                        :class="{ 'has-danger': $v.form.itemDescription.$invalid && $v.form.itemDescription.$dirty, 'has-success': !$v.form.itemDescription.$invalid }"
                                        v-model="form.itemDescription"
                                        rows="4"
                                        max-rows="10"
                                        required/>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col>
                            <b-form-group>
                                <label for="ItemPrice" class="label">Item Price</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                
                                    <b-form-input
                                            id="itemPrice"
                                            type="number"
                                            :class="{ 'has-danger': $v.form.itemPrice.$invalid && $v.form.itemPrice.$dirty, 'has-success': !$v.form.itemPrice.$invalid }"
                                            v-model="form.itemPrice"
                                            maxlength="40"
                                            required/>
                                </div>
                            </b-form-group>
                        </b-col>

                        <b-col>
                            <b-form-group>
                                <label for="itemSize" class="label">Item Size</label>
                                <b-form-input
                                        id="itemSize"
                                        v-model="form.itemSize"
                                        maxlength="40"/>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col>
                            <b-form-group id="imageGroup" label-for="itemImage" class="box">
                                <label class="label">Image</label>
                                <b-form-file
                                        id="itemImage"
                                        accept="image/*"
                                        v-model="form.image"
                                        placeholder="Choose an image..."
                                        @change="onImageChange"/>

                                <b-col cols="2" offset="5" style="margin-top: 1rem;">
                                    <img v-if="form.url" :src="form.url" width="200" alt="uploaded image">
                                </b-col>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group>
                                <label for="numberAvailable" class="label">Number Available</label>
                                <b-form-input
                                        id="numberAvailable"
                                        v-model="form.numberAvailable"
                                        maxlength="40"
                                        />
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col cols="2" offset="5">
                            <button 
                                type="primary" 
                                round 
                                block
                                :disabled="$v.form.$dirty"
                                @click.prevent="addItem">
                                Add Item
                            </button>
                        </b-col>
                    </b-row>    
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>

    import { validationMixin } from "vuelidate";
    import { helpers, required, minLength, maxLength, email, between } from "vuelidate/lib/validators";

    const zip = helpers.regex('zip', /(^\d{5}$)|(^\d{5}-\d{4}$)/);

    export default {

        data() {

            return {

                form: {
                    itemName: '',
                    itemDescription: '',
                    itemPrice: 0,
                    itemSize: '',
                    numberAvailable: 0,
                    image: null,
                    url: null,
                    sent: false,
                },
                
                show: true
            }
        },
         components: {
        
        },

        mixins: [
            validationMixin
        ],

        validations: {

            form: {
                itemName: {
                    required,
                    minLength: 1,
                },
                itemDescription: {
                    required,
                    minLength: 2,
                },
                itemPrice: {
                    required,
                },
                number_available: {
                    required
                },
            }
        },

        methods: {
            addItem() {

                this.$v.form.$touch();

                if (this.$v.form.$invalid) {
                    let formData = new FormData();

                    Object.keys(this.form).forEach(key => {
                        formData.append(key, this.form[key])
                    })

                    // this.$store.dispatch('formSubmit');
                    
                    axios.post("/api/items", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(({data}) => {

                        // this.$store.dispatch('formSuccess')
                        this.resetForm()

                    }).catch((error) => {

                            if (error.response.status === 400) {
                                console.log("ERROR: " + error);
                            }
                            // this.$store.dispatch('formError')
                    })
                }
            },
            resetForm() {
                /* Reset our form values */
                this.form.itemName = ''
                this.form.itemDescription = ''
                this.form.itemSize = ''
                this.form.itemPrice = null
                this.form.numberAvailable = null
                this.form.image = null
                

                /* reset/clear native browser form validation state */
                this.show = false
                this.$nextTick(() => {
                    this.show = true;
                    this.$v.$reset();
                })
            },
            hide() {
                /* reset/clear native browser form validation state */
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },

            onImageChange(e) {
                const file = e.target.files[0];
                this.form.url = URL.createObjectURL(file);
                this.form.image = file;
            },
        }

        
    }
</script>

<style lang="scss" scoped>
    .center {
        text-align: center;
    }

    .text {
        color: darkgrey;
    }
  
    .form-box {
        border: 1px solid #fd7e14;
        border-radius: 6px;
        margin: 1rem;
        padding: 1rem;
    }

    .label {
        width: 140px;
    }
    
   
</style>

