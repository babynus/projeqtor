<?php
defined('_JEXEC') or die;

$component = new ArtxContent($this, $this->params);
$article = $component->article('featured', $this->item, $this->item->params);

$params = $article->getArticleViewParameters();
if (strlen($article->title)) {
    $params['header-text'] = $this->escape($article->title);
    if (strlen($article->titleLink))
        $params['header-link'] = $article->titleLink;
}
// Change the order of "if" statements to change the order of article metadata header items.
if (strlen($article->created))
    $params['metadata-header-icons'][] = "<span class=\"td-postdateicon\">" . $article->createdDateInfo($article->created) . "</span>";
if (strlen($article->modified))
    $params['metadata-header-icons'][] = "<span class=\"td-postdateicon\">" . $article->modifiedDateInfo($article->modified) . "</span>";
if (strlen($article->published))
    $params['metadata-header-icons'][] = "<span class=\"td-postdateicon\">" . $article->publishedDateInfo($article->published) . "</span>";
if (strlen($article->author))
    $params['metadata-header-icons'][] = "<span class=\"td-postauthoricon\">" . $article->authorInfo($article->author, $article->authorLink) . "</span>";
if ($article->printIconVisible)
    $params['metadata-header-icons'][] = $article->printIcon();
if ($article->emailIconVisible)
    $params['metadata-header-icons'][] = $article->emailIcon();
if ($article->editIconVisible)
    $params['metadata-header-icons'][] = $article->editIcon();
if (strlen($article->hits))
    $params['metadata-header-icons'][] = $article->hitsInfo($article->hits);
// Build article content
$content = '';
if (!$article->introVisible)
    $content .= $article->event('afterDisplayTitle');
$content .= $article->event('beforeDisplayContent');
$content .= $article->intro($article->intro);
if (strlen($article->readmore))
    $content .= $article->readmore($article->readmore, $article->readmoreLink);
$content .= $article->event('afterDisplayContent');
$params['content'] = $content;
// Change the order of "if" statements to change the order of article metadata footer items.
if (strlen($article->category))
  $params['metadata-footer-icons'][] = "<span class=\"td-postcategoryicon\">"
    . $article->categories($article->parentCategory, $article->parentCategoryLink, $article->category, $article->categoryLink)
    . "</span>";
// Render article
echo $article->article($params);

