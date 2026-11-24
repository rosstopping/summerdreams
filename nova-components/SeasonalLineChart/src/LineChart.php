<?php

namespace Digizu\SeasonalLineChart;

use Laravel\Nova\Card;

class LineChart extends Card
{
    public $width = 'full';

    public function component(): string
    {
        return 'seasonal-line-chart';
    }

    public function title(string $title): static
    {
        return $this->withMeta(['title' => $title]);
    }

    public function series(array $series): static
    {
        return $this->withMeta(['series' => $series]);
    }

    public function options(array $options): static
    {
        return $this->withMeta(['options' => $options]);
    }

    public function animations(array $animations): static
    {
        return $this->withMeta(['animations' => $animations]);
    }
}
