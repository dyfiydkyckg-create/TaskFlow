<?php
$pageTitle = $pageTitle ?? 'داشبورد';
$flashMessage = pull_flash();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#101827">
    <meta name="description" content="TaskFlow؛ مدیریت ساده و منظم کارهای روزانه">
    <title><?= e($pageTitle) ?> | TaskFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-shell">
<header class="topbar">
    <a class="brand" href="index.php"><span class="brand-mark">T</span><span>Task<span class="brand-accent">Flow</span></span></a>
    <nav class="topnav" aria-label="منوی اصلی"><a class="nav-link active" href="index.php">داشبورد</a><a class="nav-link" href="https://github.com/dyfiydkyckg-create/TaskFlow" target="_blank" rel="noopener noreferrer">گیت‌هاب ↗</a></nav>
    <a class="topbar-cta" href="create.php">＋ کار جدید</a>
</header>
<main class="main-content">
<?php if ($flashMessage): ?>
<div class="alert alert-<?= e($flashMessage['type']) ?>" role="status"><?= e($flashMessage['message']) ?></div>
<?php endif; ?>
