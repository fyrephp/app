# Changelog

This file records user-visible changes to the FyrePHP application skeleton. Internal refactors, test-only changes, and other changes that do not affect users are omitted.

## 1.0.3 - 2026-10-07

### Changed

- Require FyreFramework 1.2 or later and update the locked framework dependency to 1.2.0.
- Configure a separate test database through `TEST_DB_*` environment settings.
- Move the application boot call to the HTTP and CLI entry points so tests can apply settings before boot.

### Fixed

- Apply test connection aliases and disable cache before the custom application boot hook.
- Disable CLI error rendering for HTTP integration tests while preserving PHPUnit's PHP error handling.

## 1.0.2 - 2026-09-27

### Changed

- Updated the locked FyreFramework dependency to 1.1.0 and refreshed development dependencies.

## 1.0.1 - 2026-09-20

### Changed

- Updated the locked FyreFramework dependency to 1.0.1 and refreshed development dependencies.

### Fixed

- Load application bootstrap before calling the custom application boot hook.
- Exclude runtime directories from PHP CS Fixer checks.

## 1.0.0 - 2026-09-13

### Added

- Initial stable release of the application skeleton for FyreFramework 1.0.
