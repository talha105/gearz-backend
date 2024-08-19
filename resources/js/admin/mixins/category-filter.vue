
<script>
export default {

    data(){
        return {
            selectedGenres: [],
            selectedCategories: [],
            selectedSubCategories: [],
            selectedSubSubCategories: [],
            selectedMakes: [],
            selectedModels: [],
            selectedVariants: [],
        }
    },

    watch:{
        selectedGenres() {
            this.getIdsAndEmit("genres-changed", this.selectedGenres);
        },
        selectedCategories() {
            this.getIdsAndEmit("categories-changed", this.selectedCategories);
        },
        selectedSubCategories() {
            this.getIdsAndEmit(
                "sub-categories-changed",
                this.selectedSubCategories
            );
        },
        selectedSubSubCategories() {
            this.getIdsAndEmit(
                "sub-sub-categories-changed",
                this.selectedSubSubCategories
            );
        },
        selectedMakes() {
            this.getIdsAndEmit("makes-changed", this.selectedMakes);
        },
        selectedModels() {
            this.getIdsAndEmit("models-changed", this.selectedModels);
        },
        selectedVariants() {
            this.getIdsAndEmit("variants-changed", this.selectedVariants);
        }
    },

    computed: {
        theGenres() {
            let genreIds = this.selectedGenres.map(genre => genre.id);
            return this.genres.filter(genre => !genreIds.includes(genre.id));
        },
        theCategories() {
            return this.filterSelectedOptions(
                this.categories,
                this.selectedCategories
            );
        },
        theSubCategories() {
            let subCategories = [];
            this.selectedCategories.map(category =>
                subCategories.push(...category.sub_categories)
            );
            subCategories = this.filterSelectedOptions(
                subCategories,
                this.selectedSubCategories
            );

            this.removeUnselectedOptions(
                this.selectedCategories,
                "selectedSubCategories",
                "sub_categories"
            );
            return subCategories;
        },
        theSubSubCategories() {
            let subSubCategories = [];
            this.selectedSubCategories.map(subCategory =>
                subSubCategories.push(...subCategory.sub_categories)
            );
            subSubCategories = this.filterSelectedOptions(
                subSubCategories,
                this.selectedSubSubCategories
            );

            this.removeUnselectedOptions(
                this.selectedSubCategories,
                "selectedSubSubCategories",
                "sub_categories"
            );

            return subSubCategories;
        },
        theModels() {
            let models = [];
            this.selectedMakes.map(make => models.push(...make.models));
            models = this.filterSelectedOptions(models, this.selectedModels);
            this.removeUnselectedOptions(
                this.selectedMakes,
                "selectedModels",
                "models"
            );
            var genreIds = this.selectedGenres.map( item => item.id)
            models = models.filter( item => genreIds.includes(parseInt(item.genre_id)) )
            return models;
        },
        theVariants() {
            let variants = [];
            this.selectedModels.map(model => variants.push(...model.variants));
            variants = this.filterSelectedOptions(variants, this.selectedVariants);
            this.removeUnselectedOptions(
                this.selectedModels,
                "selectedVariants",
                "variants"
            );
            return variants;
        }
    },


    methods:{

                removeUnselectedOptions(
            selectedParents,
            selectedChildren,
            key = "sub_categories"
        ) {
            let children = [];
            selectedParents.map(item => children.push(...item[key]));
            let childrenIds = children.map(item => item.id);
            if (this[selectedChildren] && this[selectedChildren].length) {
                this[selectedChildren] = this[selectedChildren].filter(item =>
                    childrenIds.includes(item.id)
                );
            }
        },
        filterSelectedOptions(array, items) {
            if (array && array.length && items && items.length) {
                let selectedIds = items.map(item => item.id);
                const filtered = array.filter(
                    item => !selectedIds.includes(item.id)
                );
                return filtered;
            }
            return array || [];
        },
        getIdsAndEmit(eventName, array) {
            if (array && array.length) {
                let itemsIds = array.map(genres => genres.id);
                this.$emit(eventName, itemsIds);
            }
        }


    }
}
</script>
