# DevContainer Port Configuration

## Port Mapping Overview

### External Access Ports (from host machine)
- **8445** → Main application (HTTPS/SSL)
- **3307** → MySQL database

### Internal Container Ports
- **6005** → Laravel development server (internal)
- **6001** → WebSocket server (internal)
- **9000** → PHP-FPM (internal, not used in current setup)

## Service Configuration

### Docker Compose (.devcontainer/docker-compose.yml)
```yaml
services:
  app:
    ports:
      - "8445:443"  # Main app access

  db:
    ports:
      - "3307:3306"  # MySQL access
```

### Supervisor Services (.devcontainer/supervisord.conf)
```ini
[program:laravel-server]
command=/usr/bin/php /workspaces/artisan serve --host=0.0.0.0 --port=6005

[program:websockets]
command=/usr/bin/php /workspaces/artisan websockets:serve --host=0.0.0.0 --port=6001
```

### Nginx Configuration (.devcontainer/nginx.conf)
```nginx
server {
    listen 443 ssl;  # External SSL port
    # Proxies to Laravel server on port 6005
    # WebSocket proxy for /app/ routes to port 6001
}
```

### Environment Configuration (.env)
```bash
APP_URL=https://localhost:8445
DB_HOST=db  # Docker service name
LARAVEL_WEBSOCKETS_PORT=6001
WEBSOCKET_PORT=6001
MIX_WEBSOCKET_PORT=6001
```

## Access URLs

- **Application**: https://localhost:8445
- **Database**: localhost:3307 (MySQL)
- **WebSocket**: wss://localhost:8445/app/ (proxied through nginx)

## Architecture Flow

1. **External requests** → Port 8445 (nginx with SSL)
2. **Regular HTTP requests** → Proxied to Laravel server on port 6005
3. **WebSocket requests** → Proxied to WebSocket server on port 6001
4. **Database requests** → Connect to `db` service on port 3306 (exposed as 3307 externally)

## Notes

- All ports are configured to avoid conflicts with common development ports
- SSL certificates are self-signed for development
- WebSocket connections are properly proxied through nginx with upgrade headers
- Database connection uses Docker service name `db` for internal networking