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

        $data = ExhibitionCartList::where('company_id', $company_id)->whereNull('payment_id')->get();
        return response()->json(['meesage' => 'success show data', 'data' => $data]);
    }

    public function getCount()
    {
        $company_id = auth()->id();

        $data = ExhibitionCartList::where('company_id', $company_id)->whereNull('payment_id')->get()->count();
        return response()->json(['meesage' => 'success show data', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $company_id = auth()->id();

        $save = ExhibitionCartList::where('delegate_id', $request->delegate_id)->first();
        if (empty($save)) {
            $save = new ExhibitionCartList();
        }
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

    public function storeExhibition(Request $request)
    {
        $company_id = auth()->id();

        $save = ExhibitionCartList::where('name_product', $request->name_product)->where('company_id', $company_id)->first();

        if (empty($save)) {
            $save = new ExhibitionCartList();
            $save->quantity = $request->quantity; // Set quantity to 1 for a new entry
            $save->total_price = $request->price; // Set total_price based on the initial quantity
        } else {
            $save->quantity = $save->quantity + 1; // Increment quantity by 1 for an existing entry
            $save->total_price = $request->price * $save->quantity; // Recalculate total_price
        }

        $save->name_product = $request->name_product;
        $save->section_product = $request->section_product;
        $save->price = $request->price;
        $save->company_id = $company_id;
        $save->image = $request->image;
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

    public function destroyExhibition($id)
    {
        $delete = ExhibitionCartList::findOrFail($id);
        if ($delete) {
            $delete->delete();
        }
        return response()->json(['message' => 'Deleted data success']);
    }

    public function changeQuantity(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $save = ExhibitionCartList::findOrFail($id);
        $save->quantity = $save->quantity + $quantity; // Perbaikan di sini
        $save->total_price = $save->price * $save->quantity; // Recalculate total_price
        $save->save();
        return response()->json(['message' => 'Success change quantity', 'save' => $save]);
    }
}
