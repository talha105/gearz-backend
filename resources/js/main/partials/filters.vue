<template>
<div>
    <div class="filter-fixed-sm-body filters-box">
        <loader :small="false" v-if="loading"></loader>
        <div class="form-group" v-if="!loading">
            <div class="form-group">
                <div class="input-name">{{trans._getMessage('Keywords')}}</div>
                <input class="form-control" v-model="search.search" :placeholder="trans._getMessage('Search')" />
            </div>

            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose Categories')}}</div>
                <!-- dir="rtl" -->
                <v-select  :dir="dir" v-model="search.category" :placeholder="trans._getMessage('Choose Categories')" :clearable="false" :options="all_categories" @input="categoryChange" label="proper_title" >
                </v-select>
            </div>

            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose Makes')}}</div>
                <v-select :dir="dir" :disabled="!search.category"  v-model="search.make" :placeholder="trans._getMessage('Choose Makes')" @input="makeChange" :clearable="false" :options="search.category.makes" label="proper_title" >
                </v-select>
            </div>


            <div class="form-group" v-if="search.category.has_modal">
            <div class="input-name">{{trans._getMessage('Choose Models')}}</div>
                <v-select :dir="dir" :disabled="!search.make"  v-model="search.model" :placeholder="trans._getMessage('Choose Models')" :clearable="false" :options="search.make.models" label="proper_title" >
                </v-select>
            </div>
            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose Features')}}</div>
                <v-select :dir="dir" :disabled="!search.category"  v-model="search.feature" :placeholder="trans._getMessage('Choose Features')" :clearable="false" :options="search.category.features" label="proper_title" >
                </v-select>
            </div>        
            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose Genre')}}</div>
                <v-select :dir="dir"  v-model="search.genre" :placeholder="trans._getMessage('Choose Genre')" :clearable="false" label="proper_title" :options="genres" >
                </v-select>
            </div>
            
            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose City')}}</div>
                <v-select  :dir="dir" v-model="search.city" :placeholder="trans._getMessage('Select City')" :options="cities" :clearable="false" >
                </v-select>
            </div>        
            <div class="form-group">
            <div class="input-name">{{trans._getMessage('Choose Transmission')}}</div>
                <v-select  :dir="dir" v-model="search.transmission" :placeholder="trans._getMessage('Select Transmission')" :clearable="false" :options="transmissions" >
                </v-select>
            </div>        
        
        </div>
            
            
            <div class="form-group">
                <div class="input-name">{{trans._getMessage('Price')}}</div>
                <div class="min-max-area">
                    <input class="form-control" v-model="search.min_day" :placeholder="trans._getMessage('Min Day Price')" />
                    <input class="form-control" v-model="search.max_day" :placeholder="trans._getMessage('Max Day Price')" />
                </div>
                
                <div class="min-max-area mt-2">
                    <input class="form-control" v-model="search.min_month" :placeholder="trans._getMessage('Min Month Price')" />
                    <input class="form-control" v-model="search.max_month" :placeholder="trans._getMessage('Max Month Price')" />
                </div>
                <div class="min-max-area mt-4">
                    <input class="form-control" v-model="search.seats" :placeholder="trans._getMessage('Seats Capacity')" />
                    <input class="form-control" v-model="search.doors" :placeholder="trans._getMessage('Number Of Doors')" />
                </div>
            </div>

            <!-- <div class="form-group">
                <div class="input-name">Location</div>
                <input class="form-control" placeholder="Location" />
            </div> -->
    
        </div>
        
        <div class="search-footer-fixed mt-3">
            <button class="search-button" @click="$emit('searched')">
                <b-spinner class="mx-1" small v-if="searchLoading"></b-spinner>
                <i v-else class="fas fa-search mx-1"></i> 
                {{trans._getMessage('Search Now')}} </button>
            
        </div>
        
  
</div>
</template>

<script>
export default {
    data(){
        return{
            loading :false,
            dir : 'ltr',
            all_categories:[],
            categories:[],
            models:[],
            features:[],
            genres:[],
            makes:[],
            sub_categories:[],
            transmissions:[ 
                this.trans._getMessage('Automatic') , 
                this.trans._getMessage('Manual') , 
                this.trans._getMessage('Tiptronic')
                ],
            years: [ '2021' , '2020' , '2019' , '2018'],
            cities:[
                this.trans._getMessage('Abu Dhabi') , 
                this.trans._getMessage('Al Ain') , 
                this.trans._getMessage('Ajman') , 
                this.trans._getMessage('Dubai') , 
                this.trans._getMessage('Fujairah') , 
                this.trans._getMessage('Sharjah') , 
                this.trans._getMessage('Ras Al Khaimah')
            ],
        }
    },
    updated(){
        // console.log(this.$store.getters.rtl)
        // console.log(this.$store.getters.ltr)
        if(this.$store.getters.rtl){
            this.dir = 'rtl'
        }
        if(this.$store.getters.ltr){
            this.dir = 'ltr'
        }

    },
    mounted(){
        this.getListingAllCategories();
        // this.fetchAllFilterData();
    },
    methods:{
        fetchAllFilterData(){
            axios.post('/api/filters-data')
            .then( res => {
                this.categories = res.data.categories;
                this.models = res.data.models;
                this.features = res.data.features;
                this.sub_categories = res.data.sub_categories;
                this.makes = res.data.makes;
            }).catch( err => {
                console.log(err)
            })
        },

        getListingAllCategories(){
            axios.post('/api/category/all-details')
            .then( res => {
                this.all_categories = res.data.categories;
                this.genres = res.data.genres;
            }).catch(err => {
                console.log(err)
            })
        },
        categoryChange(){
            this.search.make = ''
            this.search.model = ''
        },
        makeChange(){
            this.search.model = ''
        },
    },
    props:{
        search:{

        },
        searchLoading:{

        }
    }
}
</script>

<style>
.filter-fixed-sm-body.filters-box{
    min-height: 300px;
    max-height: 100%;
    /* overflow: auto; */
    position: relative;
}
</style>