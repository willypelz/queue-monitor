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
| 1.x     | 10-11   | ^8.1   | Active       |

## Upgrade Guide

### From 0.x to 1.0

This is the initial release. No upgrade path needed.

## Support

For issues, please visit: [GitHub Issues](https://github.com/willypelz/queue-monitor/issues)

For questions, please visit: [GitHub Discussions](https://github.com/willypelz/queue-monitor/discussions)

