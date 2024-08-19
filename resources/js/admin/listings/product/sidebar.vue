<template>
    <div>
        <div class="">
            <label class="col-form-label">City:</label>
            <v-select
                @input="$emit('city-changed', $event)"
                placeholder="Select City"
                :options="cities"
                v-model="city"
                :clearable="false"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Genre:</label>
            <v-select
                v-model="selectedGenres"
                placeholder="Select Genre"
                :options="theGenres"
                label="title"
                :clearable="false"
                multiple
                class="muliple-select"
                :closeOnSelect="false"
                :deselectFromDropdown="true"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Categories:</label>
            <v-select
                v-model="selectedCategories"
                placeholder="Select Categories"
                :options="theCategories"
                label="title"
                :clearable="false"
                multiple
                class="muliple-select"
                :closeOnSelect="false"
                :deselectFromDropdown="true"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Sub Categoy:</label>
            <v-select
                multiple
                v-model="selectedSubCategories"
                placeholder="Select Sub Category"
                :disabled="selectedCategories.length ? false : true"
                :options="theSubCategories"
                :clearable="false"
                class="muliple-select"
                label="title"
                :closeOnSelect="false"
                :deselectFromDropdown="true"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Sub Sub Categoy:</label>
            <v-select
                multiple
                v-model="selectedSubSubCategories"
                :options="theSubSubCategories"
                placeholder="Select Sub Sub Category"
                :disabled="theSubSubCategories.length ? false : true"
                :clearable="false"
                class="muliple-select"
                label="title"
                :closeOnSelect="false"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Make:</label>
            <v-select
                v-model="selectedMakes"
                placeholder="Select Make"
                :options="filterSelectedOptions(makes, selectedMakes)"
                class="muliple-select"
                multiple
                :clearable="false"
                label="title"
                :closeOnSelect="false"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Model:</label>
            <v-select
                class="muliple-select"
                v-model="selectedModels"
                multiple
                :disabled="selectedMakes.length == 0"
                placeholder="Select Model"
                :clearable="false"
                label="title"
                :closeOnSelect="false"
                :deselectFromDropdown="true"
                :options="theModels"
            ></v-select>
        </div>

        <div class="">
            <label class="col-form-label">Variants:</label>
            <v-select
                class="muliple-select"
                v-model="selectedVariants"
                multiple
                :disabled="selectedModels.length == 0"
                placeholder="Select Variants"
                :clearable="false"
                label="title"
                :closeOnSelect="false"
                :deselectFromDropdown="true"
                :options="theVariants"
            ></v-select>
        </div>

        <!-- <div class="">
            <label class="col-form-label">Years:</label>
            <div class="d-flex">
                <v-select
                    @input="$emit('start-year', $event)"
                    :clearable="false"
                    class="me-2"
                    placeholder="Select Year"
                    :options="$root.yearList"
                    v-model="startYear"
                >
                </v-select>

                <v-select
                    @input="$emit('end-year', $event)"
                    :clearable="false"
                    placeholder="Select Year"
                    :options="$root.yearList"
                    v-model="endYear"
                >
                </v-select>
            </div>
        </div> -->

        <div class="">
            <label class="col-form-label">Pricing Starts from:</label>
            <input
                @input="$emit('price-changed', $event.target.value)"
                class="form-control"
                v-model="price"
                placeholder="Pricing Starts from"
            />
        </div>

        <div class="">
            <label class="col-form-label">Seller:</label>
            <v-select
                @input="$emit('seller-changed', $event)"
                placeholder="Select Seller"
                :options="sellers"
                class="muliple-select"
                label="name"
                v-model="seller"
            ></v-select>
        </div>
    </div>
</template>

<script>
import categoryFilterVue from '../../mixins/category-filter.vue';

export default {
    props: {
        ad: {
            type: Object,
            default: () => {}
        }
    },
    mixins:[categoryFilterVue],
    data() {
        return {
            categories: [],
            makes: [],
            genres: [],
            utilities: [],
            sellers: [],

            seller: "",
            startYear: "",
            endYear: "",
            price: "",
            city: "",
            cities: [
                "Abu Dhabi",
                "Al Ain",
                "Ajman",
                "Dubai",
                "Fujairah",
                "Sharjah",
                "Ras Al Khaimah"
            ]
        };
    },
    mounted() {
        this.getCategories();
        this.getAllSellers();
    },
    watch: {
        ad: {
            handler(oldValue, newValue) {
                this.city = this.ad.city
                this.price = this.ad.price
                this.startYear = this.ad.start_year
                this.endYear = this.ad.end_year
                this.seller = this.ad.seller
                if (this.ad && this.ad.id && oldValue !== newValue) {
                    this.setCurrentValues()
                }
            },
            deep: true
        },
    },
    methods: {
        setIdsInSelects(ids, array) {
            return array.filter(item => ids.includes(item.id));
        },
        getCategories() {
            axios
            .post("/api/category/all-details")
            .then(res => {
                this.categories = res.data.categories;
                this.makes = res.data.makes;
                this.genres = res.data.genres;
                this.utilities = res.data.utilities;
                if(this.ad){
                    this.setCurrentValues()
                }
            })
            .catch(err => {
                console.log(err);
            });
        },
        getAllSellers() {
            axios
            .get("/api/get-sellers-list")
            .then(res => {
                this.sellers = res.data.sellers;
            })
            .catch(err => {
                console.log(err);
            });
        },
        setCurrentValues(){
            this.selectedCategories = this.setIdsInSelects(
                this.ad.categories,
                this.categories
            );
            this.selectedSubCategories = this.setIdsInSelects(
                this.ad.subCategories,
                this.theSubCategories
            );
            this.selectedSubSubCategories = this.setIdsInSelects(
                this.ad.subSubCategories,
                this.theSubSubCategories
            );
            this.selectedGenres = this.setIdsInSelects(
                this.ad.genres,
                this.theGenres
            );
            this.selectedMakes = this.setIdsInSelects(
                this.ad.makes,
                this.makes
            );
            this.selectedModels = this.setIdsInSelects(
                this.ad.models,
                this.theModels
            );
            this.selectedVariants = this.setIdsInSelects(
                this.ad.variants,
                this.theVariants
            );

        }

    }
};
</script>

<style></style>
