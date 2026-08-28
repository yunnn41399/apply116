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

        // 查詢該類別且已發布的公告
        $announcements = $this->announcementModel
            ->where('category', $categoryName)
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        // 1. 取得 Navbar 頁面設定
        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');
        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        // 2. 取得 Sidebar 頁面與群組設定
        $sidebarPages = [];
        $sPages = $this->homepagePageService->getPagesByLocation('sidebar');
        foreach ($sPages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $sidebarPages[] = $state;
            }
        }

        // 個別取得側邊欄群組狀態（招生資訊與相關網站）
        $sidebarGroups = [
            'admission' => $this->homepagePageService->getGroupState('admission'),
            'related'   => $this->homepagePageService->getGroupState('related'),
        ];

        // 3. 取得首頁跑馬燈
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
        // 取得搜尋關鍵字
        $keyword = trim($this->request->getGet('keyword'));

        // 取得排序欄位
        $sort = $this->request->getGet('sort');

        // 取得排序方向
        $direction = strtoupper($this->request->getGet('direction'));

        // 允許排序的欄位
        $allowedSorts = [
            'id',
            'title',
            'updated_at',
            'publish_date',
            'status'
        ];

        // 防止使用者傳入不存在或不允許的欄位
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'updated_at';
        }

        // 只允許 ASC / DESC
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        // 建立查詢
        $builder = $this->announcementModel;

        // 搜尋
        if ($keyword !== '') {
            $builder->like('title', $keyword);
        }


        // 排序
        // 發佈狀態特殊處理
        if ($sort === 'status') {

            if ($direction === 'DESC') {

                // 已發布優先
                $builder->orderBy(
                    "CASE WHEN status = 'published' THEN 1 ELSE 0 END",
                    'DESC',
                    false
                );

            } else {

                // 草稿優先
                $builder->orderBy(
                    "CASE WHEN status = 'published' THEN 0 ELSE 1 END",
                    'DESC',
                    false
                );
            }

            // 同狀態時，以最後編輯時間排序
            $builder->orderBy('updated_at', 'DESC');

        } else {

            $builder->orderBy($sort, $direction);
        }

        // 分頁
        $announcements = $builder->paginate(10);

        // 傳送資料給 View
        return view('admin/announcement/index', [
            'announcements' => $announcements,
            'keyword'       => $keyword,
            'sort'          => $sort,
            'direction'     => $direction,
            'pager'         => $this->announcementModel->pager
        ]);
    }

    // 新增公告（GET 顯示頁面 / POST 處理表單）
    public function create()
    {
        // GET：顯示新增公告頁面
        if ($this->request->is('get')) {
            return view('admin/announcement/create');
        }

        $type = $this->request->getPost('type');

        // 基本驗證
        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        // 根據公告類型進行驗證
        if ($type === '一般公告') {

            // 一般公告：文字內容必填
            $rules['content'] = 'required';

            // 附件可有可無
            $rules['attachment'] =
                'permit_empty|ext_in[attachment,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg]|max_size[attachment,10240]';

        } elseif ($type === '純檔案') {

            // 純檔案：附件一定要有
            $rules['attachment'] =
                'uploaded[attachment]|ext_in[attachment,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg]|max_size[attachment,10240]';

        } elseif ($type === '超連結') {

            // 超連結：網址一定要有
            $rules['external_url'] =
                'required|valid_url_strict';
        }

        // 執行驗證
        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // 處理附件上傳
        // =========================

        $attachmentPath = null;

        $file = $this->request->getFile('attachment');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 確保上傳資料夾存在
            $uploadPath = FCPATH . 'uploads/announcements';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 產生隨機檔名
            $newName = $file->getRandomName();

            // 移動檔案
            $file->move($uploadPath, $newName);

            // 儲存相對路徑到資料庫
            $attachmentPath = 'uploads/announcements/' . $newName;
        }

        // =========================
        // 判斷暫存 / 發布
        // =========================

        $status = $this->request->getPost('status');

        if (!in_array($status, ['draft', 'published'])) {
            $status = 'draft';
        }

        // =========================
        // 發布時間
        // =========================

        $inputPublishDate = $this->request->getPost('publish_date');

        if (!empty($inputPublishDate)) {
            $publishDate = $inputPublishDate;
        } else {
            $publishDate = ($status === 'published')
                ? date('Y-m-d H:i:s')
                : null;
        }

        // =========================
        // 建立公告資料
        // =========================

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'type'         => $type,
            'content'      => ($type === '一般公告')
                                ? $this->request->getPost('content')
                                : null,
            'attachment'   => $attachmentPath,
            'external_url' => ($type === '超連結')
                                ? $this->request->getPost('external_url')
                                : null,
            'publish_date' => $publishDate,
            'status'       => $status,
        ];

        // =========================
        // 寫入資料庫
        // =========================

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
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                '找不到該公告'
            );
        }

        // GET：顯示編輯頁面
        if ($this->request->is('get')) {
            return view('admin/announcement/edit', [
                'announcement' => $announcement
            ]);
        }

        $type = $this->request->getPost('type');

        // =========================
        // 基本驗證
        // =========================

        $rules = [
            'title'        => 'required|max_length[255]',
            'category'     => 'required',
            'type'         => 'required|in_list[一般公告,純檔案,超連結]',
            'publish_date' => 'permit_empty|valid_date[Y-m-d\TH:i]',
        ];

        // =========================
        // 根據公告類型驗證
        // =========================

        if ($type === '一般公告') {

            // 一般公告：內容必填
            $rules['content'] = 'required';

            // 附件可以沒有
            $rules['attachment'] =
                'permit_empty|ext_in[attachment,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg]|max_size[attachment,10240]';

        } elseif ($type === '純檔案') {

            /*
            * 編輯時有一個特殊情況：
            *
            * 如果原本已經有附件，
            * 使用者沒有重新上傳檔案，
            * 就應該允許保留原本的附件。
            */

            $file = $this->request->getFile('attachment');

            if (!$announcement['attachment'] && (!$file || !$file->isValid())) {
                $rules['attachment'] =
                    'uploaded[attachment]|ext_in[attachment,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg]|max_size[attachment,10240]';
            } else {
                $rules['attachment'] =
                    'permit_empty|ext_in[attachment,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,png,jpg,jpeg]|max_size[attachment,10240]';
            }

        } elseif ($type === '超連結') {

            $rules['external_url'] =
                'required|valid_url_strict';
        }

        // =========================
        // 執行驗證
        // =========================

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // 處理附件
        // =========================

        // 預設保留舊附件
        $attachmentPath = $announcement['attachment'] ?? null;

        // 1. 檢查是否勾選刪除舊附件
        $deleteAttachment = $this->request->getPost('delete_attachment');
        if ($deleteAttachment === '1') {
            if (!empty($attachmentPath) && file_exists(FCPATH . $attachmentPath)) {
                unlink(FCPATH . $attachmentPath); // 刪除實體檔案
            }
            $attachmentPath = null; // 清空路徑
        }

        // 2. 處理新檔案上傳
        $file = $this->request->getFile('attachment');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadPath = FCPATH . 'uploads/announcements';

            // 確保資料夾存在
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // 若原本有舊檔案（且剛才沒被刪除），則刪除
            if (!empty($attachmentPath) && file_exists(FCPATH . $attachmentPath)) {
                unlink(FCPATH . $attachmentPath);
            }

            // 新檔名
            $newName = $file->getRandomName();

            // 移動新檔案
            $file->move($uploadPath, $newName);

            // 儲存新路徑
            $attachmentPath = 'uploads/announcements/' . $newName;
        }

        // =========================
        // 狀態
        // =========================

        if ($announcement['status'] === 'published') {

            // 已發布公告不能回到草稿
            $status = 'published';

        } else {

            $status = $this->request->getPost('status');

            if (!in_array($status, ['draft', 'published'])) {
                $status = 'draft';
            }
        }

        // =========================
        // 發布時間
        // =========================

        $publishDate = ($status === 'published')
            ? date('Y-m-d H:i:s')
            : null;

        // =========================
        // 更新資料
        // =========================

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'type'         => $type,
            'content'      => ($type === '一般公告')
                                ? $this->request->getPost('content')
                                : null,
            'attachment'   => ($type === '超連結')
                                ? null
                                : $attachmentPath,
            'external_url' => ($type === '超連結')
                                ? $this->request->getPost('external_url')
                                : null,
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

        // 若公告有 PDF 附件，順便刪除實體檔案
        if (!empty($announcement['attachment']) && file_exists(FCPATH . $announcement['attachment'])) {
            unlink(FCPATH . $announcement['attachment']);
        }

        // 刪除資料庫紀錄
        $this->announcementModel->delete($id);

        return redirect()->to('/admin/announcement')->with('success', '公告已成功刪除');
    }

    // 公告詳細內容與外部跳轉
    public function detail($id = null)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement || $announcement['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 1. 取得 Navbar 頁面設定
        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');
        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        // 2. 取得 Sidebar 頁面與群組設定
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

        // 3. 取得首頁跑馬燈
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