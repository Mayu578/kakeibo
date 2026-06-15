cat << 'EOF' > render-deploy.sh
#!/bin/sh
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
apache2-foreground
EOF
chmod +x render-deploy.sh