<?php

namespace App\Http\Controllers\Owner;

use App\DataTables\RentedHousesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use Mews\Purifier\Facades\Purifier;
use App\Models\Review;
use App\Models\User;
use App\DataTables\HousesDataTable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\HistoryTrait;

class HouseController extends Controller
{
    use HistoryTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(HousesDataTable $dataTable)
    {

        $pageTitle = __('message.house.managment');
        $title = __('message.house.0');
        $columns = $dataTable->getViewColumns();
        $button = isOwner() ? '<a href="' . route('owner.addHouse') . '" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i>' . __('message.add_new', ['form' => $title]) . '</a>' : '';

        return $dataTable->render('common.tables', compact(['columns', 'title', 'pageTitle', 'button']));

    }

    public function rented(RentedHousesDataTable $dataTable)
    {

        $pageTitle = __('message.house.rented_managment');
        $title = __('message.house.0');
        $columns = $dataTable->getViewColumns();
        $button = isOwner() ? '<a href="' . route('owner.addHouse') . '" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i> ' . __('message.add_new', ['form' => $title]) . '</a>' : '';
        return $dataTable->render('common.tables', compact(['columns', 'title', 'pageTitle', 'button']));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = __('message.add_house');
        $tenants = User::where('role', USER_ROLE_TENANT)
            ->where(function ($query) {
                $query->whereHas('sentMessages', function ($q) {
                    $q->where('receiver_id', auth()->id());
                })
                    ->orWhereHas('receivedMessages', function ($q) {
                        $q->where('sender_id', auth()->id());
                    });
            })
            ->get();
        return view('owner.add-house', compact(['pageTitle', 'tenants']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Assuming this is the title
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rooms' => 'required|integer|min:1',
            'area' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'privateNotes' => 'nullable|string',
            'payment_date' => 'nullable|string',
            'renter_email' => 'nullable|email',
        ]);

        $amenities = [
            'tapWater' => $request->has('tapWater'),
            'kitchen' => $request->has('kitchen'),
            'acceptMarried' => $request->has('acceptMarried'),
            'hasDog' => $request->has('hasDog'),
        ];
        $tenant_id = null;
        if ($request->has('renter_email') && isset($request->renter_email)) {
            $tennt = User::where('email', $request->renter_email)->first();
            if (!$tennt) {
                return back()->with("error", __("message.invalid", ["form" => __("message.email")]));
            }
            $tenant_id = $tennt->id;
            unset($tennt);
        }
        // 
        $visitor_id = null;
        if ($request->has('visitor_email') && isset($request->visitor_email)) {
            $tennt = User::where('email', $request->visitor_email)->first();
            if (!$tennt) {
                return back()->with("error", __("message.invalid", ["form" => __("message.email")]));
            }
            $visitor_id = $tennt->id;
        }

        $cleanDescription = Purifier::clean($request->input('description'));
        // // Create the house record
        $house = House::create([
            'owner_id' => auth()->user()->id,
            'name' => $request->name, // Assuming this is the title
            'address' => $request->address,
            'payment_date' => $request->payment_date,
            'description' => $cleanDescription,
            'rooms' => $request->rooms,
            'area' => $request->area,
            'price' => $request->price,
            'amenities' => $amenities,
            'tenant_id' => $tenant_id,
            'privateNotes' => $request->privateNotes,
            'rented' => ($request->has('rented') ? 1 : 0),
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        $this->recordHistory(ADDED, auth()->user()->id, $house->id);
        if ($tenant_id != null) {
            $this->recordHistory(RENTED, $tenant_id, $house->id);
        }

        if ($visitor_id != null) {

            if (
                $house->histories() == null ||
                !optional($house->histories())
                    ->where('user_id', $visitor_id)
                    ->where('type', VISITED)
                    ->exists()
            ) {

                $this->recordHistory(VISITED, $visitor_id, $house->id);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $house->addMedia($image)
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route(userPrefix() . '.allHouse')->with('success', __('message.saved', ['form' => __('message.house.0')]));
    }


    /**
     * Display the specified resource.
     */
    public function show($r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($r)
    {
        $house = House::find($r);
        if (!$house) {
            return back()->with('error', __('message.no_data'));
        }
        if ($house->owner_id != auth()->id()) {
            return back()->with('error', __('message.action_forbidden'));
        }
        $pageTitle = __('message.house.edit');

        $tenants = User::where('role', USER_ROLE_TENANT)
            ->where(function ($query) {
                $query->whereHas('sentMessages', function ($q) {
                    $q->where('receiver_id', auth()->id());
                })
                    ->orWhereHas('receivedMessages', function ($q) {
                        $q->where('sender_id', auth()->id());
                    });
            })
            ->get();
        $tenant = User::where('role', USER_ROLE_TENANT) // Assuming you have a 'role' column
            ->where(function ($query) {
                $query->whereHas('sentMessages', function ($q) {
                    $q->where('receiver_id', auth()->id());
                })
                    ->orWhereHas('receivedMessages', function ($q) {
                        $q->where('sender_id', auth()->id());
                    });
            })
            ->get();
        return view('owner.add-house', compact(['pageTitle', 'house', 'tenant', 'tenants']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $r)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Assuming this is the title
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rooms' => 'required|integer|min:1',
            'area' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'privateNotes' => 'nullable|string',
            'payment_date' => 'nullable|string',
            'renter_email' => 'nullable|email',
        ]);

        $amenities = [
            'tapWater' => $request->has('tapWater'),
            'kitchen' => $request->has('kitchen'),
            'acceptMarried' => $request->has('acceptMarried'),
            'hasDog' => $request->has('hasDog'),
        ];
        $tenant_id = null;
        if ($request->has('renter_email') && isset($request->renter_email)) {
            $tennt = User::where('email', $request->renter_email)->first();
            if (!$tennt) {
                return back()->with("error", __("message.invalid", ["form" => __("message.email")]));
            }
            $tenant_id = $tennt->id;
            unset($tennt);
        }

        $visitor_id = null;
        if ($request->has('visitor_email') && isset($request->visitor_email)) {
            $visitor = User::where('email', $request->visitor_email)->first();
            if (!$visitor) {
                return back()->with("error", __("message.invalid", ["form" => __("message.email")]));
            }
            $visitor_id = $visitor->id;

        }

        $cleanDescription = Purifier::clean($request->input('description'));
        $house = House::findOrFail($r);
        $previousTenant = $house->tenant_id;
        $house->update([
            'name' => $request->name, // Assuming this is the title
            'address' => $request->address,
            'payment_date' => $request->payment_date,
            'description' => $cleanDescription,
            'rooms' => $request->rooms,
            'area' => $request->area,
            'price' => $request->price,
            'amenities' => $amenities,
            'tenant_id' => $tenant_id,
            'privateNotes' => $request->privateNotes,
            'rented' => ($request->has('rented') ? 1 : 0),
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);
        if (($previousTenant != null && $tenant_id == null) || ($previousTenant != null && $tenant_id != $previousTenant)) {
            $this->recordHistory(RELEASED, $previousTenant, $house->id);
        }
        if (($previousTenant != null && $tenant_id != $previousTenant && $tenant_id!=null ) || ($previousTenant == null && $tenant_id != null)) {
            $this->recordHistory(RENTED, $tenant_id, $house->id);
        }

         if ($visitor_id != null) {

            if (
                $house->histories() == null ||
                !optional($house->histories())
                    ->where('user_id', $visitor_id)
                    ->where('type', VISITED)
                    ->exists()
            ) {

                $this->recordHistory(VISITED, $visitor_id, $house->id);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $house->addMedia($image)
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('owner.allHouse')->with('success', __('message.house.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!(isAdmin() || isOwner())) {
            return response()->json(['success' => false, 'message' => __('message.action_forbidden')], 403);
        }
        $house = House::withTrashed()->findOrFail($id);

        if (!$house) {
            response()->json(['success' => false, 'message' => __('message.not_found')], 404);
        }
        if (($house->owner_id != auth()->id() && isOwner())) {
            return response()->json(['success' => false, 'message' => __('message.action_forbidden')], 403);
        }
        if ($house->deleted_at != null) {
            $house->forceDelete();
        } else {
            $this->recordHistory(REMOVED, auth()->id(), $house->id);
            $house->delete();
        }

        return response()->json(['success' => true,], );
    }


    public function restore($id)
    {
        if (!(isAdmin() || isOwner())) {
            return response()->json(['success' => false, 'message' => __('message.action_forbidden')], 403);
        }
        $house = House::withTrashed()->findOrFail($id);

        if (!$house) {
            response()->json(['success' => false, 'message' => __('message.not_found')], 404);
        }
        if (($house->owner_id != auth()->id() && isOwner())) {
            return response()->json(['success' => false, 'message' => __('message.action_forbidden')], 403);
        }
        if ($house->deleted_at == null) {
            return response()->json(['success' => false, 'message' => __('message.action_forbidden')], 403);
        } else {
            $house->restore();
        }

        return response()->json(['success' => true,], );
    }


    public function storeRating(Request $request)
    {
        if (!isTenant()) {
            return back(404)->with('error', 'message.action_forbidden!');
        }
        $house = House::findOrFail($request->id);//->with('reviews');
        $userhasrated = false;
        foreach ($house->reviews as $review) {
            if ($review->tenant_id == auth()->user()->id) {
                $userhasrated = true;
            }
        }
        if ($userhasrated) {
            return back(403)->with('error', 'message.action_forbidden!');
        }
        Review::create([
            'house_id' => $request->id,
            'tenant_id' => auth()->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'had_visit' => '0',
        ]);

        return back()->with('success', __('message.house.rated'));
    }

    public function deleteMedia(Request $request)
    {
        $validated = $request->validate([
            'media_id' => 'required|integer',
            'house_id' => 'required|integer',
        ]);

        $media = Media::where('model_id', $request->house_id)
            ->where('model_type', House::class)
            ->findOrFail($request->media_id);

        $media->delete();

        return response()->json(['success' => true]);
    }


}
