<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SearchQuery;
use Illuminate\Http\Request;

class SearchQueryController extends Controller
{
    public function index()
    {

        try {
            $allQueries = SearchQuery::where('user_id', auth()->user()->id)
                ->whereJsonLength('search_query->search', '>', 0)
                ->whereJsonDoesntContain('search_query->search', null)
                ->latest()
                ->paginate(10);

            $queries = self::prepareSearchQueryResponse($allQueries);

            return response()->json(['success' => true, 'searches' => $queries]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wront', 'exception' => $e->getMessage()], 422);
        }
    }

    public static function prepareSearchQueryResponse($allQueries)
    {
        return $allQueries->map(function ($query) {
            return [
                'id' => $query->id,
                'search' => $query->search_query ? $query->search_query->search : '',
                'create_date' => $query->create_date,
            ];
        });
    }
}
