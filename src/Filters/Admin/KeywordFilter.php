<?php

namespace Otas\DynamicPages\Filters\Admin;

use Otas\Filterable\Helpers\QueryFilter;

class KeywordFilter extends QueryFilter
{
    /**
     * Filter by visible keywords only.
     */
    public function visible($visible = 'yes')
    {
        return \in_array($visible, \array_keys($this->availableBooleanValues)) ? $this->builder->visible($this->availableBooleanValues[$visible]) : $this->builder;
    }
}
