# Nour-API PHP Framework


Nour-API is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Nour-API attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.


## Official Documentation
[Nour-API Documentations](https://nour-api.github.io/docs/)

## Contributing


## Security Vulnerabilities


## License

The Nour-API framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Local development

Requires PHP `^8.2`, Composer 2.2+, and extensions checked by `composer check-platform-reqs`. Serve only `public/`:

```sh
composer install
cp .env.example .env
php -S localhost:8000 -t public
composer test
```

Direct Composer installation copies `.env.example` but does not generate an encryption key. Set `APP_KEY` to `base64:` followed by 32 cryptographically random bytes encoded as base64 before using encryption. The installer fills a blank key automatically. Keep `.env` private and out of Git; do not replace a key protecting existing encrypted data. `APP_DEBUG` defaults to false; enable it only for local debugging.

Register routes in `routes/web.php`, providers/middleware in `bootstrap/app.php`, and custom commands in `app/Console/Kernel.php`. Optional Eloquent and facades are enabled in bootstrap. The sample authentication provider prefers bearer tokens and retains legacy `api_token` input; implement hashed, expiring tokens and your own schema before production use.

For a coordinated local kernel checkout, configure a Composer path repository in a private manifest; do not commit local filesystem paths. The sibling installer `tests/integration.php` exercises local skeleton/framework integration automatically. The maintained reference is `../docs/guide/index.html` in the five-repository workspace. Review the kernel's `UPGRADE.md` when upgrading.

## Development integration CI

The development workflow checks out this application and `nour-api/framework` from `dev`, then runs the application tests and Artisan on PHP 8.2–8.5. A CI-only Composer path repository selects the checked-out kernel; an explicit check rejects a published package or a different checkout. The framework commit is recorded in the run log.

To reproduce this with sibling local checkouts:

```sh
php .github/scripts/framework-checkout.php prepare ../framework
COMPOSER=composer.ci.json composer install --no-interaction --prefer-dist --no-plugins --no-scripts
php .github/scripts/framework-checkout.php verify ../framework
COMPOSER=composer.ci.json composer --no-plugins test -- --fail-on-risky --fail-on-warning
php artisan list --raw
```

The generated `composer.ci.json` and `composer.ci.lock` are ignored. The release `composer.json` and `composer.lock` stay unchanged. The `2.2.0` path-package alias satisfies the framework version constraint only for this development check; it does not create a release.

Runs start on pushes to `dev` and pull requests, with a manual dispatch trigger also declared. A framework-only push does not automatically trigger this repository: rerun the integration workflow after coordinated framework changes. Each result covers the application and framework commits checked out by that run.

## Release publication

Development kernels on `dev` also provide an optional async HTTP entry point: run `vendor/bin/nour-serve` from the project directory after selecting the development framework through the CI Composer overlay above. It requires CLI Swoole 6.x and isolates each request in a separate process. The existing `public/index.php`, PHP-FPM and `php -S localhost:8000 -t public` modes remain supported without Swoole. See the kernel's `ASYNC.md` for concurrent I/O, limits and unsupported streaming/native CLI HTTP APIs. These additions are not in published framework 2.2.0.

Stable `v*` tags run the release verification workflow before a GitHub Release is created. Package discovery through Packagist depends on its configured repository integration; publication is verified against the registry before dependent package releases are advanced. No API keys are stored in the repository.

If registry indexing is delayed, clone the application tag `v2.2.0` from GitHub and run `composer install`. The production lock references framework `v2.2.0` directly; no local path repository is present. Wait for registry indexing before using `composer update`.
