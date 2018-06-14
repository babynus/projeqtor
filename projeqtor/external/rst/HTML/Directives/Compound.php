<?php

namespace Gregwar\RST\HTML\Directives;

use Gregwar\RST\Parser;
use Gregwar\RST\SubDirective;
use Gregwar\RST\Nodes\WrapperNode;

/**
 * Divs a sub document in a div with a given class
 */
class Compound extends SubDirective
{
    public function getName()
    {
        return 'compound';
    }

    public function processSub(Parser $parser, $document, $variable, $data, array $options)
    {
      $parser = new Parser;
      $title='.. include:: ImageReplacement.txt
          
          '.$data;
      $title=$parser->parse($title);
      $title=str_replace(array('<blockquote>','</blockquote>','<p>'),array('','','<p class="compound-first">'),$title);
      return new WrapperNode($document, '<div class="compound">'.$title.'', '</div>');
    }
}
