<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $storeId = Auth::user()->store_id;
        $customers = Customer::where('store_id', $storeId)->where('is_active', true)->get();
        $categories = \App\Models\Category::where('store_id', $storeId)->where('is_active', true)->get();
        
        return view('pos.index', compact('customers', 'categories'));
    }

    public function searchProducts(Request $request)
    {
        $storeId = Auth::user()->store_id;
        $search = $request->get('search', '');
        $categoryId = $request->get('category_id');

        $query = Product::where('store_id', $storeId)
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->with('category')->take(20)->get();

        return response()->json($products);
    }

    public function processSale(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:cash,card,transfer,other',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500'
        ]);

        $storeId = Auth::user()->store_id;
        $userId = Auth::id();

        DB::beginTransaction();
        
        try {
            $subtotal = 0;
            $saleItems = [];

            // Validate stock and calculate totals
            foreach ($request->items as $item) {
                $product = Product::where('store_id', $storeId)
                    ->where('id', $item['product_id'])
                    ->where('is_active', true)
                    ->first();

                if (!$product) {
                    throw new \Exception("Product not found or inactive.");
                }

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $itemTotal = $product->selling_price * $item['quantity'];
                $subtotal += $itemTotal;

                $saleItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->selling_price,
                    'total_price' => $itemTotal
                ];
            }

            $taxAmount = 0; // You can add tax calculation here
            $discountAmount = 0; // You can add discount logic here
            $totalAmount = $subtotal + $taxAmount - $discountAmount;
            $changeAmount = max(0, $request->paid_amount - $totalAmount);

            if ($request->paid_amount < $totalAmount) {
                throw new \Exception("Paid amount is insufficient.");
            }

            // Create sale record
            $sale = Sale::create([
                'store_id' => $storeId,
                'user_id' => $userId,
                'customer_id' => $request->customer_id,
                'invoice_number' => Sale::generateInvoiceNumber($storeId),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes
            ]);

            // Create sale items and update stock
            foreach ($saleItems as $saleItem) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $saleItem['product']->id,
                    'quantity' => $saleItem['quantity'],
                    'unit_price' => $saleItem['unit_price'],
                    'total_price' => $saleItem['total_price']
                ]);

                // Update product stock
                $saleItem['product']->decrement('stock_quantity', $saleItem['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully!',
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
                'total_amount' => $totalAmount,
                'change_amount' => $changeAmount
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
