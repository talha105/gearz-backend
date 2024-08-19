<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchQuery extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'search_query' => 'object',
        'response_listings' => 'array',
        'meta' => 'object',
    ];

    protected $appends = ['created_date'];



    public function getCreateDateAttribute(){
        return $this->created_at->toDateString();
    }


}
