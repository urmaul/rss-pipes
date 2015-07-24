<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

class Block extends Section
{
    public $rules = [];
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        foreach ($this->rules as $field => $rules) {
            if (is_string($rules))
                $rules = [$rules];
            
            $feed->items = array_filter($feed->items, function (Item $item) use ($field, $rules) {
                return !$this->matchRules($item->$field, $rules);
            });
        }
    }
    
    /**
	 * @property boolean $and - rules connecting operation
	 * When true - using "and" rule. Return false if one not match or
	 * true when all of them match.
	 * When false - using "or" rule. Return true if one of them match or
	 * false when no one of them match.
	 * @return boolean
	 */
	protected function matchRules($string, $rules, $and = false)
	{
		foreach ($rules as $rule) {
			$match = is_string($rule)
                ? $this->matchRule($string, $rule)
				: $this->matchRules($string, $rule, !$and);
			
			if ($and xor $match)
				return !$and;
		}
		
		return $and;
	}
    
    /**
	 * @return boolean
	 */
	protected function matchRule($string, $rule)
	{
		return mb_stripos($string, $rule) !== false;
	}
}
