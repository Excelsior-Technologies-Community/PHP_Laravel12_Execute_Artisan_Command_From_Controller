<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display products with filters, sorting and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = trim((string) $request->query('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        $category = trim((string) $request->query('category', ''));

        if ($category !== '') {
            $query->where('category', $category);
        }

        /*
        |--------------------------------------------------------------------------
        | Price Range Filter
        |--------------------------------------------------------------------------
        */

        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');

        if ($minPrice !== null && $minPrice !== '' && is_numeric($minPrice)) {
            $query->where('price', '>=', (float) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '' && is_numeric($maxPrice)) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        /*
        |--------------------------------------------------------------------------
        | Stock Range Filter
        |--------------------------------------------------------------------------
        */

        $minStock = $request->query('min_stock');
        $maxStock = $request->query('max_stock');

        if ($minStock !== null && $minStock !== '' && is_numeric($minStock)) {
            $query->where('stock', '>=', (int) $minStock);
        }

        if ($maxStock !== null && $maxStock !== '' && is_numeric($maxStock)) {
            $query->where('stock', '<=', (int) $maxStock);
        }

        /*
        |--------------------------------------------------------------------------
        | Stock Status Filter
        |--------------------------------------------------------------------------
        */

        $stockStatus = (string) $request->query('stock_status', '');

        if ($stockStatus === 'in_stock') {
            $query->where('stock', '>', 0);
        }

        if ($stockStatus === 'out_of_stock') {
            $query->where('stock', '=', 0);
        }

        if ($stockStatus === 'low_stock') {
            $query->whereBetween('stock', [1, 10]);
        }

        /*
        |--------------------------------------------------------------------------
        | ID Sorting
        |--------------------------------------------------------------------------
        */

        $sort = $request->query('sort', 'Asc');

        if (!in_array($sort, ['asc', 'Asc'], true)) {
            $sort = 'Asc';
        }

        $query->orderBy('id', $sort);

        /*
        |--------------------------------------------------------------------------
        | Dynamic Per Page
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->query('per_page', 5);

        $allowedPerPage = [
            5,
            10,
            20,
            50,
            100,
        ];

        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 5;
        }

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Product::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $totalValue = Product::selectRaw(
            'COALESCE(SUM(price * stock), 0) as total'
        )->value('total');

        $averagePrice = Product::avg('price');

        $inStockProducts = Product::where('stock', '>', 0)->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        $lowStockProducts = Product::whereBetween('stock', [1, 10])->count();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('products.index', [
            'products' => $products,

            'categories' => $categories,

            'search' => $search,
            'category' => $category,

            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,

            'minStock' => $minStock,
            'maxStock' => $maxStock,

            'stockStatus' => $stockStatus,

            'sort' => $sort,
            'perPage' => $perPage,

            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue,
            'averagePrice' => $averagePrice,

            'inStockProducts' => $inStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    /**
     * Export filtered products to CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $query = $this->filteredQuery($request);

        $filename = 'products-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | CSV Header
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'ID',
                'Name',
                'Category',
                'Price',
                'Stock',
                'Description',
                'Created At',
            ]);

            /*
            |--------------------------------------------------------------------------
            | CSV Data
            |--------------------------------------------------------------------------
            */

            $query->chunkById(500, function ($products) use ($handle) {

                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->id,
                        $product->name,
                        $product->category,
                        $product->price,
                        $product->stock,
                        $product->description,
                        optional($product->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Delete a single product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $productIds = $request->input('product_ids', []);

        if ($request->input('action') === 'delete') {

            $deleted = Product::whereIn('id', $productIds)->delete();

            return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    $deleted . ' product(s) deleted successfully.'
                );
        }

        return redirect()
            ->route('products.index')
            ->with('error', 'Invalid bulk action.');
    }

    /**
     * Build filtered product query.
     *
     * Used by index() and CSV export.
     */
    private function filteredQuery(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = trim((string) $request->query('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $category = trim((string) $request->query('category', ''));

        if ($category !== '') {
            $query->where('category', $category);
        }

        /*
        |--------------------------------------------------------------------------
        | Price
        |--------------------------------------------------------------------------
        */

        $minPrice = $request->query('min_price');

        $maxPrice = $request->query('max_price');

        if ($minPrice !== null && $minPrice !== '' && is_numeric($minPrice)) {
            $query->where('price', '>=', (float) $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '' && is_numeric($maxPrice)) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        $minStock = $request->query('min_stock');

        $maxStock = $request->query('max_stock');

        if ($minStock !== null && $minStock !== '' && is_numeric($minStock)) {
            $query->where('stock', '>=', (int) $minStock);
        }

        if ($maxStock !== null && $maxStock !== '' && is_numeric($maxStock)) {
            $query->where('stock', '<=', (int) $maxStock);
        }

        /*
        |--------------------------------------------------------------------------
        | Stock Status
        |--------------------------------------------------------------------------
        */

        $stockStatus = (string) $request->query('stock_status', '');

        if ($stockStatus === 'in_stock') {
            $query->where('stock', '>', 0);
        }

        if ($stockStatus === 'out_of_stock') {
            $query->where('stock', 0);
        }

        if ($stockStatus === 'low_stock') {
            $query->whereBetween('stock', [1, 10]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sort = $request->query('sort', 'desc');

        if (!in_array($sort, ['asc', 'desc'], true)) {
            $sort = 'desc';
        }

        $query->orderBy('id', $sort);

        return $query;
    }
}
