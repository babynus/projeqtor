<?php

namespace Gregwar\RST\HTML\Directives;

use Gregwar\RST\Parser;
use Gregwar\RST\SubDirective;
use Gregwar\RST\Nodes\WrapperNode;

/**
 * Wraps a sub document in a div with a given class
 */
class Wrap extends SubDirective
{
    protected $class;
    protected $uniqid;

    public function __construct($class, $uniqid=false)
    {
        $this->class = $class;
        $this->uniqid = $uniqid;
    }

    public function getName()
    {
        return $this->class;
    }

    public function processSub(Parser $parser, $document, $variable, $data, array $options)
    {
        $class = $this->class;
        if ($this->uniqid) {
            $id = ' id="'.uniqid($this->class).'"';
        } else {
            $id = '';
        }
        $title="";
        $wrapAs=($class=='rubric')?'p':'div';
        if ($data) {
          $title='<p class="first admonition-title">'.$data.'</p>';
        } else if ($class=='note') {
          $class='admonition note';
          $title='<p class="first admonition-title">Note</p>';
        }
        
        return new WrapperNode($document, '<'.$wrapAs.' class="'.$class.'"'.$id.'>'.$title, '</'.$wrapAs.'>');
    }
}
