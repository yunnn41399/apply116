<?php
// 顯示目前頁面前後各 2 個頁碼
$pager->setSurroundCount(2);
?>
<nav class="department-pagination-nav" aria-label="校系資料分頁">
    <!-- 頁碼區 -->
    <div class="department-pagination-pages">
        <ul class="department-pagination-list">
            <!-- 上一頁 -->
            <?php if ($pager->hasPreviousPage()): ?>
                <li class="department-pagination-item">
                    <a class="department-pagination-link" href="<?= $pager->getPreviousPage() ?>" aria-label="上一頁">
                        <i class="bi bi-chevron-left"></i>
                        上一頁
                    </a>
                </li>
            <?php endif; ?>
            <!-- 第一頁 -->
            <?php if ($pager->getFirstPageNumber() > 1): ?>
                <li class="department-pagination-item">
                    <a class="department-pagination-link" href="<?= $pager->getFirst() ?>">
                        1
                    </a>
                </li>
                <li class="department-pagination-item">
                    <span class="department-pagination-ellipsis">
                        ...
                    </span>
                </li>
            <?php endif; ?>
            <!-- 目前頁面附近的頁碼 -->
            <?php foreach ($pager->links() as $link): ?>
                <li class="department-pagination-item">
                    <?php if ($link['active']): ?>
                        <span class="department-pagination-link active">
                            <?= esc($link['title']) ?>
                        </span>
                    <?php else: ?>
                        <a class="department-pagination-link" href="<?= $link['uri'] ?>">
                            <?= esc($link['title']) ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            <!-- 最後一頁 -->
            <?php if (
                $pager->getLastPageNumber()
                < $pager->getPageCount()
            ): ?>
                <li class="department-pagination-item">
                    <span class="department-pagination-ellipsis">
                        ...
                    </span>
                </li>
                <li class="department-pagination-item">
                    <a class="department-pagination-link" href="<?= $pager->getLast() ?>">
                        <?= $pager->getPageCount() ?>
                    </a>
                </li>
            <?php endif; ?>
            <!-- 下一頁 -->
            <?php if ($pager->hasNextPage()): ?>
                <li class="department-pagination-item">
                    <a class="department-pagination-link" href="<?= $pager->getNextPage() ?>" aria-label="下一頁">
                        下一頁
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- 共幾頁 -->
    <div class="department-pagination-total department-result-count">
        共 <?= $pager->getPageCount() ?> 頁
    </div>
</nav>