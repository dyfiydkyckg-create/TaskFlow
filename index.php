<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

$search = trim((string)($_GET['q'] ?? ''));
$statusFilter = (string)($_GET['status'] ?? 'all');
if (!in_array($statusFilter, ['all', 'pending', 'in_progress', 'completed'], true)) $statusFilter = 'all';

$sql = 'SELECT * FROM tasks WHERE 1 = 1';
$params = [];
if ($search !== '') {
    $sql .= ' AND (title LIKE :search_title OR description LIKE :search_description)';
    $params['search_title'] = '%' . $search . '%';
    $params['search_description'] = '%' . $search . '%';
}
if ($statusFilter !== 'all') {
    $sql .= ' AND status = :status';
    $params['status'] = $statusFilter;
}
$sql .= " ORDER BY FIELD(priority, 'high', 'medium', 'low'), CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, due_date ASC, created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tasks = $stmt->fetchAll();
$stats = $pdo->query("SELECT COUNT(*) AS total, SUM(status='pending') AS pending, SUM(status='in_progress') AS in_progress, SUM(status='completed') AS completed FROM tasks")->fetch();
$percent = (int)(($stats['total'] ?? 0) > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0);

$pageTitle = 'داشبورد';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
<div class="hero-copy">
<span class="eyebrow"><span class="eyebrow-dot"></span> فضای کاری شخصی شما</span>
<h1>کارهای بزرگ، با<br><span>قدم‌های کوچک.</span></h1>
<p>همه‌چیز را مرتب نگه دار، روی اولویت‌ها تمرکز کن و پیشرفتت را ببین.</p>
<a class="button button-primary" href="create.php">＋ افزودن کار جدید</a>
</div>
<div class="hero-art" aria-hidden="true"><div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
<div class="hero-card"><div class="hero-card-top"><span class="mini-icon">✦</span><span>تمرکز امروز</span></div><div class="hero-number"><?= (int)($stats['completed'] ?? 0) ?><small>کار تکمیل‌شده</small></div><div class="progress-track"><span style="width: <?= $percent ?>%"></span></div><div class="hero-card-foot"><span>ادامه بده!</span><span><?= $percent ?>٪</span></div></div>
<span class="float-star star-one">✳</span><span class="float-star star-two">✦</span></div>
</section>

<section class="stats-grid" aria-label="آمار کارها">
<article class="stat-card"><span class="stat-icon icon-total">▤</span><span class="stat-label">همه کارها</span><strong><?= (int)($stats['total'] ?? 0) ?></strong><small>مجموع وظایف</small></article>
<article class="stat-card"><span class="stat-icon icon-pending">◷</span><span class="stat-label">در انتظار</span><strong><?= (int)($stats['pending'] ?? 0) ?></strong><small>آماده شروع</small></article>
<article class="stat-card"><span class="stat-icon icon-progress">↗</span><span class="stat-label">در حال انجام</span><strong><?= (int)($stats['in_progress'] ?? 0) ?></strong><small>در مسیر پیشرفت</small></article>
<article class="stat-card"><span class="stat-icon icon-done">✓</span><span class="stat-label">تکمیل‌شده</span><strong><?= (int)($stats['completed'] ?? 0) ?></strong><small>یک قدم رو به جلو</small></article>
</section>

<section class="tasks-section">
<div class="section-heading"><div><span class="eyebrow">برنامه‌ریزی هوشمند</span><h2>فهرست کارها</h2></div><a class="button button-dark" href="create.php">＋ کار تازه</a></div>
<form class="toolbar" method="get" action="index.php">
<label class="search-box"><span>⌕</span><input type="search" name="q" value="<?= e($search) ?>" placeholder="جست‌وجو در کارها..."></label>
<select name="status" aria-label="فیلتر وضعیت"><option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>همه وضعیت‌ها</option><option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>در انتظار</option><option value="in_progress" <?= $statusFilter === 'in_progress' ? 'selected' : '' ?>>در حال انجام</option><option value="completed" <?= $statusFilter === 'completed' ? 'selected' : '' ?>>تکمیل‌شده</option></select>
<button class="button button-filter" type="submit">اعمال فیلتر</button>
</form>
<?php if (!$tasks): ?>
<div class="empty-state"><div class="empty-icon">✧</div><h3><?= $search !== '' ? 'چیزی پیدا نشد!' : 'هنوز کاری ثبت نکرده‌ای.' ?></h3><p><?= $search !== '' ? 'عبارت جست‌وجو یا فیلتر را تغییر بده.' : 'اولین کار را اضافه کن و برنامه‌ات را بساز.' ?></p><?php if ($search === '' && $statusFilter === 'all'): ?><a class="button button-primary" href="create.php">＋ ساخت اولین کار</a><?php endif; ?></div>
<?php else: ?>
<div class="task-list">
<?php foreach ($tasks as $task): ?>
<article class="task-card"><div class="task-main"><span class="task-priority priority-<?= e($task['priority']) ?>"></span><div class="task-copy"><h3><?= e($task['title']) ?></h3><?php if ($task['description'] !== ''): ?><p><?= e($task['description']) ?></p><?php endif; ?><div class="task-meta"><span class="status status-<?= e($task['status']) ?>"><?= e(status_label($task['status'])) ?></span><span class="priority-label">اولویت <?= e(priority_label($task['priority'])) ?></span><?php if ($task['due_date']): ?><span class="due-date">◷ <?= e($task['due_date']) ?></span><?php endif; ?></div></div></div>
<div class="task-actions"><a class="action-link" href="edit.php?id=<?= (int)$task['id'] ?>">ویرایش</a><form method="post" action="delete.php" onsubmit="return confirm('از حذف این کار مطمئن هستی؟');"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$task['id'] ?>"><button class="action-link action-delete" type="submit">حذف</button></form></div></article>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
