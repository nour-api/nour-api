# Changelog

## 2.2.0 — 2026-11-06

- Integrate Nour-API framework 2.2 and its corrected HTTP, provider, exception and logging lifecycles.
- Disable debug output by default and remove the example database password.
- Prefer bearer tokens in the optional authentication example while retaining legacy input compatibility.
- Test the application against the development framework and validate tagged releases using their production Composer dependencies.

Review the framework upgrade guide for named-route parameter encoding and error-response behavior changes. Runtime PHP remains ^8.2.
