<?php

namespace Marshmallow\NovaUserGroups\Collections;

use Illuminate\Database\Eloquent\Collection;

class NovaResourceActionCollection extends Collection
{
    public function booleanGroupArray(): array
    {
        $options = [];
        foreach ($this->items as $item) {
            $options[(string) $item->id] = $item->description;
        }
        return $options;
    }

    public function booleanGroupDefaultSettings(): string
    {
        $options = [];
        foreach ($this->items as $item) {
            $options[$item->id] = true;
        }
        return json_encode($options);
    }
}
