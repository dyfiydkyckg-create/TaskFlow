<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

$errors = [];
$values = ['title'=>'', 'description'=>'', 'status'=>'pending', 'priority'=>'medium', 'due_date'=>''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $result = valid_task_data($_POST);
    $values = $result['data'];
    $errors = $result['errors'];
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO tasks (title, description, status, priority, due_date) VALUES (:title, :description, :status, :priority, :due_date)');
        $stmt->execute($values);
        flash('success', 'کار جدید با موفقیت ساخته شد.');
        redirect('index.php');
    }
}
$pageTitle = 'افزودن کار';
require __DIR__ . '/includes/header.php';
?>
<section class="form-page">
<a class="back-link" href="index.php">→ بازگشت به داشبورد</a>
<div class="form-heading"><span class="eyebrow">یک شروع تازه</span><h1>کار جدید بساز<span>.</span></h1><p>جزئیات کارت را وارد کن تا به فهرستت اضافه شود.</p></div>
<?php if ($errors): ?><div class="alert alert-error"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="task-form" method="post">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>عنوان کار <span class="required">*</span><input type="text" name="title" maxlength="160" required value="<?= e($values['title']) ?>" placeholder="مثلاً: تکمیل صفحه اصلی وب‌سایت"></label>
<label>توضیحات<textarea name="description" rows="4" placeholder="جزئیات بیشتری درباره این کار بنویس..."><?= e($values['description']) ?></textarea></label>
<div class="form-row">
<label>وضعیت<select name="status"><option value="pending" <?= $values['status']==='pending'?'selected':'' ?>>در انتظار</option><option value="in_progress" <?= $values['status']==='in_progress'?'selected':'' ?>>در حال انجام</option><option value="completed" <?= $values['status']==='completed'?'selected':'' ?>>تکمیل‌شده</option></select></label>
<label>اولویت<select name="priority"><option value="low" <?= $values['priority']==='low'?'selected':'' ?>>کم</option><option value="medium" <?= $values['priority']==='medium'?'selected':'' ?>>متوسط</option><option value="high" <?= $values['priority']==='high'?'selected':'' ?>>زیاد</option></select></label>
</div>
<label>تاریخ سررسید <span class="optional">(اختیاری)</span><input type="date" name="due_date" value="<?= e($values['due_date'] ?? '') ?>"></label>
<div class="form-actions"><button class="button button-primary" type="submit">ساخت کار</button><a class="button button-ghost" href="index.php">انصراف</a></div>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
