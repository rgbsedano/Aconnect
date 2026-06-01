<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin pagination renderer (sliding window with ellipses).
 *
 * Always shows: first, last, current, and 1 sibling on either side.
 * Preserves existing query params by accepting them as an array.
 */
function admin_build_pagination_links(string $base_url, array $query_params, int $current_page, int $total_pages, string $page_param = 'page'): string
{
    if ($total_pages <= 1) {
        return '';
    }

    $current_page = max(1, min($current_page, $total_pages));

    $build_url = function (int $page) use ($base_url, $query_params, $page_param): string {
        $params = $query_params;
        $params[$page_param] = $page;
        return $base_url . (strpos($base_url, '?') === false ? '?' : '&') . http_build_query($params);
    };

    // Sliding window: first, last, current, +/-1 sibling
    $pages = [1, $total_pages, $current_page - 1, $current_page, $current_page + 1];
    $pages = array_filter($pages, function ($p) use ($total_pages) {
        return is_int($p) && $p >= 1 && $p <= $total_pages;
    });
    $pages = array_values(array_unique($pages));
    sort($pages);

    $prev_disabled = $current_page <= 1 ? ' disabled' : '';
    $next_disabled = $current_page >= $total_pages ? ' disabled' : '';

    $items = [];
    $items[] = '<li class="page-item' . $prev_disabled . '"><a class="page-link" href="' . ($prev_disabled ? 'javascript:void(0)' : $build_url($current_page - 1)) . '">Prev</a></li>';

    $last_rendered = 0;
    foreach ($pages as $p) {
        if ($last_rendered && $p > $last_rendered + 1) {
            $items[] = '<li class="page-item disabled"><span class="page-link">…</span></li>';
        }
        $active = $p === $current_page ? ' active' : '';
        $items[] = '<li class="page-item' . $active . '"><a class="page-link" href="' . $build_url($p) . '">' . $p . '</a></li>';
        $last_rendered = $p;
    }

    $items[] = '<li class="page-item' . $next_disabled . '"><a class="page-link" href="' . ($next_disabled ? 'javascript:void(0)' : $build_url($current_page + 1)) . '">Next</a></li>';

    return '<nav aria-label="Pagination"><ul class="pagination justify-content-center">' . implode('', $items) . '</ul></nav>';
}

