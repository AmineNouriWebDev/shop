<?php
function renderPagination($currentPage, $totalPages, $baseUrl) {
    if ($totalPages <= 1) {
        return;
    }

    $adjacents = 2;
    $pagination = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

    // Previous Button
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '&p=' . $prevPage . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
    } else {
        $pagination .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
    }

    // Page Numbers
    // Always show first page
    if ($currentPage > ($adjacents + 1)) {
         $pagination .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '&p=1">1</a></li>';
         if ($currentPage > ($adjacents + 2)) {
             $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
         }
    }

    // Pages around current page
    $start = max(1, $currentPage - $adjacents);
    $end = min($totalPages, $currentPage + $adjacents);

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $currentPage) {
            $pagination .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '&p=' . $i . '">' . $i . '</a></li>';
        }
    }

    // Always show last page
    if ($currentPage < ($totalPages - $adjacents)) {
         if ($currentPage < ($totalPages - $adjacents - 1)) {
             $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
         }
         $pagination .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '&p=' . $totalPages . '">' . $totalPages . '</a></li>';
    }

    // Next Button
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '&p=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
    } else {
         $pagination .= '<li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
    }

    $pagination .= '</ul></nav>';
    echo $pagination;
}
?>
