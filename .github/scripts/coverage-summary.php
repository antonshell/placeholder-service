<?php

/**
 * Renders a PHPUnit clover report as a GitHub-flavoured markdown summary.
 * Usage: php coverage-summary.php var/coverage/php.xml [title] >> "$GITHUB_STEP_SUMMARY"
 */

declare(strict_types=1);

$file = $argv[1] ?? 'var/coverage/php.xml';
$title = $argv[2] ?? 'Code coverage';

$xml = simplexml_load_file($file);
if (false === $xml) {
    fwrite(STDERR, "Cannot read {$file}\n");
    exit(1);
}

$percent = static function (int $covered, int $total): string {
    return $total > 0 ? number_format($covered / $total * 100, 2) . '%' : 'n/a';
};
$badge = static function (int $covered, int $total): string {
    if (0 === $total) {
        return '⚪';
    }
    $p = $covered / $total * 100;

    return $p >= 95 ? '🟢' : ($p >= 80 ? '🟡' : '🔴');
};

$m = $xml->project->metrics;
$lines = [(int) $m['coveredstatements'], (int) $m['statements']];
$methods = [(int) $m['coveredmethods'], (int) $m['methods']];

$root = rtrim((string) getenv('GITHUB_WORKSPACE') ?: getcwd(), '/') . '/';

$rows = [];
foreach ($xml->xpath('//file') as $f) {
    $fm = $f->metrics;
    $fl = [(int) $fm['coveredstatements'], (int) $fm['statements']];
    $fmt = [(int) $fm['coveredmethods'], (int) $fm['methods']];
    $rows[str_replace($root, '', (string) $f['name'])] = sprintf(
        '| %s `%s` | %s | %d / %d | %s |',
        $badge(...$fl),
        str_replace($root, '', (string) $f['name']),
        $percent(...$fl),
        $fl[0],
        $fl[1],
        $percent(...$fmt),
    );
}
ksort($rows);

$out = [];
$out[] = "### {$title}";
$out[] = '';
$out[] = '| Metric | Coverage | Covered / Total |';
$out[] = '|:--|--:|--:|';
$out[] = sprintf('| %s Lines | **%s** | %d / %d |', $badge(...$lines), $percent(...$lines), ...$lines);
$out[] = sprintf('| %s Methods | **%s** | %d / %d |', $badge(...$methods), $percent(...$methods), ...$methods);
$out[] = '';
$out[] = '<details><summary>Coverage by file</summary>';
$out[] = '';
$out[] = '| File | Lines | Covered / Total | Methods |';
$out[] = '|:--|--:|--:|--:|';
array_push($out, ...array_values($rows));
$out[] = '';
$out[] = '</details>';
$out[] = '';

echo implode("\n", $out) . "\n";
