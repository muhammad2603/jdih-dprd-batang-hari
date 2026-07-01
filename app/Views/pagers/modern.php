<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>" class="mt-12 mx-auto py-4 flex justify-around max-w-2xl bg-white text-default-foreground rounded-full ring-4 ring-muted/60">
	<ul class="before-pagination flex items-center">
		<?php if ($pager->hasPrevious()) : ?>
			<li>
				<a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="flex gap-1 items-center hover:text-primary">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
					</svg>
					<span aria-hidden="true"><?= lang('Pager.previous') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
	<ul class="main-pagination flex gap-5 items-center">
		<?php if ($pager->hasPrevious()): ?>
			<li>
				<span>...</span>
			</li>
		<?php endif ?>
		<?php foreach ($pager->links() as $link) : ?>
			<li class="relative <?= $link['active'] ? 'active py-0.5 px-2.5 text-foreground before:absolute before:inset-0 before:block before:bg-primary before:rounded-full before:ring-4 before:ring-primary/20' : 'hover:text-primary' ?>">
				<a href="<?= $link['uri'] ?>" class="relative">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>
		<?php if ($pager->hasNext()): ?>
			<li>
				<span>...</span>
			</li>
			<li>
				<a href="" class="hover:text-primary">
					<span aria-hidden="true"><?= lang($pager->getPageCount()) ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
	<ul class="after-pagination flex items-center">
		<?php if ($pager->hasNext()) : ?>
			<li>
				<a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="flex gap-1 items-center hover:text-primary">
					<span aria-hidden="true"><?= lang('Pager.next') ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
					</svg>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>