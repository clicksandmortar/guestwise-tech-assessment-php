<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignGetRequest;
use App\Models\Brand;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CampaignGetRequest $request)
    {
        $sort_by = $request->get('sort_by') ?? 'name';
        $order_by = $request->get('order_by') === 'desc' ? 'desc' : 'asc';
        $start_date = $request->get('start_date', date('Y-m-d', strtotime('-7 days')));
        $end_date = $request->get('end_date', date('Y-m-d'));
        $brands = Brand::orderBy('name', 'asc')->get();

        $query = Campaign::select('campaigns.*', 'brands.name as brand_name')
            ->with('brand')
            ->leftJoin('brands', 'campaigns.brand_id', '=', 'brands.id')
            ->withCount([
                'impressions' => function (Builder $query) use ($start_date, $end_date, $request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('occurred_at', [$start_date, $end_date]);
                    }},
                'interactions' => function (Builder $query) use ($start_date, $end_date, $request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('occurred_at', [$start_date, $end_date]);
                    }},
                'conversions' => function (Builder $query) use ($start_date, $end_date, $request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('occurred_at', [$start_date, $end_date]);
                    }},
            ]);

        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }

        switch ($sort_by) {
            case 'brand': $query->orderBy('brand_name', $order_by); break;
            case 'conversions': $query->orderBy('conversions_count', $order_by); break;
            case 'impressions': $query->orderBy('impressions_count', $order_by); break;
            case 'interactions': $query->orderBy('interactions_count', $order_by); break;
            default: $query->orderBy('campaigns.name', $order_by); break;
        }

        $campaigns = $query->paginate();

        return view('campaigns.index', compact('campaigns', 'brands', 'sort_by', 'order_by', 'start_date', 'end_date'));
    }
}
