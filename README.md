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

For a coordinated local kernel checkout, configure a Composer path repository in a private manifest; do not commit local filesystem paths. The sibling installer `tests/integration.php` exercises local skeleton/framework integration automatically. The maintained reference is `../docs/guide/index.html` in the five-repository workspace. Review the kernel's `UPGRADE.md` before adopting its unpublished changes.
