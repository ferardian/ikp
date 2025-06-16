<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class YearPicker extends Field
{
    protected string $view = 'filament.inputs.year-picker';

    protected ?string $placeholder = null;
    protected int $minYear = 1900;
    protected int $maxYear;

    protected function setUp(): void
    {
        parent::setUp();

        $this->maxYear = now()->year;
    }

    public function minYear(int $minYear): static
    {
        $this->minYear = $minYear;
        return $this;
    }

    public function maxYear(int $maxYear): static
    {
        $this->maxYear = $maxYear;
        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getMinYear(): int
    {
        return $this->minYear;
    }

    public function getMaxYear(): int
    {
        return $this->maxYear;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }
}
