<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 *  Website: https://laraclassifier.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Api\Post\Traits;

use App\Helpers\VideoEmbedding;
use App\Models\CategoryField;
use App\Models\FieldOption;

trait ShowFieldValueTrait
{
	/**
	 * Get Post's Custom Fields Values
	 *
	 * Note: Called when displaying the Post's details
	 *
	 * @param $categoryId
	 * @param $postId
	 * @return array
	 * @throws \Exception
	 */
	public function getFieldsValues($categoryId, $postId): array
	{
		// Get the Post's Custom Fields by its Parent Category
		$customFields = CategoryField::getFields($categoryId, $postId);
		
		// Get the Post's Custom Fields that have a value
		$postValues = [];
		if ($customFields->count() > 0) {
			foreach ($customFields as $key => $field) {
				if (empty($field->default_value)) {
					continue;
				}
				
				if (in_array($field->type, ['radio', 'select'])) {
					if (is_numeric($field->default_value)) {
						$option = FieldOption::find($field->default_value);
						if (!empty($option)) {
							$field->default_value = $option->value;
						}
					}
				}
				
				if (!is_array($field->default_value)) {
					if ($field->type == 'checkbox') {
						$field->default_value = ($field->default_value == 1) ? t('Yes') : t('No');
					}
					
					if ($field->type == 'video') {
						$field->default_value = VideoEmbedding::embedVideo($field->default_value);
					}
					
					if ($field->type == 'file') {
						$field->default_value = privateFileUrl($field->default_value, null);
					}
					
					if ($field->type == 'url') {
						$field->default_value = addHttp($field->default_value);
					}
				}
				
				$postValues[$key] = $field;
			}
		}
		
		// Get Result's Data
		return collect($postValues)->toArray();
	}
}
