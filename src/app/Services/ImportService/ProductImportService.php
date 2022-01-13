<?php

namespace App\Services\ImportService;

use App\Http\Requests\StoreProductRequest;
use App\Product;
use App\Services\ImportService\ImportService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;

class ProductImportService extends ImportService
{
	private $productService;
	public $fileContent;

	public function __construct($fileContent)
	{
		$this->fileContent = $fileContent;
		$this->productService = new ProductService(new Product());
	}

	final public function handle(): void
	{
		$parsedContent = $this->parseFileContent();
		$rules = $this->getVaildationRules();
		$new_array = $this->prepareArrayDataForValidation($parsedContent, $rules);
		$this->validateAndStoreData($new_array, $rules);
	}


	protected function getVaildationRules()
	{
		$rules = (new StoreProductRequest())->rules();

        if(isset($rules['category_ids.*']))
            unset($rules['category_ids.*']);

        return $rules;
	}

	protected function validateAndStoreData($new_values, $rules)
	{
	    $validator = Validator::make($new_values, $rules);

        if (!$validator->fails())
            $this->productService->storeProduct($new_values['title'], 
                                                    $new_values['eid'], 
                                                        $new_values['category_ids'],
                                                            $new_values['price']);
	}
}