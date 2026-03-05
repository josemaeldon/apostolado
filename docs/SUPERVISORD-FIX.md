# Fix for Supervisord Privilege Dropping Error

## Problem
The application was failing to start in Docker with the error:
```
Error: Can't drop privilege as nonroot user
For help, use /usr/bin/supervisord -h
```

## Root Cause
The issue occurred because:
1. The Dockerfile creates and switches to a non-root user `laravel` (UID 1000)
2. The supervisord configuration file had `user=root` directive
3. When supervisord runs as the `laravel` user (non-root), it tries to drop privileges to `root`
4. A non-root user cannot escalate privileges or change to another user, causing the error

## Solution

### 1. Fixed supervisord.conf
**File:** `docker/supervisor/supervisord.conf`

**Change:** Removed the `user=root` line from the `[supervisord]` section

**Before:**
```ini
[supervisord]
nodaemon=true
user=root
logfile=/tmp/supervisord.log
pidfile=/tmp/supervisord.pid
```

**After:**
```ini
[supervisord]
nodaemon=true
logfile=/tmp/supervisord.log
pidfile=/tmp/supervisord.pid
```

### 2. Fixed nginx log paths
**File:** `docker/nginx/nginx.conf`

**Change:** Updated nginx to write logs to `/tmp` instead of `/var/log/nginx/` since the `laravel` user doesn't have write permissions to `/var/log/nginx/`

**Changes:**
- `error_log /var/log/nginx/error.log` → `error_log /tmp/nginx_error.log`
- `access_log /var/log/nginx/access.log` → `access_log /tmp/nginx_access.log`

### 3. Updated Dockerfile
**File:** `Dockerfile`

**Change:** Added creation of writable directories for nginx and supervisor with proper ownership

**Added:**
```dockerfile
&& mkdir -p /tmp/nginx /tmp/supervisor \
&& chown -R laravel:laravel /tmp/nginx /tmp/supervisor
```

### 4. Created Docker Swarm Stack File
**File:** `docker-stack.yml`

**Purpose:** Provides a production-ready Docker Swarm deployment configuration

**Key fixes:**
- Corrected `working_dir` from `/var/www` to `/var/www/html` (matching Dockerfile)
- Corrected volume paths from `/var/www/storage` to `/var/www/html/storage`
- Corrected volume paths from `/var/www/bootstrap/cache` to `/var/www/html/bootstrap/cache`
- Includes Traefik labels for automatic SSL and routing

### 5. Updated Documentation
**File:** `DEPLOYMENT.md`

**Change:** Added comprehensive Docker Swarm deployment instructions

## Testing

To test these changes:

1. **Build the Docker image:**
   ```bash
   docker build -t apostolado:test .
   ```

2. **Run a test container:**
   ```bash
   docker run --rm -p 8080:80 apostolado:test
   ```

3. **Verify no errors in logs:**
   ```bash
   docker logs <container-id>
   ```

4. **For Docker Swarm deployment:**
   ```bash
   docker stack deploy -c docker-stack.yml apostolado
   docker service logs apostolado_app
   ```

## Why This Works

1. **Supervisord no longer tries to drop privileges** - Since the container already runs as the `laravel` user and supervisord config doesn't specify a user, supervisord runs all processes as the current user (`laravel`)

2. **nginx runs as laravel user** - The nginx.conf already had `user laravel;` configured, so nginx processes run as the `laravel` user

3. **php-fpm runs as laravel user** - By default, php-fpm runs as the user who starts it, which is `laravel`

4. **All services have write permissions** - `/tmp` is writable by all users, so logs can be written successfully

## Security Benefits

Running as a non-root user provides better security:
- Limits potential damage if the container is compromised
- Follows the principle of least privilege
- Prevents privilege escalation attacks
- Complies with container security best practices

## Additional Notes

- The image continues to use the `laravel` user (UID 1000) as designed
- All processes (supervisord, nginx, php-fpm) run as the `laravel` user
- Log files are redirected to stdout/stderr for better container logging
- Volume mounts maintain proper permissions with the `laravel` user
