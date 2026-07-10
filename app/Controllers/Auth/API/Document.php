<?php

declare(strict_types=1);

namespace App\Controllers\Auth\API;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use App\Models\ProdukHukum;
use App\Models\MetaProdukHukum;
use App\Models\RiwayatPerubahanProdukHukum;
use App\Models\RiwayatDetailPerubahan;
use App\Models\KlasifikasiBidangHukum;
use App\Models\KlasifikasiSubjek;
use App\Models\RelatedDocument;
use App\Models\LampiranProdukHukum;
use CodeIgniter\Shield\Entities\User;

class Document extends ResourceController
{
    private BaseConnection $db;
    private ProdukHukum $ph_model;
    private MetaProdukHukum $meta_ph_model;
    private RiwayatPerubahanProdukHukum $rpph_model;
    private RiwayatDetailPerubahan $rdp_model;
    private KlasifikasiBidangHukum $kbh_model;
    private KlasifikasiSubjek $ks_model;
    private RelatedDocument $rd_model;
    private LampiranProdukHukum $lph_model;
    private User|null $user;
    public function __construct()
    {
        $this->db               = Database::connect();
        $this->user             = auth()->user();
        $this->ph_model         = new ProdukHukum;
        $this->meta_ph_model    = new MetaProdukHukum;
        $this->rpph_model       = new RiwayatPerubahanProdukHukum;
        $this->rdp_model        = new RiwayatDetailPerubahan;
        $this->kbh_model        = new KlasifikasiBidangHukum;
        $this->ks_model         = new KlasifikasiSubjek;
        $this->rd_model         = new RelatedDocument;
        $this->lph_model        = new LampiranProdukHukum;
    }

    /**
     * Kirim response gagal yang mengirimkan token csrf hash baru
     * 
     * @param int $errorCode kode response
     * @param string|array $message pesan tambahan yang akan dikirim ke client/fetch
     * @return ResponseInterface
     */
    private function setErrorResponse($message, $errorCode = 400)
    {
        return $this->response
            ->setStatusCode($errorCode)
            ->setJSON([
                "success" => false,
                "message" => $message,
                "new_token" => csrf_hash()
            ]);
    }

    /**
     * Membuat log berdasarkan operasi yang dilakukan
     * 
     * @param string $level level log
     * @param int $user_id ID user yang mengakses API ini
     * @param string $username username yang mengakses API ini
     * @param string $operation operasi yang dilakukan. Cth: Create Document, Delete Document, dsb.
     * @param string $message pesan log
     * @return void
     */
    private function setLogMessage(string $level, int $user_id, string $username, string $operation, string $message): void
    {
        log_message($level, "[ID: $user_id - User $username] [$operation]: $message");
    }

    /**
     * Cek apakah akun user yang terautentikasi dibanned?
     * 
     * @return bool true jika akun user dibanned
     */
    private function isUserGotBanned(): bool
    {
        return $this->user->isBanned();
    }

