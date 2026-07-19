<?php
$start = ($data_offset + 1) ?? 1;
?>
<table class="w-full">
    <thead>
        <tr class="bg-gray-50 border-b border-gray-100">
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-8">#</th>
            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokumen</th>
            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Jenis</th>
            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">No/Tahun</th>
            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Status</th>
            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Status Publikasi</th>
            <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
        <?php if (count($produk_hukum) > 0): ?>
            <?php for ($i = 0; $i < count($produk_hukum); $i++): ?>
                <?php
                $ph = $produk_hukum[$i];
                $status = esc($ph["status"]);
                $status_color = status_document_colors($status);
                $slug = esc($ph["slug"]);
                $state_publish = $ph["is_publish"];
                $state_publish_text = $state_publish ? "Dipublikasikan" : "Tidak Dipublikasikan";
                $state_publish_color = $state_publish ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700";
                $state_publish_icon = $state_publish ? 'icon-globe-off' : 'icon-globe';
                $state_publish_change_state = $state_publish ? '0' : '1';
                $state_publish_change_color_hover = $state_publish ? 'hover:bg-red-100 hover:text-red-700' : 'hover:bg-green-100 hover:text-green-700';
                ?>
                <tr class="hover:bg-gray-50/80 group">
                    <td class="px-5 py-3.5 text-sm text-gray-400"><?= $start + $i ?></td>
                    <td class="py-3.5 px-4">
                        <p class="judul-dokumen text-sm font-medium text-gray-800 line-clamp-2 max-w-md"><?= esc($ph["judul"]) ?></p>
                        <p class="text-xs text-gray-400 mt-1"><?= esc($ph["kategori"]) ?></p>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-primary/10 text-primary uppercase truncate"><?= esc($ph["kategori_sinonim"]) ?? esc($ph["kategori"]) ?></span>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="text-sm text-gray-600 whitespace-nowrap"><?= esc($ph["nomor"]) ?>/<?= esc($ph["tahun"]) ?></span>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium <?= $status_color ?>"><?= $status ?></span>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium <?= $state_publish_color ?>"><?= $state_publish_text ?></span>
                    </td>
                    <td class="py-3.5 px-5">
                        <div class="actions-parent flex items-center justify-end gap-1" data-document-id="<?= esc($ph["id"]) ?>">
                            <a href="/user/dashboard/kelola-dokumen/detail/<?= $slug ?>" title="Lihat Detail" class="p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-blue-50 hover:text-blue-700">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <use href="/assets/icons.svg#icon-eye">
                                </svg>
                            </a>
                            <button type="button" data-change-state="<?= $state_publish_change_state ?>" title="Ubah Status Publikasi" class="change-state-publish p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer <?= $state_publish_change_color_hover ?>">
                                <svg width="24" height="24" class="size-4">
                                    <use href="/assets/icons.svg#<?= $state_publish_icon ?>">
                                </svg>
                            </button>
                            <a href="/user/dashboard/kelola-dokumen/edit/<?= $slug ?>" title="Edit" class="p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-yellow-50 hover:text-yellow-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                </svg>
                            </a>
                            <button type="button" data-document-id="<?= esc($ph["id"]) ?>" title="Hapus" class="delete-document p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-red-50 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endfor ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="py-6 px-4">
                    <p class="text-center font-medium text-gray-800">Data tidak ditemukan.</p>
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>