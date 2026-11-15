<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(404); exit('کار موردنظر پیدا نشد.'); }
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
$stmt->execute(['id' => $id]);
$task = $stmt->fetch();
if (!$task) { http_response_code(404); exit('کار موردنظر پیدا نشد.'); }

$values = $task;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $result = valid_task_data($_POST);
    $values = $result['data'];
    $errors = $result['errors'];
    if (!$errors) {
        $update = $pdo->prepare('UPDATE tasks SET title=:title, description=:description, status=:status, priority=:priority, due_date=:due_date WHERE id=:id');
        $update->execute($values + ['id' => $id]);
        flash('success', 'تغییرات با موفقیت ذخیره شد.');
        redirect('index.php');
    }
}
$pageTitle = 'ویرایش کار';
require __DIR__ . '/includes/header.php';
?>
<section class="form-page">
<a class="back-link" href="index.php">→ بازگشت به داشبورد</a>
<div class="form-heading"><span class="eyebrow">به‌روزرسانی برنامه</span><h1>ویرایش کار<span>.</span></h1><p>هر تغییری لازم است اعمال کن و ذخیره کن.</p></div>
<?php if ($errors): ?><div class="alert alert-error"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="task-form" method="post">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>عنوان کار <span class="required">*</span><input type="text" name="title" maxlength="160" required value="<?= e($values['title']) ?>"></label>
<label>توضیحات<textarea name="description" rows="4"><?= e($values['description']) ?></textarea></label>
<div class="form-row">
<label>وضعیت<select name="status"><option value="pending" <?= $values['status']==='pending'?'selected':'' ?>>در انتظار</option><option value="in_progress" <?= $values['status']==='in_progress'?'selected':'' ?>>در حال انجام</option><option value="completed" <?= $values['status']==='completed'?'selected':'' ?>>تکمیل‌شده</option></select></label>
<label>اولویت<select name="priority"><option value="low" <?= $values['priority']==='low'?'selected':'' ?>>کم</option><option value="medium" <?= $values['priority']==='medium'?'selected':'' ?>>متوسط</option><option value="high" <?= $values['priority']==='high'?'selected':'' ?>>زیاد</option></select></label>
</div>
<label>تاریخ سررسید <span class="optional">(اختیاری)</span><input type="date" name="due_date" value="<?= e($values['due_date'] ?? '') ?>"></label>
<div class="form-actions"><button class="button button-primary" type="submit">ذخیره تغییرات</button><a class="button button-ghost" href="index.php">انصراف</a></div>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
