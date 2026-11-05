<?php

// CI-only Composer overlay. The release manifest and lock file remain untouched.
$root = dirname(__DIR__, 2);
$command = $argv[1] ?? '';
$framework = isset($argv[2]) ? realpath($argv[2]) : false;
if (! in_array($command, ['prepare', 'verify'], true) || $framework === false || ! is_file($framework.'/composer.json')) {
    fwrite(STDERR, "Usage: php .github/scripts/framework-checkout.php prepare|verify /path/to/framework\n");
    exit(1);
}

try {
    $package = json_decode(file_get_contents($framework.'/composer.json'), true, 512, JSON_THROW_ON_ERROR);
    if (($package['name'] ?? null) !== 'nour-api/framework') {
        throw new RuntimeException('The supplied checkout is not nour-api/framework.');
    }
    if ($command === 'prepare') {
        $manifest = json_decode(file_get_contents($root.'/composer.json'), true, 512, JSON_THROW_ON_ERROR);
        $manifest['repositories'] = array_merge([[
            'type' => 'path',
            'url' => $framework,
            'canonical' => true,
            'options' => ['symlink' => true, 'versions' => ['nour-api/framework' => '2.1.1']],
        ]], $manifest['repositories'] ?? []);
        $json = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)."\n";
        if (file_put_contents($root.'/composer.ci.json', $json) !== strlen($json)) {
            throw new RuntimeException('Could not write the CI-only Composer manifest.');
        }
        echo "Prepared composer.ci.json using the checked-out framework.\n";
    } else {
        require $root.'/vendor/autoload.php';
        $installed = Composer\InstalledVersions::isInstalled('nour-api/framework')
            ? Composer\InstalledVersions::getInstallPath('nour-api/framework') : null;
        if (! is_string($installed) || realpath($installed) !== $framework) {
            throw new RuntimeException('Composer must use the supplied framework checkout; a published or different source is not accepted.');
        }
        echo "PASS: installed framework resolves to the supplied checkout.\n";
    }
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage()."\n");
    exit(1);
}
