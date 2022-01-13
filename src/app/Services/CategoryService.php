<?php 

namespace App\Services;

use App\Category;


class CategoryService
{
	private $category;

	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	public function getAllCategories()
	{
		return $this->category::all();
	}

	public function storeCategory($title, $eid)
	{
		$this->category::create([
			'eid' => $eid,
			'title' => $title
		]);
	}

	public function updateCategory($category, $title, $eid)
	{
		$category->fill([
			'eid' => $eid ?? $category->eid,
			'title' => $title ?? $category->title,
		]);

		if(!$category->isClean())
			$category->saveOrFail();
	}
}