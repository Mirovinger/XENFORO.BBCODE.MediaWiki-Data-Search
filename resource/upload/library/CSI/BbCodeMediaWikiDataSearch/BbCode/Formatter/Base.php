<?php namespace CSI\BbCodeMediaWikiDataSearch\BbCode\Formatter;

/**
 * Class Base
 * @package CSI\BbCodeMediaWikiDataSearch\BbCode\Formatter
 */
class Base
{
  /**
   * @param array $tag
   * @param array $rendererStates
   * @param \XenForo_BbCode_Formatter_Base $formatter
   * @return mixed
   */
  public static function getBbCodeMediaWikiDataSearch(array $tag, array $rendererStates, \XenForo_BbCode_Formatter_Base $formatter)
  {
    $xenOptions = \XenForo_Application::get('options');
    $xenVisitor = \XenForo_Visitor::getInstance();
    $tagOption = array_map('trim', explode('|', $tag['option']));

    if (count($tagOption) > 1) {
      $optDefault = $tagOption[0];
    } else {
      $optDefault = $tag['option'];
    }

    $tagContent = $formatter->renderSubTree($tag['children'], $rendererStates);
    $tagQuery = rawurlencode($tagContent);

    if (!$xenOptions->csiXF_bbCode_A697E3E0_onoff || !$xenOptions->csiXF_bbCode_A697E3E0_urlIndex) {
      return $formatter->renderInvalidTag($tag, $rendererStates);
    }

    $view = $formatter->getView();

    if ($view) {
      $template = $view->createTemplateObject('csiXF_bbCode_A697E3E0_tag_wiki_search',
        array(
          'content' => $tagContent,
          'query' => $tagQuery,
        ));

      $tagContent = $template->render();
      return trim($tagContent);
    }

    return $tagContent;
  }
}
