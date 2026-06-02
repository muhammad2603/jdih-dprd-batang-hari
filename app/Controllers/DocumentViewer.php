<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

helper("string");

class DocumentViewer extends BaseController
{
    public function index()
    {
        $csp = $this->response->getCSP();
        $csp->clearDirective('script-src');
        $csp->clearDirective('style-src');
        $csp->clearDirective('style-src-elem');
        $csp->setDefaultSrc("'self' 'unsafe-inline' 'wasm-unsafe-eval'");
        $csp->addStyleSrc("'self' 'unsafe-inline' https://fonts.googleapis.com");
        $csp->addImageSrc("blob:");
        $csp->addFontSrc("*");
        $csp->addWorkerSrc("'self' blob:");
        $csp->addConnectSrc("'self' data: https://cdn.jsdelivr.net");
        $document = $this->request->getVar('dokumen') ?? false;
        if ($document === false) {
            return $this->response->redirect(previous_url());
        }
        $document_title = strtoupper(uri_title_to_words(str_replace(".pdf", '', $document)));
        $path_document = WRITEPATH . 'uploads/dokumen-hukum/';
        $document_content = file_get_contents($path_document . $document);
        $document_content = "data:application/pdf;base64," . base64_encode($document_content);
        return view('pages/document_viewer', ["title" => $document_title, "content" => $document_content]);
    }
}
