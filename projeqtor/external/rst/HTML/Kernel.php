<?php

namespace Gregwar\RST\HTML;

use Gregwar\RST\Kernel as Base;

class Kernel extends Base
{
    public function getName()
    {
        return 'HTML';
    }

    public function getDirectives()
    {
        $directives = parent::getDirectives();

        $directives = array_merge($directives, array(
            new Directives\Image,
            new Directives\Figure,
            new Directives\Meta,
            new Directives\Stylesheet,
            new Directives\Title,
            new Directives\Url,
            new Directives\Div,
            new Directives\Wrap('note'),
            new Directives\Wrap('topic'),
            new Directives\Wrap('rubric'),
            new Directives\Wrap('sidebar'),
        ));

        return $directives;
    }

    public function getFileExtension()
    {
        return 'html';
    }
}
