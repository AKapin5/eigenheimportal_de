<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginateRoute extends \MichalOravec\PaginateRoute\PaginateRoute
{
    public function renderPageList(LengthAwarePaginator $paginator, $full = false, $class = null, $additionalLinks = false)
    {
        $urls = $this->allUrls($paginator, $full);

        if ($class) {
            $class = " class=\"$class\"";
        }

        $listItems = "<ul{$class}>";

        if ($this->hasPreviousPage() && $additionalLinks) {
            $listItems .= "<li><a href=\"{$this->previousPageUrl()}\">&laquo;</a></li>";
        }

        foreach ($urls as $i => $url) {
            $pageNum = $i + 1;

            $css = '';

            $isActive = $pageNum == $this->currentPage();

            if ($isActive) {
                $css = ' class="active"';
            }

            $listItems .= "<li{$css}>"
                . ($isActive ?  "<span>{$pageNum}</span>" : "<a href=\"{$url}\">{$pageNum}</a>")
                . "</li>";
        }

        if ($this->hasNextPage($paginator) && $additionalLinks) {
            $listItems .= "<li><a href=\"{$this->nextPageUrl($paginator)}\">&raquo;</a></li>";
        }

        $listItems .= '</ul>';

        return $listItems;
    }
}
