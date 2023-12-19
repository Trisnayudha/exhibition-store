<?php

namespace App\Http\Controllers;

use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Payment;
use Illuminate\Http\Request;

class ExhibitionCartController extends Controller
{
    public function getData()
    {
        $company_id = auth()->id();

        $data = ExhibitionCartList::where('company_id', $company_id)->get();
        return response()->json(['meesage' => 'success show data', 'data' => $data]);
    }

    public function getCount()
    {
        $company_id = auth()->id();

        $data = ExhibitionCartList::where('company_id', $company_id)->get()->count();
        return response()->json(['meesage' => 'success show data', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $company_id = auth()->id();

        $save = new ExhibitionCartList();
        $save->name_product = $request->name_product;
        $save->section_product = $request->section_product;
        $save->price = $request->price;
        $save->total_price = $request->total_price;
        $save->quantity = $request->quantity;
        $save->company_id = $company_id;
        $save->delegate_id = $request->delegate_id;
        $save->save();

        return response()->json(['message' => 'insert to cart']);
    }

    public function destroyDelegate($id)
    {
        $delete = ExhibitionCartList::findOrFail($id);
        if ($delete) {
            $changeDelegate = Payment::where('id', $delete->delegate_id)->first();
            if ($changeDelegate->type == 'Exhibition Upgrade') {
                $changeDelegate->type = 'Exhibition Exhibitor';
                $changeDelegate->package = 'Exhibitor Pass';
                $changeDelegate->package_id = 70;
                $changeDelegate->event_price = 0;
                $changeDelegate->event_price_dollar = 0;
                $changeDelegate->total_price = 0;
                $changeDelegate->total_price_dollar = 0;
                $changeDelegate->save();
            } else {
                $changeDelegate->delete();
            }
            $delete->delete();
        }
        return response()->json(['message' => 'Deleted data success']);
    }
}
