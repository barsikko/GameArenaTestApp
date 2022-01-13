<?php  

namespace App\Services;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
	private $product;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	public function getAllProducts()
	{
		return $this->product::with('categories')->get();
	}

	public function storeProduct(string $title, int $eid, array $category_ids, float $price): void
	{
		DB::transaction(function() use($title, $eid, $category_ids, $price) {

			$product = $this->product::create([
				'eid' => $eid,
				'price' => $price,
				'title' => $title
			]);

			$product->categories()->attach($category_ids);

			event(new ProductCreated($product));
		});
	}

	public function updateProduct(Product $product, ?string $title, ?int $eid, ?array $category_ids, ?float $price): void
	{
		$product->fill([
			'eid' => $eid ?? $product->eid,
			'price' => $price ?? $product->price,
			'title' => $title ?? $product->title,
		]);

		DB::transaction(function() use($product, $category_ids) {

			if(!$product->isClean())
				$product->saveOrFail();

			$product->categories()->sync($category_ids);

			event(new ProductUpdated($product));
		});
	}

}