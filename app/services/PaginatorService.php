<?php namespace App\Services;

use App\Models\Game;
use App\Models\Taxonomy;
use GuzzleHttp\Client;
use Slim\Container;
use Symfony\Component\Config\Definition\Exception\Exception;

class PaginatorService extends Service
{
    private $categoryAlias;
    private $itemsPerPage;
    private $maxPaginationElements;
    private $currentPage;
    private $totalPages;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->itemsPerPage = $this->container->get('settings')['pagination']['itemsPerPage'];
        $this->itemsPerPage = $this->container->get('settings')['pagination']['maxPaginationElements'];
    }

    public function setCategoryAlias($categoryAlias)
    {
        $this->categoryAlias = $categoryAlias;
    }

    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = (int)$itemsPerPage;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function setMaxPaginationElements($maxPaginationElements)
    {
        $this->maxPaginationElements = (int)$maxPaginationElements;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = (int)$currentPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setTotalPages($totalPages)
    {
        $this->totalPages = (int)$totalPages;
    }


    private function renderNewGamesButton()
    {
        // Если мы в начале - ничего не выводим
        if ($this->currentPage <= (int)$this->maxPaginationElements / 2 ||
            $this->totalPages < $this->maxPaginationElements) {
            return;
        }
        echo '<li><a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias : '/') . '">Самые новые игры</a></li>';
    }


    private function renderLeftElipsis()
    {
        // Если мы в начале шкалы - не рендерим
        if ($this->currentPage <= (int)$this->maxPaginationElements / 2 ||
            $this->totalPages < $this->maxPaginationElements) {
            return;
        }

        echo '<li><a href="#more">...</a></li>';
    }

    private function renderLeftArrow()
    {
        if ($this->currentPage < 2) {
            return;
        }

        // Если предыдущая позиция - 1 то делаем ссылку на /
        echo '<li><a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias .($this->currentPage - 1 === 1 ? '' : '/') : '/') . ($this->currentPage - 1 !== 1 ? $this->currentPage - 1 : '') . '">
            <i class="glyphicon glyphicon-arrow-left"></i></a></li>';
    }


    private function renderScale()
    {
        if ($this->isBeginScale()) {
            for ($i = 1; $i <= $this->maxPaginationElements; $i++) {
                if ($i > $this->totalPages) {
                    break;
                }
                echo '<li  ' . ($i == $this->currentPage ? 'class="active"' : '') . '>
                         <a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias . ($i === 1 ? '' : '/') : '/') . ($i === 1 ? '' : $i) . '">' . $i . '</a>
                      </li>';
            }
        }

        if ($this->isMiddleScale()) {
            $start = $this->currentPage - ($this->maxPaginationElements / 2) + 1;
            for ($i = 0; $i < $this->maxPaginationElements; $i++) {
                $index = $start + $i;
                echo '<li  ' . ($index == $this->currentPage ? 'class="active"' : '') . '><a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias . '/' : '/') . $index . '">' . $index . '</a></li>';
            }
        }

        if ($this->isEndScale()) {

            $start = $this->totalPages - (int)$this->maxPaginationElements + 1;

            for ($i = 0; $i < $this->maxPaginationElements; $i++) {
                $index = $start + $i;
                echo '<li  ' . ($index == $this->currentPage ? 'class="active"' : '') . '><a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias . '/' : '/') . $index . '">' . $index . '</a></li>';
            }

        }
    }


    private function renderRightArrow()
    {
        if ($this->currentPage != $this->totalPages) {
            echo '<li><a href="' .
                (!empty($this->categoryAlias) ? '/' . $this->categoryAlias . '/' : '/') . ($this->currentPage + 1) .
                '"><i class="glyphicon glyphicon-arrow-right"></i></a></li>';
        }
    }

    private function renderRightElipsis()
    {
        if ($this->isEndScale() || $this->totalPages <= $this->maxPaginationElements) {
            return;
        }
        echo '<li><a href="#more">...</a></li>';
    }

    private function renderOldGamesButton()
    {
        if ($this->isEndScale() || $this->totalPages <= $this->maxPaginationElements) {
            return;
        }

        echo '<li><a href="' . (!empty($this->categoryAlias) ? '/' . $this->categoryAlias . '/' : '/') . $this->totalPages . '">Самые старые игры</a></li>';
    }

    private function isBeginScale()
    {
        return $this->currentPage <= (int)($this->maxPaginationElements / 2) ||
               $this->totalPages < (int)($this->maxPaginationElements);
    }

    private function isMiddleScale()
    {
        return $this->currentPage > (int)$this->maxPaginationElements / 2 &&
            $this->totalPages - $this->currentPage - 1 >= (int)$this->maxPaginationElements / 2 &&
            $this->totalPages > $this->maxPaginationElements;
    }

    private function isEndScale()
    {
        return $this->currentPage >= $this->totalPages - (int)$this->maxPaginationElements / 2 &&
            $this->totalPages > $this->maxPaginationElements;
    }

    private function render()
    {
        if ($this->totalPages === 1) {
            return '';
        }

        ob_start();
        echo '<ul class="pagination">';

        $this->renderNewGamesButton();
        $this->renderLeftElipsis();
        $this->renderLeftArrow();

        $this->renderScale();

        $this->renderRightArrow();
        $this->renderRightElipsis();
        $this->renderOldGamesButton();

        echo '</ul>';
        $content = ob_get_clean();
        return $content;
    }


    public function __toString()
    {
        return $this->render();
    }

}