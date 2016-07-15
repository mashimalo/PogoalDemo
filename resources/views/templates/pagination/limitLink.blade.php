<?php
/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/4/14
 * Time: 0:45
 */
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <div class="uiPagination">
        <div class="center-table">
            <ul class="pagination">
                <li class="uiPagination__previous {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                    <a href="{{ $paginator->url(1) }}" class="small bold text-light text-uppercase">
                        First
                    </a>
                </li>
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <?php
                    $half_total_links = floor( $link_limit / 2 );
                    $from = $paginator->currentPage() - $half_total_links;
                    $to = $paginator->currentPage() + $half_total_links;
                    if ( $paginator->currentPage() < $half_total_links ) {
                        $to += $half_total_links - $paginator->currentPage();
                    }
                    if ( $paginator->lastPage() - $paginator->currentPage() < $half_total_links ) {
                        $from -= $half_total_links - ( $paginator->lastPage() - $paginator->currentPage() ) - 1;
                    }
                    ?>
                    @if ($from < $i && $i < $to)
                        <li class="uiPagination__item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                            <a href="{{ $paginator->url($i) }}" class="lk-d">{{ $i }}</a>
                        </li>
                    @endif
                @endfor
                <li class="uiPagination__next {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="small bold text-light text-uppercase">
                        Last
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif