<?php

namespace Gregwar\RST\HTML\Nodes;

use Gregwar\RST\Nodes\TocNode as Base;

class TocNode extends Base
{
    protected function renderLevel($url, $titles, $level = 1, $path = array())
    {
        if ($level > $this->depth) {
            return false;
        }

        $html = '';
        foreach ($titles as $k => $entry) {
            $path[$level-1] = $k+1;
            list($title, $childs) = $entry;
            $token = 'title.'.implode('.', $path);
            $target = $url.'#'.$token;

            if (is_array($title)) {
                list($title, $target) = $title;
                $info = $this->environment->resolve('doc', $target);
                $target = $this->environment->relativeUrl($info['url']);
            }

            $html .= '<li><a href="'.$target.'">'.$title.'</a></li>';

            if ($childs) {
                $html .= '<ul>';
                $html .= $this->renderLevel($url, $childs, $level+1, $path);
                $html .= '</ul>';
            }
        }

        return $html;
    }

    public function render()
    {
        if (isset($this->options['hidden'])) {
            return '';
        }
        $this->depth = isset($this->options['depth']) ? $this->options['depth'] : 2;

        $html = '<div class="toc"><ul>';
        foreach ($this->files as $file) {
        //global $fileList, $fileDir; 
        //foreach ($fileList as $fileName) {
        //$file=file_get_contents($fileDir.$fileName);
            $reference = $this->environment->resolve('doc', $file);
            $reference['url'] = $this->environment->relativeUrl($reference['url']);
            if (isset($reference['titles'])) $html .= $this->renderLevel($reference['url'], $reference['titles']);
            else  {
              //echo "/!\ Error reference without titles for $fileName\n<br/>";
              $html.='<li class="toctree-l1"><a class="reference internal" href="#">(unresolved table of content)</a></li>';
              $this->renderLevel($reference['url'], array($reference['title']));
            }
        }
        $html .= '</ul></div>';

        return $html;
    }
}
