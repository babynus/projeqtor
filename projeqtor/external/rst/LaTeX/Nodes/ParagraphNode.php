<?php

namespace Gregwar\RST\LaTeX\Nodes;

use Gregwar\RST\Nodes\ParagraphNode as Base;

class ParagraphNode extends Base
{
    public function render()
    {
        $text = $this->value;

        if (trim($text)) {
            return $text."\n";
        } else {
            return '';
        }
    }
}
