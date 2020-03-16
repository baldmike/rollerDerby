<template>
    <b-form>
        <b-form-group
            label="Item Name">
            <b-form-input
                v-model="form.itemName">
            </b-form-input>
        </b-form-group>

        <b-form-group
            label="Item Description">
            <b-form-textarea
                v-model="form.itemDescription"
                rows="3"
                max-rows="6">
            </b-form-textarea>
        </b-form-group>

        <b-form-group
            label="Item Price">
            <b-form-input>
                v-model="form.itemPrice"
                >
            </b-form-input>
        </b-form-group>


    </b-form>
</template>

<script>
export default {
    data() {
        return {
            form: {
                itemName: '',
                itemDescription: '',
                itemSize: '',
                itemPrice: null,

            }
        }
    }
}
</script>

<style>

</style>