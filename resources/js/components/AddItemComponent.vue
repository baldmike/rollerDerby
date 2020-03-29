<template>
    <b-container>
        <b-row>
            <b-col>
                <b-form>
                    <h6 v-if="$v.form.$dirty">Fields marked with a red <span style="color: red;">X</span> are required</h6>

                    <h2 class="center">Add a New Item to the Store</h2>

                    <b-form-group>
                        <label for="itemName" class="label">Item Name</label>
                        <b-form-input
                                id="itemName"
                                :class="{ 'has-danger': $v.form.itemName.$invalid && $v.form.itemName.$dirty, 'has-success': !$v.form.itemName.$invalid }"
                                v-model="form.itemName"
                                placeholder="Ex. Ruby Slipper"
                                maxlength="40"
                                required/>
                    </b-form-group>

                    <b-form-group>
                        <label for="itemDescription" class="label">Item Description</label>
                        <b-form-input
                                id="itemDescription"
                                :class="{ 'has-danger': $v.form.itemDescription.$invalid && $v.form.itemDescription.$dirty, 'has-success': !$v.form.itemDescription.$invalid }"
                                v-model="form.itemDescription"
                                placeholder="Description"
                                maxlength="40"
                                required/>
                    </b-form-group>

                    <b-form-group>
                        <label for="ItemPrice" class="label">Item Price</label>
                        <b-form-input
                                id="itemPrice"
                                :class="{ 'has-danger': $v.form.itemPrice.$invalid && $v.form.itemPrice.$dirty, 'has-success': !$v.form.itemPrice.$invalid }"
                                v-model="form.itemPrice"
                                placeholder="Ex. Ruby Slipper"
                                maxlength="40"
                                required/>
                    </b-form-group>

                    <b-form-group>
                        <label for="itemSize" class="label">Item Size</label>
                        <b-form-input
                                id="itemSize"
                                v-model="form.itemSize"
                                placeholder="Sm, Md, Lg, XL"
                                maxlength="40"
                                />
                    </b-form-group>

                    <b-form-group id="imageGroup" label-for="imageFinReq" class="box">
                        <label class="label">Image</label>
                        <b-form-file
                                id="imageFinReq"
                                accept="image/*"
                                v-model="form.image"
                                placeholder="Choose an image..."
                                @change="onImageChange"/>

                        <b-col cols="6" offset="3" style="margin-top: 1rem;">
                            <img v-if="url" :src="url" width="200" alt="uploaded image">
                        </b-col>
                    </b-form-group>
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
                    itemSize: null,
                    number_available: 0,
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
                itemPrice: {
                  
                },
                number_available: {
                    required
                },
            }
        },

        methods: {
            requestCarePackage() {

                this.$v.form.$touch();

                if (!this.$v.form.$invalid) {
                    let formData = new FormData();

                    Object.keys(this.form).forEach(key => {
                        formData.append(key, this.form[key])
                    })

                    this.$store.dispatch('cpFormSubmit');
                    
                    axios.post("/api/items", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(({data}) => {

                        this.$store.dispatch('cpFormSuccess')

                    }).catch((error) => {

                            if (error.response.status === 400) {
                
                            }
                            this.$store.dispatch('cpFormError')
                    })
                }
            },
            resetForm() {
                /* Reset our form values */
                this.form.itemName = ''
                this.form.itemDescription = ''
                this.form.itemSize = ''
                this.form.itemPrice = 0
                

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

            onFileChange(e) {
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

