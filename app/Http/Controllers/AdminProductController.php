<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index', ['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create'); // Zeigt das Erstellungsformular an
    }

    public function store(Request $request)
    {
        $messages = [
            'sku.required' => 'Die SKU ist erforderlich.',
            'sku.unique' => 'Diese SKU existiert bereits.',
            'sku.max' => 'Die SKU darf maximal 255 Zeichen lang sein.',
            'name.required' => 'Der Name des Produkts ist erforderlich.',
            'name.max' => 'Der Name darf maximal 255 Zeichen lang sein.',
            'price.required' => 'Der Preis ist erforderlich.',
            'price.numeric' => 'Der Preis muss eine Zahl sein.',
            'price.min' => 'Der Preis darf nicht negativ sein.',
            'tax.required' => 'Der Steuersatz ist erforderlich.',
            'tax.numeric' => 'Der Steuersatz muss eine Zahl sein.',
            'tax.min' => 'Der Steuersatz darf nicht negativ sein.',
            'image_url.required' => 'Ein Bild ist erforderlich.',
            'image_url.image' => 'Die Datei muss ein Bild sein.',
            'image_url.mimes' => 'Das Bild muss im Format JPG oder PNG sein.',
            'image_url.max' => 'Das Bild darf maximal 2 MB groß sein.',
            'description.required' => 'Die Beschreibung ist erforderlich.',
            'description.max' => 'Die Beschreibung darf maximal 255 Zeichen lang sein.',

        ];

        $validatedData = $request->validate([
            'sku' => 'required|unique:products|max:255',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'image_url' => 'required|image|max:2048',
            'description' => 'required|max:255',
        ], $messages);

        $product = new Product();
        $product->sku = $validatedData['sku'];
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->tax_rate = $validatedData['tax'];
        $product->description = $validatedData['description'];

        if ($request->hasFile('image_url')) {
            $imageName = $request->file('image_url')->getClientOriginalName();
            // Bild in public/product_image speichern
            $request->file('image_url')->move(public_path('product_image'), $imageName);

            // Nur den Bildnamen in der Datenbank speichern
            $product->image_url = $imageName;
        }
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Produkt erfolgreich erstellt');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $product = Product::find($id);
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'sku.required' => 'Die SKU ist erforderlich.',
            'sku.unique' => 'Diese SKU existiert bereits.',
            'sku.max' => 'Die SKU darf maximal 255 Zeichen lang sein.',
            'name.required' => 'Der Name des Produkts ist erforderlich.',
            'name.max' => 'Der Name darf maximal 255 Zeichen lang sein.',
            'price.required' => 'Der Preis ist erforderlich.',
            'price.numeric' => 'Der Preis muss eine Zahl sein.',
            'price.min' => 'Der Preis darf nicht negativ sein.',
            'tax.required' => 'Der Steuersatz ist erforderlich.',
            'tax.numeric' => 'Der Steuersatz muss eine Zahl sein.',
            'tax.min' => 'Der Steuersatz darf nicht negativ sein.',
            'image_url.image' => 'Die Datei muss ein Bild sein.',
            'image_url.mimes' => 'Das Bild muss im Format JPG oder PNG sein.',
            'image_url.max' => 'Das Bild darf maximal 2 MB groß sein.',
            'description.required' => 'Die Beschreibung ist erforderlich.',
            'description.max' => 'Die Beschreibung darf maximal 255 Zeichen lang sein.',
        ];

        // Validierung
        $validatedData = $request->validate([
            'sku' => 'required|max:255|unique:products,sku,' . $id,
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'image_url' => 'image|max:2048', 
            'description' => 'required|max:255',
        ], $messages);

        $product = Product::find($id);
        $product->sku = $validatedData['sku'];
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->tax_rate = $validatedData['tax'];
        $product->description = $validatedData['description'];

        // Bildverarbeitung
        if ($request->hasFile('image_url')) {
            // Optional: Vorhandenes Bild löschen
            if ($product->image_url) {
                $existingImagePath = public_path('product_image/' . $product->image_url);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath); // Lösche das alte Bild
                }
            }

            // Neuen Bildnamen generieren oder den Originalnamen verwenden
            $imageName = $request->file('image_url')->getClientOriginalName();
            // Bild in public/product_image speichern
            $request->file('image_url')->move(public_path('product_image'), $imageName);
            // Bildnamen aktualisieren
            $product->image_url = $imageName;
        }

        // Speichern der Änderungen in der Datenbank
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Produkt erfolgreich aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Produkt erfolgreich gelöscht');
    }
}