    /**
     * Cek apakah user diizinkan untuk melakukan operasi CRUD pada dokumen?
     * 
     * @param string $permission operasi yang diizinkan. list permission: create|update|delete
     * @return bool true jika user diizinkan
     */
    private function isUserHasPermission(string $permission): bool
    {
        return $this->user->can("document." . $permission);
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Membuat dokumen baru
     *
     * @return ResponseInterface
     */
    public function create()
    {
        if (!$this->user->can("document.create")) {
            return self::setErrorResponse("Maaf, anda tidak dapat menambahkan dokumen. Operasi tidak diizinkan.");
        }
        if ($this->user->isBanned()) {
            return self::setErrorResponse("Maaf, akun anda telah dibanned, alasan: {$this->user->getBanMessage()}. Hubungi administrator untuk mengaktifkan akun anda kembali.");
        }
        if (!$this->request->isAJAX()) {
            return self::setErrorResponse("Maaf, operasi tidak dapat dilakukan. Jika masalah ini terus berlanjut, hubungi administrator anda.");
        }
        $rules = [
            'judul_dokumen' => [
                'label' => 'Judul dokumen',
                'rules' => 'required|min_length[5]|max_length[255]|is_unique[produk_hukum.title]',
            ],
            'nomor_dokumen' => [
                'label' => 'Nomor dokumen',
                'rules' => 'required|numeric',
            ],
            'tahun_dokumen' => [
                'label' => 'Tahun dokumen',
                'rules' => 'required|numeric|exact_length[4]',
            ],
            'nomor_tld' => [
                'label' => 'Nomor TLD',
                'rules' => 'required|numeric',
            ],
            'tahun_tld' => [
                'label' => 'Tahun TLD',
                'rules' => 'required|numeric|exact_length[4]',
            ],
            'jenis_dokumen' => [
                'label' => 'Jenis dokumen',
                'rules' => 'required|numeric',
            ],
            'status_dokumen' => [
                'label' => 'Status dokumen',
                'rules' => 'required|numeric',
            ],
            'teu_dokumen' => [
                'label' => 'TEU dokumen',
                'rules' => 'required|numeric',
            ],
            'tanggal_penetapan' => [
                'label' => 'Tanggal penetapan',
                'rules' => 'required|valid_date',
            ],
            'tanggal_pengundangan' => [
                'label' => 'Tanggal pengundangan',
                'rules' => 'required|valid_date',
            ],
            'tanggal_berlaku' => [
                'label' => 'Tanggal berlaku',
                'rules' => 'required|valid_date',
            ],
            'pembuat_peraturan' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'pejabat_penandatanganan' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'pejabat_penetap' => [
                'label' => 'Pembuat peraturan',
                'rules' => 'required|numeric',
            ],
            'sumber' => [
                'label' => 'Sumber',
                'rules' => 'required|numeric',
            ],
            'judul_abstrak_pdf' => [
                'label' => 'Judul Abstrak',
                'rules' => 'permit_empty|min_length[5]|max_length[80]'
            ],
            'catatan' => [
                'label' => 'Catatan',
                'rules' => 'permit_empty|min_length[8]|max_length[255]',
            ],
            'komentar_perubahan' => [
                'label' => 'Komentar perubahan',
                'rules' => 'permit_empty|min_length[8]|max_length[255]',
            ],
        ];
        if (!$this->validate($rules)) {
            return self::setErrorResponse($this->validator->getErrors());
        }
        $request = $this->request;
        foreach (['tanggal_penetapan', 'tanggal_pengundangan', 'tanggal_berlaku'] as $tanggal) {
            if ($request->getPost($tanggal) > date('Y-m-d')) {
                return self::setErrorResponse("$tanggal tidak boleh lebih dari hari ini");
            }
        }
        $kategoriBidangHukum = json_decode($request->getPost('kategori_bidang_hukum'), true) ?? [];
        $kategoriSubjek = json_decode($request->getPost('kategori_subjek'), true) ?? [];
        $dokumenTerkait = json_decode($request->getPost('dokumen_terkait'), true) ?? [];
        foreach (array_merge($kategoriBidangHukum, $kategoriSubjek) as $id) {
            if (!is_numeric($id)) {
                return self::setErrorResponse('Kategori harus berupa ID angka');
            }
        }
        foreach ($dokumenTerkait as $item) {
            if (strlen($item['judul_dokumen_terkait']) < 8 || strlen($item['judul_dokumen_terkait']) > 255) {
                return self::setErrorResponse('Judul dokumen terkait tidak valid');
            }
            foreach (['nomor_dokumen_terkait', 'tahun_dokumen_terkait', 'jenis_dokumen_terkait', 'aksi_dokumen_terkait'] as $field) {
                if (!is_numeric($item[$field])) {
                    return self::setErrorResponse("$field harus angka");
                }
            }
            if (strlen($item['tahun_dokumen_terkait']) !== 4) {
                return self::setErrorResponse('Format tahun dokumen terkait salah');
            }
        }
        $temporary_path = WRITEPATH . 'uploads/temp/';
        $temporary_files = [];
        $abstrak = $request->getFile('abstrak_pdf');
        $abstrak_pdf_file_maxsize = 5 * (1024 * 1024);
        if ($abstrak && $abstrak->isValid()) {
            if (strtolower($abstrak->getClientExtension()) !== 'pdf') {
                return self::setErrorResponse("Abstrak harus PDF");
            }
            if ($abstrak->getMimeType() !== 'application/pdf') {
                return self::setErrorResponse("Abstrak bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
            }
            if ($abstrak->getSize() > $abstrak_pdf_file_maxsize) {
                return self::setErrorResponse('Ukuran file abstrak maksimal 5 MB');
            }
            $abstrak_filename = $abstrak->getRandomName();
            $abstrak->move($temporary_path, $abstrak_filename);
        }
        $lampiran = $request->getFiles()['attachment_files'] ?? [];
        $judulLampiran = $request->getPost('attachment_titles') ?? [];
        $attachment_max_size = (30 * (1024 * 1024));
        $lampiran_lists = [];
        foreach ($lampiran as $key => $file) {
            if (!$file->isValid()) {
                continue;
            }
            if (strtolower($file->getClientExtension()) !== 'pdf') {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} harus PDF.");
            }
            if ($file->getMimeType() !== 'application/pdf') {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
            }
            if ($file->getSize() > $attachment_max_size) {
                return self::setErrorResponse("Lampiran {$judulLampiran[$key]} maksimal 30 MB.");
            }
            if (!isset($judulLampiran[$key]) || strlen($judulLampiran[$key]) < 5 || strlen($judulLampiran[$key]) > 80) {
                return self::setErrorResponse("Judul lampiran {$judulLampiran[$key]} tidak valid.");
            }
            $filename = $file->getRandomName();
            $file->move($temporary_path, $filename);
            array_push($temporary_files, $filename);
            $lampiran_lists[$key]["title"] = $judulLampiran[$key];
            $lampiran_lists[$key]["filename"] = $filename;
        }
        $title_document             = esc($request->getPost("judul_dokumen"));
        $nomor_dokumen              = esc($request->getPost('nomor_dokumen'));
        $tahun_dokumen              = esc($request->getPost('tahun_dokumen'));
        $jenis_dokumen              = esc($request->getPost('jenis_dokumen'));
        $status_dokumen             = esc($request->getPost('status_dokumen'));
        $teu_dokumen                = esc($request->getPost('teu_dokumen'));
        $tanggal_penetapan          = esc($request->getPost('tanggal_penetapan'));
        $tanggal_pengundangan       = esc($request->getPost('tanggal_pengundangan'));
        $tanggal_berlaku            = esc($request->getPost('tanggal_berlaku'));
        $pembuat_peraturan          = esc($request->getPost('pembuat_peraturan'));
        $pejabat_penandatanganan    = esc($request->getPost('pejabat_penandatanganan'));
        $pejabat_penetap            = esc($request->getPost('pejabat_penetap'));
        $nomor_tld                  = esc($request->getPost('nomor_tld'));
        $tahun_tld                  = esc($request->getPost('tahun_tld'));
        $sumber                     = esc($request->getPost('sumber'));
        $tempat_penetapan           = esc($request->getPost('tempat_penetapan'));
        $catatan                    = str_replace(['"', "'"], "", esc($request->getPost('catatan')));
        $komentar_perubahan         = str_replace(['"', "'"], "", esc($request->getPost('komentar_perubahan')) ?? "Peraturan Daerah tentang $title_document ditetapkan dan diundangkan.");
        $slug                       = url_title($title_document, '-', true);
        $path_file_abstrak          = $abstrak_filename ?? null;
        $is_publish                 = 1; // Produk Hukum ditampilkan/dipublish diwebsite
        $rows_produk_hukum = [
            "title" => $title_document,
            "nomor" => $nomor_dokumen,
            "tahun" => $tahun_dokumen,
            "tanggal_penetapan" => $tanggal_penetapan,
            "tanggal_pengundangan" => $tanggal_pengundangan,
            "tanggal_berlaku" => $tanggal_berlaku,
            "tajuk_entri_utama" => $teu_dokumen,
            "category_id" => $jenis_dokumen,
            "status_id" => $status_dokumen,
            "slug" => $slug,
            "is_publish" => $is_publish,
            "updated_at" => null
        ];
        $this->db->transStart();
        try {
            $this->ph_model->insert($rows_produk_hukum);
            $new_ph_id = $this->ph_model->getInsertID();
            $this->meta_ph_model->insert([
                "ph_id" => $new_ph_id,
                "abstrak_pdf" => $path_file_abstrak,
                "catatan" => $catatan,
                "sumber_id" => $sumber,
                "tempat_penetapan" => $tempat_penetapan,
                "nomor_tld" => $nomor_tld,
                "tahun_tld" => $tahun_tld,
                "pembuat_peraturan" => $pembuat_peraturan,
                "penandatanganan" => $pejabat_penandatanganan,
                "pejabat_penetap" => $pejabat_penetap,
                "lokasi_terbit" => $tempat_penetapan,
            ]);
            if (count($kategoriBidangHukum) > 0) {
                foreach ($kategoriBidangHukum as $bidang_hukum_id) {
                    $this->kbh_model->save([
                        "ph_id" => $new_ph_id,
                        "bidang_hukum_id" => esc($bidang_hukum_id)
                    ]);
                }
            }
            if (count($kategoriSubjek) > 0) {
                foreach ($kategoriSubjek as $subjek_id) {
                    $this->ks_model->save([
                        "ph_id" => $new_ph_id,
                        "subjek_id" => esc($subjek_id)
                    ]);
                }
            }
            if (count($dokumenTerkait) > 0) {
                foreach ($dokumenTerkait as $dokumen) {
                    $this->rd_model->save([
                        "ph_id" => $new_ph_id,
                        "judul" => esc($dokumen["judul_dokumen_terkait"]),
                        "nomor" => esc($dokumen["nomor_dokumen_terkait"]),
                        "tahun" => esc($dokumen["tahun_dokumen_terkait"]),
                        "category_id" => esc($dokumen["jenis_dokumen_terkait"]),
                        "status_action" => esc($dokumen["aksi_dokumen_terkait"])
                    ]);
                }
            }
            $this->rdp_model->save(["comment" => $komentar_perubahan]);
            $this->rpph_model->save([
                "ph_id" => $new_ph_id,
                "rdp_id" => $this->rdp_model->getInsertID(),
            ]);
            foreach ($lampiran_lists ?? [] as $meta_file) {
                $this->lph_model->save([
                    "ph_id" => $new_ph_id,
                    "judul_berkas" => esc($meta_file["title"]),
                    "nama_berkas" => $meta_file["filename"]
                ]);
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                throw new Exception("Database gagal.");
            }
        } catch (\Throwable $e) {
            $this->db->transRollback();
            if ($path_file_abstrak !== null && file_exists($temporary_path . $path_file_abstrak)) {
                unlink($temporary_path . $path_file_abstrak);
            }
            foreach ($temporary_files as $filename) {
                $file_path = $temporary_path . $filename;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            self::setLogMessage("critical", $this->user->id, $this->user->username, "CREATE DOCUMENT", "Operasi gagal. Error: {$e->getMessage()}");
            return self::setErrorResponse($e->getMessage(), 500);
        }
        $get_abstrak_file_from_temp = $temporary_path . $path_file_abstrak;
        $abstrak_folder = FCPATH . 'assets/abstrak/';
        $dokumen_hukum_folder = WRITEPATH . 'uploads/dokumen-hukum/';
        if ($path_file_abstrak !== null && file_exists($get_abstrak_file_from_temp)) {
            rename(
                $get_abstrak_file_from_temp,
                $abstrak_folder . basename($get_abstrak_file_from_temp)
            );
        }
        foreach ($temporary_files ?? [] as $file) {
            $get_file_from_temp = $temporary_path . $file;
            $move_folder = $dokumen_hukum_folder . basename($file);
            if (file_exists(($get_file_from_temp))) {
                rename($get_file_from_temp, $move_folder);
            }
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Dokumen berhasil ditambahkan.'
        ]);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $request = $this->request;
        $payloads = $request->getPost();
        $files = $request->getFiles();
        $files_uploaded_count = count($files);
        /*
         * Hitung payload yang diterima, jika tidak ada payload perubahan field yang diterima, berikan response error.
         * 1 dikecualikan karena ia adalah _method spoofing yang ditambah disisi client (fetch).
         */
        if (count($payloads) <= 1 && $files_uploaded_count === 0) return self::setErrorResponse("Tidak ada perubahan yang diterima.");
        $rules = [
            "judul_dokumen" => 'permit_empty|min_length[5]|max_length[255]',
            "nomor" => 'permit_empty|numeric',
            "tahun" => 'permit_empty|numeric|exact_length[4]',
            "nomor_tld" => 'permit_empty|numeric',
            "tahun_tld" => 'permit_empty|numeric|exact_length[4]',
            "jenis_dokumen" => 'permit_empty|numeric',
            "status_dokumen" => 'permit_empty|numeric',
            "teu_dokumen" => 'permit_empty|numeric',
            "tanggal_penetapan" => 'permit_empty|valid_date[Y-m-d]',
            "tanggal_pengundangan" => 'permit_empty|valid_date[Y-m-d]',
            "tanggal_berlaku" => 'permit_empty|valid_date[Y-m-d]',
            "pembuat_peraturan" => 'permit_empty|numeric',
            "penandatanganan" => 'permit_empty|numeric',
            "pejabat_penetap" => 'permit_empty|numeric',
            "tempat_penetapan" => 'permit_empty|numeric',
            "sumber" => 'permit_empty|numeric',
            "catatan" => 'permit_empty|min_length[8]|max_length[255]',
            "tipe_perubahan" => 'permit_empty|required_with[riwayat_perubahan]|numeric',
            "riwayat_perubahan" => 'permit_empty|required_with[tipe_perubahan]|min_length[8]|max_length[255]'
        ];
        if (!$this->validate($rules)) return self::setErrorResponse($this->validator->getErrors());
        $ph_id = intval($id);
        $table_riwayat_detail_perubahan = [
            "title",
            "category_id",
            "status_id",
            "sumber_id",
            "tempat_penetapan",
            "nomor",
            "tahun",
            "nomor_tld",
            "tahun_tld",
            "pembuat_peraturan",
            "penandatanganan",
            "pejabat_penetap"
        ];
        $set_inserts_riwayat_detail_perubahan = [];
        $table_produk_hukum = [
            'judul_dokumen'         => 'title',
            'nomor'                 => 'nomor',
            'tahun'                 => 'tahun',
            'tanggal_penetapan'     => 'tanggal_penetapan',
            'tanggal_pengundangan'  => 'tanggal_pengundangan',
            'tanggal_berlaku'       => 'tanggal_berlaku',
            'teu_dokumen'           => 'tajuk_entri_utama',
            'jenis_dokumen'         => 'category_id',
            'status_dokumen'        => 'status_id',
        ];
        $produk_hukum_changes = [];
        if (array_key_exists("judul_dokumen", $payloads)) {
            $produk_hukum_changes["slug"] = url_title(esc($payloads["judul_dokumen"]), '-', true);
        }
        foreach ($table_produk_hukum as $payloadKey => $dbField) {
            if (array_key_exists($payloadKey, $payloads)) {
                $value = esc($payloads[$payloadKey]);
                if (in_array($dbField, $table_riwayat_detail_perubahan)) {
                    $set_inserts_riwayat_detail_perubahan[$dbField] = $value;
                }
                $produk_hukum_changes[$dbField] = $value;
            }
        }
        $table_meta_produk_hukum = [
            'catatan' => 'catatan',
            'sumber' => 'sumber_id',
            'tempat_penetapan' => 'tempat_penetapan',
            'nomor_tld' => 'nomor_tld',
            'tahun_tld' => 'tahun_tld',
            'pembuat_peraturan' => 'pembuat_peraturan',
            'penandatanganan' => 'penandatanganan',
            'pejabat_penetap' => 'pejabat_penetap'
        ];
        $meta_produk_hukum_changes = [];
        foreach ($table_meta_produk_hukum as $payloadKey => $dbField) {
            if (array_key_exists($payloadKey, $payloads)) {
                $value = esc($payloads[$payloadKey]);
                if (in_array($dbField, $table_riwayat_detail_perubahan)) {
                    $set_inserts_riwayat_detail_perubahan[$dbField] = $value;
                }
                $meta_produk_hukum_changes[$dbField] = $value;
            }
        }
        $temp_path = WRITEPATH . 'uploads/temp/';
        $abstract_path = FCPATH . 'assets/abstrak/';
        $abstract_filename_on_temp = null;
        $get_curr_abstract_name = $this->meta_ph_model->select('abstrak_pdf')->where('ph_id', $ph_id)->first()["abstrak_pdf"];
        $is_file_abstract_exist = !is_null($get_curr_abstract_name) && file_exists($abstract_path . $get_curr_abstract_name);
        /** @var bool|string Jika isinya menjadi string, itu adalah nama file abstrak beserta pathnya yang harus dihapus, jika false, jangan dihapus */
        $is_delete_file_abstract = false;
        if (isset($files["file_abstrak"])) {
            $add_abstract = $files["file_abstrak"]["add"] ?? null;
            $abstrak_pdf_file_maxsize = 5 * (1024 * 1024);
            if (!is_null($add_abstract)  && $add_abstract->isValid()) {
                if (strtolower($add_abstract->getClientExtension()) !== 'pdf') {
                    return self::setErrorResponse("Abstrak harus PDF");
                }
                if ($add_abstract->getMimeType() !== 'application/pdf') {
                    return self::setErrorResponse("Abstrak bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
                }
                if ($add_abstract->getSize() > $abstrak_pdf_file_maxsize) {
                    return self::setErrorResponse('Ukuran file abstrak maksimal 5 MB');
                }
                if ($is_file_abstract_exist) {
                    $is_delete_file_abstract = $abstract_path . $get_curr_abstract_name;
                }
                $abstrak_random_name = $add_abstract->getRandomName();
                $add_abstract->move($temp_path, $abstrak_random_name);
                $meta_produk_hukum_changes["abstrak_pdf"] = $abstrak_random_name;
                $abstract_filename_on_temp = $temp_path . $abstrak_random_name;
            }
        }
        if (isset($payloads["file_abstrak"])) {
            $is_deleted_file_abstract = esc($payloads["file_abstrak"]["delete"]) ?? null;
            if (!is_null($is_deleted_file_abstract) && $is_deleted_file_abstract === "1") {
                if ($is_file_abstract_exist) {
                    $is_delete_file_abstract = $abstract_path . $get_curr_abstract_name;
                }
                $meta_produk_hukum_changes["abstrak_pdf"] = null;
            }
        }
        $table_related_document = [
            'id' => 'id',
            'judul_dokumen_terkait' => 'judul',
            'nomor_dokumen_terkait' => 'nomor',
            'tahun_dokumen_terkait' => 'tahun',
            'jenis_dokumen_terkait' => 'category_id',
            'aksi_dokumen_terkait' => 'status_action'
        ];
        $related_document = $payloads["dokumen_terkait"] ?? [];
        $related_document_add = [];
        $related_document_changes = [];
        if (isset($related_document["add"])) {
            foreach (json_decode($related_document["add"], true) as $values) {
                $judul_dokumen_terkait = $values['judul_dokumen_terkait'] ?? null;
                $nomor_dokumen_terkait = $values['nomor_dokumen_terkait'] ?? null;
                $tahun_dokumen_terkait = $values['tahun_dokumen_terkait'] ?? null;
                $jenis_dokumen_terkait = $values['jenis_dokumen_terkait'] ?? null;
                $aksi_dokumen_terkait = $values['aksi_dokumen_terkait'] ?? null;
                if (!is_null($judul_dokumen_terkait)) {
                    if (strlen($judul_dokumen_terkait) < 8 && strlen($judul_dokumen_terkait) > 255) {
                        return self::setErrorResponse("Error: Judul dokumen terkait harus memiliki karakter min. 8 karakter dan maks. 255 karakter!");
                    }
                }
                if (!is_null($nomor_dokumen_terkait)) {
                    if (!is_numeric($nomor_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Nomor dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                if (!is_null($tahun_dokumen_terkait)) {
                    if (!is_numeric($tahun_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Tahun dokumen terkait hanya boleh mengandung angka!");
                    }
                    if (strlen($tahun_dokumen_terkait) !== 4) {
                        return self::setErrorResponse("Error: Tahun dokumen hanya boleh 4 digit angka!");
                    }
                }
                if (!is_null($jenis_dokumen_terkait)) {
                    if (!is_numeric($jenis_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Jenis dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                if (!is_null($aksi_dokumen_terkait)) {
                    if (!is_numeric($aksi_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Tindakan/Aksi dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                $set_insert_entries = ["ph_id" => $ph_id];
                foreach ($table_related_document as $payloadKey => $dbField) {
                    if (array_key_exists($payloadKey, $values)) {
                        $set_insert_entries[$dbField] = esc($values[$payloadKey]);
                    }
                }
                array_push($related_document_add, $set_insert_entries);
            }
        }
        if (isset($related_document["changed"])) {
            foreach (json_decode($related_document["changed"], true) as $values) {
                $set_update_entries = [];
                $judul_dokumen_terkait = $values['judul_dokumen_terkait'] ?? null;
                $nomor_dokumen_terkait = $values['nomor_dokumen_terkait'] ?? null;
                $tahun_dokumen_terkait = $values['tahun_dokumen_terkait'] ?? null;
                $jenis_dokumen_terkait = $values['jenis_dokumen_terkait'] ?? null;
                $aksi_dokumen_terkait = $values['aksi_dokumen_terkait'] ?? null;
                if (!is_null($judul_dokumen_terkait)) {
                    if (strlen($judul_dokumen_terkait) < 8 && strlen($judul_dokumen_terkait) > 255) {
                        return self::setErrorResponse("Error: Judul dokumen terkait harus memiliki karakter min. 8 karakter dan maks. 255 karakter!");
                    }
                }
                if (!is_null($nomor_dokumen_terkait)) {
                    if (!is_numeric($nomor_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Nomor dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                if (!is_null($tahun_dokumen_terkait)) {
                    if (!is_numeric($tahun_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Tahun dokumen terkait hanya boleh mengandung angka!");
                    }
                    if (strlen($tahun_dokumen_terkait) !== 4) {
                        return self::setErrorResponse("Error: Tahun dokumen hanya boleh 4 digit angka!");
                    }
                }
                if (!is_null($jenis_dokumen_terkait)) {
                    if (!is_numeric($jenis_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Jenis dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                if (!is_null($aksi_dokumen_terkait)) {
                    if (!is_numeric($aksi_dokumen_terkait)) {
                        return self::setErrorResponse("Error: Tindakan/Aksi dokumen terkait hanya boleh mengandung angka!");
                    }
                }
                foreach ($table_related_document as $payloadKey => $dbField) {
                    if (array_key_exists($payloadKey, $values)) {
                        $set_update_entries[$dbField] = esc($values[$payloadKey]);
                    }
                }
                array_push($related_document_changes, $set_update_entries);
            }
        }
        $table_lampiran_produk_hukum = [
            'id' => 'id',
            'nama_berkas' => 'judul_berkas'
        ];
        $attachment_changes = [];
        $attachments_files = $payloads["attachment_files"] ?? null;
        $attachments_titles = $payloads["attachment_titles"] ?? null;
        if (isset($attachments_files["changed"])) {
            foreach (json_decode($attachments_files["changed"], true) as $values) {
                $set_update_entries = ["ph_id" => $ph_id];
                foreach ($table_lampiran_produk_hukum as $payloadKey => $dbField) {
                    if (array_key_exists($payloadKey, $values)) {
                        $set_update_entries[$dbField] = esc($values[$payloadKey]);
                    }
                }
                array_push($attachment_changes, $set_update_entries);
            }
        }
        $attachment_path = WRITEPATH . 'uploads/dokumen-hukum/';
        $attachment_max_size = (30 * (1024 * 1024));
        $attachment_insert_entries = [];
        $attachment_filename_on_temp = [];
        if (isset($attachments_titles["add"])) {
            $get_attachment_files = $files["attachment_files"]["add"];
            foreach ($attachments_titles["add"] as $fileKey => $title) {
                $file = $get_attachment_files[$fileKey];
                if (!$file->isValid()) {
                    continue;
                }
                if (strtolower($file->getClientExtension()) !== 'pdf') {
                    return self::setErrorResponse("Lampiran $title harus PDF.");
                }
                if ($file->getMimeType() !== 'application/pdf') {
                    return self::setErrorResponse("Lampiran $title bukan tipe PDF. Ganti file atau pastikan formatnya PDF.");
                }
                if ($file->getSize() > $attachment_max_size) {
                    return self::setErrorResponse("Lampiran $title maksimal 30 MB.");
                }
                if (!isset($title) || strlen($title) < 5 || strlen($title) > 80) {
                    return self::setErrorResponse("Judul lampiran $title tidak valid.");
                }
                $filename = $file->getRandomName();
                $file->move($temp_path, $filename);
                array_push($attachment_filename_on_temp, $filename);
                array_push($attachment_insert_entries, [
                    "ph_id" => $ph_id,
                    "judul_berkas" => esc($title),
                    "nama_berkas" => $filename
                ]);
            }
        }

        $is_history_type_and_comment_exist = (isset($payloads["tipe_perubahan"]) && isset($payloads["riwayat_perubahan"]));

        $this->db->transStart();
        try {
            if (count($produk_hukum_changes) > 0) {
                $this->db->table("produk_hukum")
                    ->where("id", $ph_id)
                    ->update($produk_hukum_changes);
            }
            if (count($meta_produk_hukum_changes) > 0) {
                $this->db->table("meta_produk_hukum")
                    ->where("ph_id", $ph_id)
                    ->update($meta_produk_hukum_changes);
            }
            if (isset($payloads["bidang_hukum"])) {
                if (isset($payloads["bidang_hukum"]["add"])) {
                    $bidang_hukum_add_array = json_decode($payloads["bidang_hukum"]["add"]);
                    foreach ($bidang_hukum_add_array as $bh_id) {
                        $this->kbh_model->save(["ph_id" => $ph_id, "bidang_hukum_id" => $bh_id]);
                    }
                }
                if (isset($payloads["bidang_hukum"]["deleted"])) {
                    $bidang_hukum_deleted_array = json_decode($payloads["bidang_hukum"]["deleted"]);
                    foreach ($bidang_hukum_deleted_array as $bh_id) {
                        $this->kbh_model
                            ->where("ph_id", $ph_id)
                            ->where("bidang_hukum_id", $bh_id)
                            ->delete();
                    }
                }
            }
            if (isset($payloads["subjek"])) {
                if (isset($payloads["subjek"]["add"])) {
                    $bidang_hukum_add_array = json_decode($payloads["subjek"]["add"]);
                    foreach ($bidang_hukum_add_array as $bh_id) {
                        $this->ks_model->save(["ph_id" => $ph_id, "subjek_id" => $bh_id]);
                    }
                }
                if (isset($payloads["subjek"]["deleted"])) {
                    $bidang_hukum_deleted_array = json_decode($payloads["subjek"]["deleted"]);
                    foreach ($bidang_hukum_deleted_array as $bh_id) {
                        $this->ks_model
                            ->where("ph_id", $ph_id)
                            ->where("subjek_id", $bh_id)
                            ->delete();
                    }
                }
            }
            if (count($related_document_add) > 0) {
                $this->db->table('related_document')
                    ->insertBatch($related_document_add);
            }
            if (count($related_document_changes) > 0) {
                $this->db->table('related_document')
                    ->updateBatch($related_document_changes, 'id');
            }
            if (isset($related_document["deleted"])) {
                $id_array = json_decode($related_document["deleted"], true);
                $this->db->table('related_document')
                    ->where("ph_id", $ph_id)
                    ->whereIn("id", $id_array)
                    ->delete();
            }
            if (count($attachment_insert_entries) > 0) {
                $this->db->table('lampiran_produk_hukum')
                    ->insertBatch($attachment_insert_entries);
            }
            if (count($attachment_changes) > 0) {
                $this->db->table('lampiran_produk_hukum')
                    ->updateBatch($attachment_changes, 'id');
            }
            $attachments_filename_deleted = [];
            if (isset($attachments_files["deleted"])) {
                $id_array = json_decode($attachments_files["deleted"], true);
                $attachments_filename_deleted = array_map(fn($row) => $row["nama_berkas"], $this->lph_model->select("nama_berkas")->whereIn('id', $id_array)->findAll());
                $this->db->table('lampiran_produk_hukum')
                    ->where('ph_id', $ph_id)
                    ->whereIn('id', $id_array)
                    ->delete();
            }
            if ($is_history_type_and_comment_exist) {
                $new_rdp_id = $this->rdp_model
                    ->insert([
                        ...$set_inserts_riwayat_detail_perubahan,
                        "comment" => $payloads["riwayat_perubahan"]
                    ]);
                $this->db->table("riwayat_perubahan_produk_hukum")
                    ->insert([
                        "ph_id" => $ph_id,
                        "rdp_id" => $new_rdp_id,
                        "change_type" => $payloads["tipe_perubahan"]
                    ]);
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) throw new Exception("Update data gagal.");
        } catch (\Throwable $e) {
            $this->db->transRollback();
            if (file_exists($abstract_filename_on_temp)) {
                unlink($abstract_filename_on_temp);
            }
            foreach ($attachment_filename_on_temp as $filename) {
                $full_path_temp = $temp_path . $filename;
                if (file_exists($full_path_temp)) {
                    unlink($full_path_temp);
                }
            }
            self::setLogMessage("critical", $this->user->id, $this->user->username, "UPDATE DOCUMENT", "Operasi gagal. Error: {$e->getMessage()}");
            return self::setErrorResponse($e->getMessage(), 500);
        }
        if ($is_delete_file_abstract !== false) {
            unlink($is_delete_file_abstract);
        }
        if (!is_null($abstract_filename_on_temp) && file_exists($abstract_filename_on_temp)) {
            rename(
                $abstract_filename_on_temp,
                $abstract_path . basename($abstract_filename_on_temp)
            );
        }
        foreach ($attachment_filename_on_temp as $filename) {
            $full_path_temp = $temp_path . $filename;
            if (file_exists($full_path_temp)) {
                rename(
                    $full_path_temp,
                    $attachment_path . $filename
                );
            }
        }
        foreach ($attachments_filename_deleted as $filename) {
            $file_fullpath = $attachment_path . $filename;
            if (file_exists($file_fullpath)) {
                unlink($file_fullpath);
            }
        }
        return $this->response
            ->setJSON([
                "status" => true,
                "message" => "Update data berhasil.",
            ]);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (self::isUserGotBanned()) {
            return self::setErrorResponse("Maaf, akun anda telah dibanned, alasan:{$this->user->getBanMessage()}. Hubungi administrator untuk mengaktifkan akun anda kembali.", 403);
        }
        if (!self::isUserHasPermission("delete")) {
            return self::setErrorResponse("Maaf, anda tidak dapat menghapus dokumen. Operasi tidak diizinkan.", 403);
        }
        if (!$this->request->isAJAX()) {
            return self::setErrorResponse("Maaf, operasi tidak dapat dilakukan. Jika masalah ini terus berlanjut, hubungi administrator anda.");
        }
        $validate_id = $this->validateData(["id" => $id], ["id" => "required|is_natural_no_zero"]);
        if (!$validate_id) {
            return self::setErrorResponse("ID tidak valid.");
        }
        $is_data_exist = $this->db->table("produk_hukum")
            ->select("id")
            ->where("id", $id)
            ->get()->getFirstRow('array');

        if (is_null($is_data_exist)) {
            return self::setErrorResponse("Dokumen tidak ditemukan. Cek kembali apakah data masih tersedia.", 404);
        }
        $is_attachments_exist = $this->db->table('lampiran_produk_hukum')
            ->select("nama_berkas")
            ->where("ph_id", $id)
            ->get()->getResultArray();
        $get_abstract_file = $this->db->table('meta_produk_hukum')
            ->select("abstrak_pdf")
            ->where("ph_id", $id)
            ->where("abstrak_pdf IS NOT", null)
            ->get()->getResultArray()[0]["abstrak_pdf"] ?? null;
        $this->db->transStart();
        try {
            $this->ph_model->delete($id, true);
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                throw new Exception("Gagal menghapus dokumen hukum");
            }
        } catch (\Throwable $e) {
            $this->db->transRollback();
            self::setLogMessage("critical", $this->user->id, $this->user->username, "DELETE DOCUMENT", "Gagal menghapus dokumen hukum dengan ID: {$id}. [{$e->getCode()}]: {$e->getMessage()}");
            return self::setErrorResponse($e->getMessage(), 500);
        }
        $attachment_path = WRITEPATH . 'uploads/dokumen-hukum/';
        foreach ($is_attachments_exist as $file) {
            $filename = $file["nama_berkas"];
            $is_file_exist = file_exists($attachment_path . $filename);
            if ($is_file_exist) {
                $remove_file = unlink($attachment_path . $filename);
                $attachments_deleted[] = $remove_file;
            }
        }
        $abstract_path = FCPATH . "assets/abstrak/";
        if ($get_abstract_file !== null && file_exists($abstract_path . $get_abstract_file)) {
            $remove_file = unlink($abstract_path . $get_abstract_file);
        }
        return $this->response->setJSON([
            "status" => true,
            "message" => "Dokumen berhasil dihapus secara permanen.",
            "new_token" => csrf_hash()
        ]);
    }
}
