<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<?php $style_bar = "" ?>
<section>
    <p class="text-gray-500">Ringkasan data dokumen hukum JDIH DPRD Kabupaten Batang Hari</p>
</section>
<section class="document-cards grid grid-cols-4 gap-4">
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Total Dokumen</span>
            <span class="font-bold text-3xl text-default-foreground"><?= esc($total_document) ?></span>
        </div>
        <div class="card-icon w-11 h-11 bg-primary rounded-xl flex items-center justify-center">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-document">
            </svg>
        </div>
    </div>
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Berlaku</span>
            <span class="font-bold text-3xl text-default-foreground"><?= esc($total_document_active) ?></span>
        </div>
        <div class="card-icon w-11 h-11 bg-green-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
        </div>
    </div>
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Diubah</span>
            <span class="font-bold text-3xl text-default-foreground"><?= esc($total_document_ammended) ?></span>
        </div>
        <div class="card-icon w-11 h-11 bg-accent rounded-xl flex items-center justify-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-trend-up"></use>
            </svg>
        </div>
    </div>
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Dicabut</span>
            <span class="font-bold text-3xl text-default-foreground"><?= esc($total_document_revoked) ?></span>
        </div>
        <div class="card-icon w-11 h-11 bg-red-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
        </div>
    </div>
</section>
<section class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="font-semibold text-lg text-gray-800 mb-4">Breakdown per Jenis Dokumen</h2>
    <div class="table-wrapper overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3">Jenis</th>
                    <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3">Total</th>
                    <th class="text-center text-xs font-semibold text-green-600 uppercase tracking-wider pb-3">Berlaku</th>
                    <th class="text-center text-xs font-semibold text-yellow-600 uppercase tracking-wider pb-3">Diubah</th>
                    <th class="text-center text-xs font-semibold text-red-600 uppercase tracking-wider pb-3">Dicabut</th>
                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3 pl-4">Proporsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($statistics_breakdown as $stat): ?>
                    <?php
                    $category = esc($stat["kategori"]);
                    $category_class = url_title($category, '-', true);
                    $total_document_by_category = (int) esc($stat["total_dokumen"]);
                    $average_total_document = $total_document !== 0 ? ($total_document_by_category / $total_document) * 100 : 0;
                    $style_bar .= ".$category_class { width: " . $average_total_document . "%; background-color: " . esc($stat["color"]) . " }\n";
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 text-sm text-gray-800 font-medium"><?= $category ?></td>
                        <td class="py-3 text-sm text-center font-bold text-gray-900"><?= $total_document_by_category ?></td>
                        <td class="py-3 text-sm text-center text-green-600"><?= esc($stat["total_dokumen_berlaku"]) ?></td>
                        <td class="py-3 text-sm text-center text-yellow-600"><?= esc($stat["total_dokumen_diubah"]) ?></td>
                        <td class="py-3 text-sm text-center text-red-600"><?= esc($stat["total_dokumen_dicabut"]) ?></td>
                        <td class="py-3 pl-4">
                            <div class="flex items-center gap-2">
                                <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                    <div class="h-full rounded-full <?= $category_class ?>"></div>
                                </div>
                                <span class="meter-info text-xs text-gray-400 w-10 text-right"><?= ($average_total_document === 100 || $average_total_document === 0) ? $average_total_document : sprintf('%.1f', $average_total_document) ?>%</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>
<style <?= csp_style_nonce() ?>>
    <?= $style_bar ?>
</style>
<?= $this->endSection() ?>