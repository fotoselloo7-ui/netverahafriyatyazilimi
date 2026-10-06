<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Faq;

class AdminFaqController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/faq/index', ['pageTitle' => 'Sık Sorulan Sorular', 'faqs' => Faq::all('sort_order ASC')]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $q = trim((string) ($_POST['question'] ?? ''));
        if ($q === '') { $this->back('/yonetim/sss'); return; }
        $data = [
            'question' => $q,
            'answer' => trim((string) ($_POST['answer'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($id > 0) { Faq::update($id, $data); }
        else { Faq::create($data); }
        Session::flash('flash_ok', 'Soru kaydedildi.');
        $this->redirect('yonetim/sss');
    }

    public function destroy(): void
    {
        $this->verifyCsrf();
        Faq::delete((int) ($_POST['id'] ?? 0));
        Session::flash('flash_ok', 'Soru silindi.');
        $this->redirect('yonetim/sss');
    }
}
