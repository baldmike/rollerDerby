<template>
    <b-container>
        <b-row>
            <b-col cols="12">
                <b-form action="">
                    <h6 class="center" v-if="$v.form.$dirty">Fields marked with a red <span style="color: red;">X</span> are required</h6>

                    <b-form-group>
                        <label for="itemName">Item Name</label>
                        <input
                                id="itemName"
                                :class="{ 'has-danger': $v.form.itemName.$invalid && $v.form.itemName.$dirty, 'has-success': !$v.form.itemName.$invalid }"
                                v-model="form.itemName"
                                placeholder="Ex. Ruby Slipper"
                                maxlength="40"
                                required/>
                    </b-form-group>

                    <b-form-group>
                        <label for="itemDescription">Item Description</label>
                        <input
                                id="itemDescription"
                                :class="{ 'has-danger': $v.form.itemDescription.$invalid && $v.form.itemDescription.$dirty, 'has-success': !$v.form.itemDescription.$invalid }"
                                v-model="form.itemDescription"
                                placeholder="Ex. Ruby Slipper"
                                maxlength="40"
                                required/>
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
                    
                    axios.post("/api/care_pkgs", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(({data}) => {

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
                this.form.firstName = ''
                this.form.lastName = ''
                this.form.email = ''
                this.form.address1 = ''
                this.form.address2 = ''
                this.form.city = ''
                this.form.state = ''
                this.form.zip = ''
                this.form.itemName = ''
                this.form.about = '' 
                this.form.diagnosis = ''
                this.form.image = ''

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
    
   
</style>

