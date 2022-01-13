<?php  

namespace App\Services\ImportService;

abstract class ImportService
{
	protected function parseFileContent()
	{
	   $content = explode(PHP_EOL, $this->fileContent);

        foreach($content as $data)
        {
            if (str_contains('[', $data) || str_contains(']', $data))
                continue;

            preg_match('/(.+)({.+})/', $data, $match);

          	return $values = json_decode($match[2], true);
        }
	}

	abstract protected function getVaildationRules();

	abstract protected function validateAndStoreData($new_values, $rules);

	protected function prepareArrayDataForValidation($array, $rules)
    {
        $new_array = [];

        foreach ($array as $key => $val)
        {
            if (array_key_exists($key, $rules))
                $new_array[$key] = $val;

            if (array_key_exists(strtolower($key), $rules))
                $new_array[strtolower($key)] = $val;

            if (!array_key_exists($key, $rules) && !array_key_exists(strtolower($key), $rules)){
                $diff = array_diff_key($rules, $new_array);
                foreach ($diff as $dKey => $dVal)
                    $new_array[$dKey] = $val;
            }
        }

        return $new_array;
        
        /*
        $neededKeys = array_keys($rules);
        return array_combine($neededKeys, $array);
        */
    }

}