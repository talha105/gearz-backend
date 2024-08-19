<template>

<div class="dashboard stats-page">

<div class="p-4">
    <div class="row">
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white" style="background-color: #FB8C00;" >
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <span class="info-box-text">New Users</span>
                    <span v-if="stats['new_users'] || stats['new_users'] == 0" class="info-box-number" style="color: #FB8C00">{{stats['new_users']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>

                </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-warning">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-user-plus"></i></span>
                    <span class="info-box-text">New Sellers</span>
                    <span v-if="stats['new_seller_requests'] || stats['new_seller_requests'] == 0" class="info-box-number text-warning">{{stats['new_seller_requests']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-danger">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-user-clock"></i></span>
                    <span class="info-box-text">Pending Sellers</span>
                    <span v-if="stats['pending_seller_requests'] || stats['pending_seller_requests'] == 0" class="info-box-number text-danger">{{stats['pending_seller_requests']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>

                </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-info">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-list"></i></span>
                    <span class="info-box-text">Total Categories</span>

                    <span v-if="stats['total_categories'] || stats['total_categories'] == 0" class="info-box-number text-info">{{stats['total_categories']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>
                </div>
                </div>
            </div>
        </div>
        
        
        

        
    </div>
    
    <div class="row row-2">
        

        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-dark">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-paste"></i></span>
                    <span class="info-box-text">New Listings</span>
                    <span v-if="stats['new_listings'] || stats['new_listings'] == 0" class="info-box-number text-dark">{{stats['new_listings']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-file-exclamation"></i></span>
                    <span class="info-box-text">Pending Listings</span>
                    <span v-if="stats['pending_listings'] || stats['pending_listings'] == 0" class="info-box-number text-secondary">{{stats['pending_listings'] }}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>

                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white bg-primary">
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-stars"></i></span>
                    <span class="info-box-text">New Reviews</span>
                    <span v-if="stats['new_reviews'] || stats['new_reviews'] == 0" class="info-box-number text-primary">{{stats['new_reviews']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>

                </div>
                </div>
            </div>
        </div>

        
        
        <div class="col-12 col-md-3 col-lg-3 col-sm-12">
            <div class="card text-white" style="background-color: #26A69A;" >
                <div class="card-body">
                <div class="info-box-content">
                    <span class="info-box-icon"><i class="fas fa-question"></i></span>
                    <span class="info-box-text">Pending Queries</span>

                    <span v-if="stats['pending_reviews'] || stats['pending_reviews'] == 0" class="info-box-number" style="color: #26A69A">{{stats['pending_queries']}}</span>
                    <b-spinner v-else type="grow" label="Spinning"></b-spinner>
                </div>
                </div>
            </div>
        </div>
        
        
        

        
    </div>
</div>

</div>

</template>

<script>
export default {
    created(){
        this.getStats()
    },
    data(){
        return{
            stats:''
        }
    },
    methods:{
        getStats(){
            axios.post('/api/admin-stats').then( res => {
                this.stats = res.data.stats;
            }).catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style>
.dashboard .info-box-icon{
    width: 50px;
    font-size: 30px;
}
.dashboard .info-box-number{
    width: 30px;
    background: white;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 30px;
    font-weight: bold;
}
.dashboard .info-box-text{
    width: 50px;
    flex-grow: 1;
}

.dashboard .info-box-content{
    display: flex;
    align-items: center;
}

.stats-page .row-2{
    margin-top: 10px !important;
}

@media screen and (max-width:768px) {
    .stats-page .col-sm-12{
        margin-top: 10px;
    }       
    .stats-page .row-2{
        margin-top: 0 !important;
    }       
}
</style>