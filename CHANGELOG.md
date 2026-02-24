# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned Features
- Webhooks for queue events
- Email/Slack notifications for failures
- Advanced filtering in dashboard
- Job replay functionality
- Real-time websocket updates
- Queue comparison charts
- Custom metric definitions

## [1.1.0] - 2026-02-24

### Added
- Laravel 12 support
- PHPUnit 11 support
- PHP 8.4 compatibility

### Changed
- **BREAKING**: Minimum PHP version raised from `^8.1` to `^8.2`
- Updated all Illuminate dependencies to support Laravel 10, 11, and 12
- Updated Orchestra Testbench to `^8.0|^9.0|^10.0`
- Updated PHPUnit to `^10.0|^11.0`
- Migrated test annotations from doc-comments to PHPUnit attributes
- Updated PHPUnit configuration to version 11.5 schema
- Improved test setup with `defineDatabaseMigrations()` method

### Fixed
- Test migration loading in Laravel 12
- PHPUnit deprecation warnings

## [1.0.0] - 2026-02-24

### Added
- Initial release
- Real-time queue monitoring dashboard
- Database driver support
- Job tracking (processing, processed, failed)
- Runtime metrics and statistics
- Queue control operations:
  - Pause/Resume queues
  - Throttle rate limiting
  - Retry failed jobs
- Queue control middleware
- RESTful API endpoints
- Automatic job event listeners
- Configurable data retention
- Prune command for cleanup
- Install command for easy setup
- Metrics aggregation for performance
- Comprehensive documentation
- PHPUnit test suite
- Vue.js 3 dashboard UI
- Indexed database tables for performance
- Multi-queue support
- Multi-connection support

### Security
- Configurable middleware protection
- CSRF token support
- Role-based access control compatible

## Version Support

| Version | Laravel | PHP    | Status       |
|---------|---------|--------|--------------|
| 1.1.x   | 10-12   | ^8.2   | Active       |
| 1.0.x   | 10-11   | ^8.1   | Deprecated   |

## Upgrade Guide

### From 1.0 to 1.1

1. **Update PHP version**: Ensure your application runs PHP 8.2 or higher
2. **Update dependencies**: Run `composer update willypelz/queue-monitor`
3. **Run tests**: Test your application thoroughly with the new version
4. **Update test annotations** (if you have custom tests): Replace `/** @test */` with `#[Test]` attribute

See [LARAVEL_12_UPGRADE.md](LARAVEL_12_UPGRADE.md) for detailed upgrade information.

### From 0.x to 1.0

This is the initial release. No upgrade path needed.

## Support

For issues, please visit: [GitHub Issues](https://github.com/willypelz/queue-monitor/issues)

For questions, please visit: [GitHub Discussions](https://github.com/willypelz/queue-monitor/discussions)

