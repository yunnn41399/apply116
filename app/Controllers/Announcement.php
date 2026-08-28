<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Services\HomepagePageService;
use App\Services\HomepageMarqueeService;

class Announcement extends BaseController
{
    protected $announcementModel;
    protected $homepagePageService;
    protected $homepageMarqueeService;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->homepagePageService = new HomepagePageService();
        $this->homepageMarqueeService = new HomepageMarqueeService();
    }

    // 前台公告列表
    public function index()
    {
        $announcements = $this->announcementModel
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        return view('announcement/index', [
            'announcements' => $announcements,
            'pager' => $this->announcementModel->pager
        ]);
    }

    public function category($category)
    {
        $categories = [
            1 => '簡章訊息事項',
            2 => '招生試務',
            3 => '甄選資訊',
            4 => '會議簡報',
            5 => '其他事項',
            6 => '系統公告',
            7 => '師資保送甄試',
            8 => '醫事人員養成計畫',
        ];

        if (!isset($categories[$category])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $categoryName = $categories[$category];

        $announcements = $this->announcementModel
            ->where('category', $categoryName)
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');
        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        $sidebarPages = [];
        $sPages = $this->homepagePageService->getPagesByLocation('sidebar');
        foreach ($sPages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $sidebarPages[] = $state;
            }
        }

        $sidebarGroups = [
            'admission' => $this->homepagePageService->getGroupState('admission'),
            'related'   => $this->homepagePageService->getGroupState('related'),
        ];

        $marquee = $this->homepageMarqueeService->getVisibleMarquee();

        return view('announcement/category', [
            'announcements' => $announcements,
            'category'      => $categoryName,
            'categoryId'    => $category,
            'pager'         => $this->announcementModel->pager,
            'navbarPages'   => $navbarPages,
            'sidebarPages'  => $sidebarPages,
            'sidebarGroups' => $sidebarGroups,
            'marquee'       => $marquee,
        ]);
    }

    // 後臺公告列表
    public function adminIndex()
    {
        $keyword = trim($this->request->getGet('keyword'));
        $sort = $this->request->getGet('sort');
        $direction = strtoupper($this->request->getGet('direction'));

        $allowedSorts = [
            'id',
            'title',
            'updated_at',
            'publish_date',
            'status'
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'updated_at';
        }

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        $builder = $this->announcementModel;

        if ($keyword !== '') {
            $builder->like('title', $keyword);
        }

        if ($sort === 'status') {
            if ($direction === 'DESC') {
                $builder->orderBy(
                    "CASE WHEN status = 'published' THEN 1 ELSE 0 END",
                    'DESC',
                    false
                );
            } else {
                $builder->orderBy(
                    "CASE WHEN status = 'published' THEN 0 ELSE 1 END",
                    'DESC',
                    false
                );
            }
            $builder->orderBy('updated_at', 'DESC');
        } else {
            $builder->orderBy($sort, $direction);
        }

        $announcements = $builder->paginate(10);

        return view('admin/announcement/index', [
            'announcements' => $announcements,
            'keyword'       => $keyword,
            'sort'          => $sort,
            'direction'     => $direction,
            'pager'         => $this->announcementModel->pager
        ]);
    }

    // 新增公告
    public function create()
    {
        if ($this->request->is('get')) {
            return view('admin/announcement/create');
        }

        $type = $this->request->getPost('type');

        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        if ($type === '一般公告') {
            $rules['content'] = 'required';
        } elseif ($type === '超連結') {
            $rules['external_url'] = 'required|valid_url_strict';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // 處理多附件上傳與預設檔名
        $attachments = [];
        $files = $this->request->getFiles();

        if (isset($files['attachments'])) {
            $uploadPath = FCPATH . 'uploads/announcements';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            foreach ($files['attachments'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    $attachments[] = [
                        'path'        => 'uploads/announcements/' . $newName,
                        'custom_name' => $originalName
                    ];
                }
            }
        }

        if ($type === '純檔案' && empty($attachments)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', ['attachments' => '「純檔案」類型的公告必須提供至少一個附件檔案']);
        }

        $status = $this->request->getPost('status');
        if (!in_array($status, ['draft', 'published'])) {
            $status = 'draft';
        }

        $inputPublishDate = $this->request->getPost('publish_date');
        if (!empty($inputPublishDate)) {
            $publishDate = $inputPublishDate;
        } else {
            $publishDate = ($status === 'published') ? date('Y-m-d H:i:s') : null;
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'type'         => $type,
            'content'      => ($type === '一般公告') ? $this->request->getPost('content') : null,
            'attachment'   => !empty($attachments) ? json_encode($attachments, JSON_UNESCAPED_UNICODE) : null,
            'external_url' => ($type === '超連結') ? $this->request->getPost('external_url') : null,
            'publish_date' => $publishDate,
            'status'       => $status,
        ];

        $result = $this->announcementModel->insert($data);

        if ($result === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->announcementModel->errors());
        }

        return redirect()
            ->to('/admin/announcement')
            ->with('success', '公告新增成功');
    }

    // 編輯公告
    public function edit($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('找不到該公告');
        }

        if ($this->request->is('get')) {
            return view('admin/announcement/edit', [
                'announcement' => $announcement
            ]);
        }

        $type = $this->request->getPost('type');

        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        if ($type === '一般公告') {
            $rules['content'] = 'required';
        } elseif ($type === '超連結') {
            $rules['external_url'] = 'required|valid_url_strict';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // 處理多附件與自訂名稱更新
        // =========================
        $deleteAttachments = $this->request->getPost('delete_attachments') ?? [];
        $existingPaths = $this->request->getPost('existing_attachments_path') ?? [];
        $existingNames = $this->request->getPost('existing_attachments_name') ?? [];

        $finalAttachments = [];

        // 1. 處理已存在的舊附件
        if (is_array($existingPaths)) {
            foreach ($existingPaths as $index => $path) {
                if (in_array($path, $deleteAttachments, true)) {
                    if (file_exists(FCPATH . $path)) {
                        unlink(FCPATH . $path);
                    }
                } else {
                    $customName = trim($existingNames[$index] ?? '');
                    $finalAttachments[] = [
                        'path'        => $path,
                        'custom_name' => !empty($customName) ? $customName : basename($path)
                    ];
                }
            }
        }

        // 2. 處理新上傳的多個檔案
        $files = $this->request->getFiles();
        if (isset($files['attachments'])) {
            $uploadPath = FCPATH . 'uploads/announcements';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            foreach ($files['attachments'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $originalName = $file->getClientName();
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    $finalAttachments[] = [
                        'path'        => 'uploads/announcements/' . $newName,
                        'custom_name' => $originalName
                    ];
                }
            }
        }

        if ($type === '純檔案' && empty($finalAttachments)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', ['attachments' => '「純檔案」類型的公告必須保留或上傳至少一個附件檔案']);
        }

        $attachmentJson = !empty($finalAttachments) ? json_encode($finalAttachments, JSON_UNESCAPED_UNICODE) : null;

        if ($announcement['status'] === 'published') {
            $status = 'published';
        } else {
            $status = $this->request->getPost('status');
            if (!in_array($status, ['draft', 'published'])) {
                $status = 'draft';
            }
        }

        $publishDate = ($status === 'published') ? date('Y-m-d H:i:s') : null;

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'type'         => $type,
            'content'      => ($type === '一般公告') ? $this->request->getPost('content') : null,
            'attachment'   => ($type === '超連結') ? null : $attachmentJson,
            'external_url' => ($type === '超連結') ? $this->request->getPost('external_url') : null,
            'publish_date' => $publishDate,
            'status'       => $status,
        ];

        $result = $this->announcementModel->update($id, $data);

        if ($result === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->announcementModel->errors());
        }

        return redirect()
            ->to('/admin/announcement')
            ->with('success', '公告更新成功');
    }

    // 刪除公告
    public function delete($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('找不到該公告');
        }

        if (!empty($announcement['attachment'])) {
            $decoded = json_decode($announcement['attachment'], true);
            $filesToDelete = is_array($decoded) ? $decoded : [$announcement['attachment']];

            foreach ($filesToDelete as $item) {
                $filePath = is_array($item) ? ($item['path'] ?? '') : $item;
                if (!empty($filePath) && file_exists(FCPATH . $filePath)) {
                    unlink(FCPATH . $filePath);
                }
            }
        }

        $this->announcementModel->delete($id);

        return redirect()->to('/admin/announcement')->with('success', '公告已成功刪除');
    }

    // 公告詳細內容
    public function detail($id = null)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');
        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        $sidebarPages = [];
        $sPages = $this->homepagePageService->getPagesByLocation('sidebar');
        foreach ($sPages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $sidebarPages[] = $state;
            }
        }

        $sidebarGroups = [
            'admission' => $this->homepagePageService->getGroupState('admission'),
            'related'   => $this->homepagePageService->getGroupState('related'),
        ];

        $marquee = $this->homepageMarqueeService->getVisibleMarquee();

        return view('announcement/detail', [
            'announcement'  => $announcement,
            'navbarPages'   => $navbarPages,
            'sidebarPages'  => $sidebarPages,
            'sidebarGroups' => $sidebarGroups,
            'marquee'       => $marquee,
        ]);
    }
}