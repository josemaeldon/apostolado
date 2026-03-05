# Fix for Nginx and PHP-FPM Permission Warnings

## Problem
The application was showing permission-related warnings and errors during startup:

```
nginx: [alert] could not open error log file: open() "/var/lib/nginx/logs/error.log" failed (13: Permission denied)
2026/02/06 17:32:24 [warn] 8#8: the "user" directive makes sense only if the master process runs with super-user privileges, ignored in /etc/nginx/nginx.conf:1
[06-Feb-2026 17:32:24] NOTICE: [pool www] 'user' directive is ignored when FPM is not running as root
[06-Feb-2026 17:32:24] NOTICE: [pool www] 'group' directive is ignored when FPM is not running as root
```

## Root Cause

### Nginx Error Log Permission Issue
- Alpine's nginx tries to open `/var/lib/nginx/logs/error.log` during its early startup phase, before parsing the configuration file
- The `laravel` user (UID 1000) didn't have write permissions to `/var/lib/nginx/logs/`
- Even though the nginx.conf redirects logs to `/tmp/nginx_error.log`, the early startup still tries the default location

### Nginx "user" Directive Warning
- The nginx.conf had `user laravel;` directive
- When nginx runs as non-root user, this directive is ignored and generates a warning
- This directive is only meaningful when nginx's master process runs as root

### PHP-FPM User/Group Warnings
- The default PHP-FPM `www.conf` includes `user = www-data` and `group = www-data` directives
- These directives are ignored when PHP-FPM is not running as root, generating NOTICE messages
- When running as non-root, PHP-FPM automatically runs as the user who started it

## Solution

### 1. Create nginx Log Directory with Proper Permissions
**File:** `Dockerfile`

**Change:** Added creation of `/var/lib/nginx/logs` directory with proper ownership

```dockerfile
&& mkdir -p /var/lib/nginx/logs \
&& chown -R laravel:laravel /tmp/nginx /tmp/supervisor /var/lib/nginx
```

**Why:** This ensures nginx can write to its default error log location during early startup, preventing the permission denied error.

### 2. Remove "user" Directive from nginx.conf
**File:** `docker/nginx/nginx.conf`

**Change:** Removed the `user laravel;` line from the beginning of the file

**Before:**
```nginx
user laravel;
worker_processes auto;
error_log /tmp/nginx_error.log warn;
```

**After:**
```nginx
worker_processes auto;
error_log /tmp/nginx_error.log warn;
```

**Why:** When running as non-root, the "user" directive is meaningless and generates a warning. Removing it eliminates the warning while maintaining the same behavior (nginx runs as the current user, which is `laravel`).

### 3. Replace PHP-FPM www.conf
**File:** `docker/php-fpm/www.conf` (new file)

**Change:** Created a custom PHP-FPM pool configuration without `user` and `group` directives

**Key points:**
- Removed `user = www-data` and `group = www-data` directives
- Added clear comments explaining why they're not set
- Configured proper logging to stderr/stdout
- Set appropriate process manager (pm) settings

**Dockerfile change:**
```dockerfile
# Remove default PHP-FPM www.conf and use custom one to avoid user/group warnings
RUN rm -f /usr/local/etc/php-fpm.d/www.conf
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
```

**Why:** By not setting the `user` and `group` directives, PHP-FPM won't generate warnings about them being ignored. The processes will run as the user who started them (`laravel`), which is the desired behavior.

## Results

After these changes:
1. ✅ Nginx error about `/var/lib/nginx/logs/error.log` is eliminated
2. ✅ Nginx "user" directive warning is eliminated
3. ✅ PHP-FPM user/group directive warnings are eliminated
4. ✅ All services continue to run as the `laravel` user (UID 1000)
5. ✅ No functionality is lost or changed

## Technical Details

### How nginx Logs Work
- During early startup, nginx tries to open its default error log location (`/var/lib/nginx/logs/error.log` on Alpine)
- After parsing the config file, it switches to the configured error log (`/tmp/nginx_error.log`)
- By creating and granting permissions to the default log directory, we prevent the early startup error

### How Non-Root User Directive Work
- When nginx/PHP-FPM run as non-root:
  - The `user` directive in nginx is ignored (with a warning if present)
  - The `user`/`group` directives in PHP-FPM are ignored (with NOTICE messages if present)
  - Both services run as the user who started them
- By not including these directives, we avoid the warnings while maintaining identical behavior

### Security Implications
These changes maintain the same security posture:
- All processes still run as the `laravel` user (UID 1000), not root
- No privilege escalation is possible
- The principle of least privilege is maintained
- Container security best practices are followed

## Testing

To verify these changes work correctly:

1. **Build the image:**
   ```bash
   docker build -t apostolado:test .
   ```

2. **Run a container:**
   ```bash
   docker run --rm -p 8080:80 apostolado:test
   ```

3. **Check the logs:**
   ```bash
   docker logs <container-id>
   ```

4. **Expected output:**
   - No "Permission denied" errors for nginx log files
   - No warnings about "user" directive in nginx
   - No NOTICE messages about user/group in PHP-FPM
   - Clean startup showing only:
     ```
     INFO supervisord started with pid 1
     INFO spawned: 'nginx' with pid X
     INFO spawned: 'php-fpm' with pid Y
     NOTICE: fpm is running, pid Y
     NOTICE: ready to handle connections
     INFO success: nginx entered RUNNING state
     INFO success: php-fpm entered RUNNING state
     ```

## Files Modified

1. `Dockerfile` - Added nginx log directory creation and custom PHP-FPM config
2. `docker/nginx/nginx.conf` - Removed `user laravel;` directive
3. `docker/php-fpm/www.conf` - New custom PHP-FPM pool configuration

## Backward Compatibility

These changes are fully backward compatible:
- All services run with the same user (`laravel`)
- Log output locations remain the same
- No changes to application functionality
- No changes to volume mount requirements
