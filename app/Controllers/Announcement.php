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

    /**
     * =========================================================
     * 共用：取得公告附件資料 (解析 JSON / 容錯處理)
     * =========================================================
     */
    private function decodeAttachments($attachment)
    {
        if (empty($attachment)) {
            return [];
        }

        // 1. 統一修正 Windows 反斜線問題，將 \ 取代為 /
        $cleanAttachment = str_replace('\\', '/', $attachment);

        // 2. 嘗試解析 JSON
        $decoded = json_decode($cleanAttachment, true);

        // 3. JSON 解析成功且為陣列
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $result = [];

            foreach ($decoded as $item) {
                if (is_string($item)) {
                    $path = str_replace('\\', '/', $item);
                    $result[] = [
                        'path'        => $path,
                        'custom_name' => basename($path),
                    ];
                } elseif (is_array($item) && !empty($item['path'])) {
                    $path = str_replace('\\', '/', $item['path']);
                    $result[] = [
                        'path'        => $path,
                        'custom_name' => $item['custom_name'] ?? basename($path),
                    ];
                }
            }

            return $result;
        }

        // 4. 舊格式：資料庫直接存單一檔案路徑 (需確保不是壞掉的 JSON 結構)
        if (is_string($attachment) && strpos($attachment, '[') !== 0 && strpos($attachment, '{') !== 0) {
            return [
                [
                    'path'        => $cleanAttachment,
                    'custom_name' => basename($cleanAttachment),
                ]
            ];
        }

        // 解析失敗或格式異常時回傳空陣列，防止網址拼接出錯
        return [];
    }

    /**
     * =========================================================
     * 共用：建立附件上傳目錄
     * =========================================================
     */
    private function getUploadPath()
    {
        $uploadPath = FCPATH . 'uploads/announcements';

        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                throw new \RuntimeException('無法建立公告附件上傳目錄。');
            }
        }

        return $uploadPath;
    }

    /**
     * =========================================================
     * 共用：刪除實體附件
     * =========================================================
     */
    private function deleteAttachmentFile($path)
    {
        if (empty($path)) {
            return;
        }

        // 只允許刪除 uploads/announcements 底下的檔案
        $path = str_replace('\\', '/', $path);

        if (strpos($path, 'uploads/announcements/') !== 0) {
            return;
        }

        $fullPath = FCPATH . $path;

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * =========================================================
     * 前台公告列表
     * =========================================================
     */
    public function index()
    {
        $announcements = $this->announcementModel
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        return view('announcement/index', [
            'announcements' => $announcements,
            'pager'         => $this->announcementModel->pager,
        ]);
    }

    /**
     * =========================================================
     * 前台公告分類
     * =========================================================
     */
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
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        // Navbar
        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');

        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        // Sidebar
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

    /**
     * =========================================================
     * 後臺公告列表
     * =========================================================
     */
    public function adminIndex()
    {
        $keyword   = trim($this->request->getGet('keyword') ?? '');
        $sort      = $this->request->getGet('sort');
        $direction = strtoupper($this->request->getGet('direction') ?? '');

        $allowedSorts = [
            'id',
            'title',
            'updated_at',
            'publish_date',
            'status',
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
            'pager'         => $this->announcementModel->pager,
        ]);
    }

    /**
     * =========================================================
     * 新增公告
     * =========================================================
     */
    public function create()
    {
        // GET：顯示新增頁面
        if ($this->request->is('get')) {
            return view('admin/announcement/create');
        }

        $type = trim($this->request->getPost('type') ?? '');

        // 基本驗證
        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        if ($type === '一般公告') {
            $rules['content'] = 'required';
        }

        if ($type === '超連結') {
            $rules['external_url'] = 'required|valid_url_strict';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // 接收前端編輯的自訂檔名陣列
        $customNames = $this->request->getPost('custom_attachment_names') ?? [];

        // 上傳附件處理 (支援多檔)
        $attachments = [];
        $uploadedFiles = $this->request->getFileMultiple('attachments');

        if (is_array($uploadedFiles)) {
            foreach ($uploadedFiles as $index => $file) {
                if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) continue;

                if (!$file->isValid()) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => $file->getErrorString()]);
                }

                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '附件檔案不可超過 10MB。']);
                }

                $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'png', 'jpg', 'jpeg'];
                $extension = strtolower($file->getClientExtension());

                if (!in_array($extension, $allowedExtensions, true)) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '不支援此檔案格式。']);
                }

                try {
                    $uploadPath   = $this->getUploadPath();
                    $originalName = $file->getClientName();
                    $newName      = $file->getRandomName();

                    $file->move($uploadPath, $newName);

                    // 若管理者有設定自訂檔名，優先採用自訂檔名
                    $userCustomName = trim($customNames[$index] ?? '');
                    $displayName    = $userCustomName !== '' ? $userCustomName : $originalName;

                    $attachments[] = [
                        'path'        => 'uploads/announcements/' . $newName,
                        'custom_name' => $displayName,
                    ];
                } catch (\Throwable $e) {
                    log_message('error', '公告附件上傳失敗：' . $e->getMessage());
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '附件上傳失敗，請稍後再試。']);
                }
            }
        }

        // 純檔案一定要有附件
        if ($type === '純檔案' && empty($attachments)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', [
                    'attachments' => '「純檔案」類型的公告必須提供至少一個附件檔案。',
                ]);
        }

        // 狀態
        $status = $this->request->getPost('status');
        if (!in_array($status, ['draft', 'published'], true)) {
            $status = 'draft';
        }

        // 發布時間
        $inputPublishDate = $this->request->getPost('publish_date');
        if (!empty($inputPublishDate)) {
            $publishDate = $inputPublishDate;
        } elseif ($status === 'published') {
            $publishDate = date('Y-m-d H:i:s');
        } else {
            $publishDate = null;
        }

        // 儲存資料
        $attachmentJson = null;
        if (!empty($attachments)) {
            $attachmentJson = json_encode(
                $attachments,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        $data = [
            'title'        => trim($this->request->getPost('title')),
            'category'     => $this->request->getPost('category'),
            'type'         => $type,
            'content'      => ($type === '一般公告') ? $this->request->getPost('content') : null,
            'attachment'   => ($type === '超連結') ? null : $attachmentJson,
            'external_url' => ($type === '超連結') ? $this->request->getPost('external_url') : null,
            'publish_date' => $publishDate,
            'status'       => $status,
        ];

        $result = $this->announcementModel->insert($data);

        if ($result === false) {
            foreach ($attachments as $item) {
                $this->deleteAttachmentFile($item['path']);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->announcementModel->errors());
        }

        return redirect()
            ->to(site_url('admin/announcement'))
            ->with('success', '公告新增成功');
    }

    /**
     * =========================================================
     * 編輯公告
     * =========================================================
     */
    public function edit($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('找不到該公告');
        }

        // GET：顯示編輯頁面
        if ($this->request->is('get')) {
            return view('admin/announcement/edit', [
                'announcement' => $announcement,
            ]);
        }

        $type = trim($this->request->getPost('type') ?? '');

        // 基本驗證
        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        if ($type === '一般公告') {
            $rules['content'] = 'required';
        }

        if ($type === '超連結') {
            $rules['external_url'] = 'required|valid_url_strict';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // 取得目前附件
        $oldAttachments = $this->decodeAttachments($announcement['attachment'] ?? null);
        $deleteAttachments = $this->request->getPost('delete_attachments') ?? [];
        $existingPaths     = $this->request->getPost('existing_attachments_path') ?? [];
        $existingNames     = $this->request->getPost('existing_attachments_name') ?? [];

        $finalAttachments = [];

        // 1. 處理原本存在的附件
        foreach ($existingPaths as $index => $path) {
            $path = trim($path);
            if ($path === '') continue;

            if (in_array($path, $deleteAttachments, true)) {
                $this->deleteAttachmentFile($path);
                continue;
            }

            $customName = trim($existingNames[$index] ?? '');
            $finalAttachments[] = [
                'path'        => str_replace('\\', '/', $path),
                'custom_name' => $customName !== '' ? $customName : basename($path),
            ];
        }

        // 2. 處理新增的多檔上傳
        $uploadedFiles = $this->request->getFileMultiple('attachments');

        if (is_array($uploadedFiles)) {
            foreach ($uploadedFiles as $file) {
                if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) continue;

                if (!$file->isValid()) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => $file->getErrorString()]);
                }

                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '附件檔案不可超過 10MB。']);
                }

                $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'png', 'jpg', 'jpeg'];
                $extension = strtolower($file->getClientExtension());

                if (!in_array($extension, $allowedExtensions, true)) {
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '不支援此檔案格式。']);
                }

                try {
                    $uploadPath   = $this->getUploadPath();
                    $originalName = $file->getClientName();
                    $newName      = $file->getRandomName();

                    $file->move($uploadPath, $newName);

                    $finalAttachments[] = [
                        'path'        => 'uploads/announcements/' . $newName,
                        'custom_name' => $originalName,
                    ];
                } catch (\Throwable $e) {
                    log_message('error', '公告附件上傳失敗：' . $e->getMessage());
                    return redirect()->back()->withInput()->with('errors', ['attachments' => '附件上傳失敗，請稍後再試。']);
                }
            }
        }

        // 純檔案必須至少有一個附件
        if ($type === '純檔案' && empty($finalAttachments)) {
            return redirect()->back()->withInput()->with('errors', ['attachments' => '「純檔案」類型的公告必須保留或上傳至少一個附件檔案。']);
        }

        // 超連結不保存附件
        if ($type === '超連結') {
            foreach ($oldAttachments as $item) {
                if (!empty($item['path'])) {
                    $this->deleteAttachmentFile($item['path']);
                }
            }
            $finalAttachments = [];
        }

        $attachmentJson = !empty($finalAttachments) 
            ? json_encode($finalAttachments, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) 
            : null;

        if ($announcement['status'] === 'published') {
            $status = 'published';
        } else {
            $status = $this->request->getPost('status');
            if (!in_array($status, ['draft', 'published'], true)) {
                $status = 'draft';
            }
        }

        if (!empty($announcement['publish_date'])) {
            $publishDate = $announcement['publish_date'];
        } elseif ($status === 'published') {
            $publishDate = date('Y-m-d H:i:s');
        } else {
            $publishDate = null;
        }

        $data = [
            'title'        => trim($this->request->getPost('title')),
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
            return redirect()->back()->withInput()->with('errors', $this->announcementModel->errors());
        }

        return redirect()->to(site_url('admin/announcement'))->with('success', '公告更新成功');
    }

    /**
     * =========================================================
     * 刪除公告
     * =========================================================
     */
    public function delete($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('找不到該公告');
        }

        $attachments = $this->decodeAttachments($announcement['attachment'] ?? null);

        foreach ($attachments as $item) {
            if (!empty($item['path'])) {
                $this->deleteAttachmentFile($item['path']);
            }
        }

        $this->announcementModel->delete($id);

        return redirect()->to(site_url('admin/announcement'))->with('success', '公告已成功刪除');
    }

    /**
     * =========================================================
     * 公告詳細內容與跳轉處理
     * =========================================================
     */
    public function detail($id = null)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 1. 超連結公告：直接跳轉到外部網址
        if ($announcement['type'] === '超連結') {
            return redirect()->to($announcement['external_url']);
        }

        // 2. 純檔案公告：解開 JSON 後，自動跳轉開啟第一個檔案
        if ($announcement['type'] === '純檔案') {
            $attachments = $this->decodeAttachments($announcement['attachment'] ?? null);

            if (empty($attachments) || empty($attachments[0]['path'])) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('此公告沒有附件檔案');
            }

            return redirect()->to(base_url($attachments[0]['path']));
        }

        // 3. 一般公告：解開附件 JSON 傳給 View 使用
        $attachments = $this->decodeAttachments($announcement['attachment'] ?? null);

        // Navbar & Sidebar 設定
        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');
        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) $navbarPages[] = $state;
        }

        $sidebarPages = [];
        $sPages = $this->homepagePageService->getPagesByLocation('sidebar');
        foreach ($sPages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) $sidebarPages[] = $state;
        }

        $sidebarGroups = [
            'admission' => $this->homepagePageService->getGroupState('admission'),
            'related'   => $this->homepagePageService->getGroupState('related'),
        ];

        $marquee = $this->homepageMarqueeService->getVisibleMarquee();

        return view('announcement/detail', [
            'announcement'  => $announcement,
            'attachments'   => $attachments, // 將解析後的附件陣列傳給 View
            'navbarPages'   => $navbarPages,
            'sidebarPages'  => $sidebarPages,
            'sidebarGroups' => $sidebarGroups,
            'marquee'       => $marquee,
        ]);
    }
}