<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Testimonial;
use App\Services\UploadService;

class AdminTestimonialController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/testimonials/index', [
            'pageTitle' => 'Müşteri Yorumları',
            'items' => Testimonial::all('sort_order ASC, id DESC'),
        ]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));
        if ($name === '') {
            Session::flash('flash_err', 'Müşteri adı zorunludur.');
            $this->redirect('yonetim/yorumlar');
            return;
        }
        $data = [
            'name' => $name,
            'company' => trim((string) ($_POST['company'] ?? '')),
            'location' => trim((string) ($_POST['location'] ?? '')),
            'comment' => trim((string) ($_POST['comment'] ?? '')),
            'rating' => max(1, min(5, (int) ($_POST['rating'] ?? 5))),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if (!empty($_FILES['image']['name'])) {
            $res = UploadService::image($_FILES['image'], 'yorumlar');
            if (isset($res['path'])) {
                $data['image'] = $res['path'];
            } else {
                Session::flash('flash_err', $res['error']);
            }
        }
        if (!empty($_POST['remove_image'])) {
            $data['image'] = '';
        }
        if ($id > 0) {
            Testimonial::update($id, $data);
        } else {
            Testimonial::create($data);
        }
        Session::flash('flash_ok', 'Yorum kaydedildi.');
        $this->redirect('yonetim/yorumlar');
    }

    public function destroy(): void
    {
        $this->verifyCsrf();
        Testimonial::delete((int) ($_POST['id'] ?? 0));
        Session::flash('flash_ok', 'Yorum silindi.');
        $this->redirect('yonetim/yorumlar');
    }
}
