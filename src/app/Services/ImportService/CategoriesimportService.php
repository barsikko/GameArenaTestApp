<?php 

namespace App\Services\ImportService;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;


class CategoriesimportService extends ImportService
{
	private $categoryService;
	public $fileContent;

	public function __construct($fileContent)
	{
		$this->fileContent = $fileContent;
		$this->categoryService = new CategoryService(new Category());
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
		$rules = (new StoreCategoryRequest())->rules();

        return $rules;
	}

	protected function validateAndStoreData($new_values, $rules)
	{
	    $validator = Validator::make($new_values, $rules);

        if (!$validator->fails())
            $this->categoryService->storeCategory($new_values['title'], $new_values['eid']);
	}
}