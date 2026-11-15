<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $location): never {
    header('Location: ' . $location);
    exit;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): void {
    $submitted = $_POST['csrf_token'] ?? '';
    $known = $_SESSION['csrf_token'] ?? '';
    if (!is_string($submitted) || !is_string($known) || $known === '' || !hash_equals($known, $submitted)) {
        http_response_code(403);
        exit('درخواست معتبر نیست. صفحه را تازه‌سازی کنید و دوباره تلاش کنید.');
    }
}

function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function pull_flash(): ?array {
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_array($message) ? $message : null;
}

function valid_task_data(array $input): array {
    $title = trim((string)($input['title'] ?? ''));
    $description = trim((string)($input['description'] ?? ''));
    $status = (string)($input['status'] ?? 'pending');
    $priority = (string)($input['priority'] ?? 'medium');
    $dueDate = trim((string)($input['due_date'] ?? ''));
    $errors = [];

    if ($title === '') $errors[] = 'عنوان کار الزامی است.';
    elseif (mb_strlen($title) > 160) $errors[] = 'عنوان نباید بیشتر از ۱۶۰ کاراکتر باشد.';
    if (!in_array($status, ['pending', 'in_progress', 'completed'], true)) $errors[] = 'وضعیت انتخاب‌شده معتبر نیست.';
    if (!in_array($priority, ['low', 'medium', 'high'], true)) $errors[] = 'اولویت انتخاب‌شده معتبر نیست.';
    if ($dueDate !== '') {
        $date = DateTime::createFromFormat('Y-m-d', $dueDate);
        if (!$date || $date->format('Y-m-d') !== $dueDate) $errors[] = 'تاریخ سررسید معتبر نیست.';
    }

    return ['data' => [
        'title' => $title, 'description' => $description, 'status' => $status,
        'priority' => $priority, 'due_date' => $dueDate !== '' ? $dueDate : null,
    ], 'errors' => $errors];
}

function status_label(string $status): string {
    return ['pending' => 'در انتظار', 'in_progress' => 'در حال انجام', 'completed' => 'تکمیل‌شده'][$status] ?? 'نامشخص';
}
function priority_label(string $priority): string {
    return ['low' => 'کم', 'medium' => 'متوسط', 'high' => 'زیاد'][$priority] ?? 'متوسط';
}

/**
 * Shared overdue rule: a task is overdue when it is not completed and its due date is before today.
 * Keep SQL filtering, dashboard counts, severity, and task highlighting aligned through this predicate.
 */
function overdue_sql_condition(string $tableAlias = 'tasks'): string {
    if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $tableAlias)) {
        throw new InvalidArgumentException('Invalid SQL table alias.');
    }
    return "{$tableAlias}.status <> 'completed' AND {$tableAlias}.due_date IS NOT NULL AND {$tableAlias}.due_date < CURDATE()";
}
