# Demo Center Netskope — Partner Edition

Portal web de demos de Netskope (LATAM), en **español**. Es HTML/PHP estático: no hay base de datos, Composer ni Node en runtime.

Esta edición de partner:

- Solo idioma español (sin selector PT-BR).
- Borderbot / AWS Bedrock **deshabilitado** (`api/demo-chat.php` responde 404).
- Sección Agentic / MCP **oculta** en el HTML.
- No incluye credenciales de AWS ni el archivo `/etc/demo-chat.env`.

Uso previsto: copiar este árbol al document root de un servidor web y servir `index.php`.

---

## 1. Requisitos de hardware

El sitio pesa poco (~8 MB). Los mínimos de abajo dejan holgura para el SO, logs, actualizaciones y demos en paralelo.

| Recurso | Mínimo | Ideal |
|---|---|---|
| CPU | 1 vCPU | 2 vCPU |
| RAM | 2 GB | 4 GB |
| Disco | 40 GB | 120 GB |
| Red | 100 Mbps | 1 Gbps |
| Resolución de demo | 1366×768 | 1920×1080 (laptop del SE) |

No hace falta GPU, ni cola de workers, ni disco SSD de alto IOPS.

**Lab RDP / sillas Cursor (opcional, no viene en este repo).** El portal original consulta un host Windows interno (`10.1.10.203:18080`) y enlaces RDP en `10.1.10.x`. Eso es infraestructura del lab LATAM, no se instala con este código. Si el partner no tiene ese lab, el tablero de sillas muestra error controlado y el resto del sitio funciona.

---

## 2. Requisitos de software (sistema)

Probado con PHP 8.x. El código usa tipos escalares (`string`, `int`, `void`) → **PHP 7.4 o superior**. Recomendado **PHP 8.1+**.

| Pieza | Versión | Para qué |
|---|---|---|
| Sistema operativo | Ubuntu 22.04 / 24.04 LTS (o equivalente RHEL 9) | Servidor web |
| nginx | 1.18+ | HTTP(S). Apache 2.4 también sirve |
| PHP-FPM | 8.1+ | Ejecutar `*.php` |
| Git | 2.x | Clonar este repositorio |
| Certificado TLS | Let's Encrypt u otro | HTTPS en demos con cliente |
| Navegador | Chrome / Edge recientes | Conducir la demo |

**No se necesita:** MySQL/PostgreSQL, Redis, Node.js, Python, Composer, npm, Docker, AWS CLI, Bedrock, ni Java.

### Paquetes a instalar (Ubuntu / Debian)

```bash
sudo apt update
sudo apt install -y nginx php-fpm php-cli git curl unzip
```

En Ubuntu 24.04 eso suele traer PHP 8.3. Comprueba:

```bash
php -v
php-fpm -v
nginx -v
```

Extensiones PHP usadas (vienen en el paquete por defecto):

- `json`
- `fileinfo` (imágenes)
- wrapper HTTP de `file_get_contents` (`allow_url_fopen = On` en `php.ini`, valor por defecto)

Opcional, solo si quieren HTTPS con Let's Encrypt:

```bash
sudo apt install -y certbot python3-certbot-nginx
```

### Red y firewall

| Puerto | Dirección | Uso |
|---|---|---|
| 80 / 443 | Entrada | Sitio público |
| 22 | Entrada (admin) | SSH |
| Salida 443 | Hacia Internet | CDNs (ver abajo) |

Varias páginas cargan CSS/JS desde Internet. El servidor **y** la laptop de la demo necesitan salida HTTPS a:

- `cdn.tailwindcss.com`
- `unpkg.com`
- `cdn.jsdelivr.net` (Chart.js en reportes)
- `fonts.googleapis.com` / `fonts.gstatic.com`

Si el partner bloquea CDNs, esas páginas se verán sin estilos o sin gráficas. `index.php`, `demos.php` y `keydifferentiators.php` también referencian `assets/vendor/` (copia local de Tailwind/Lucide/fuentes) que **no está en este árbol**; el CSS crítico va inline, así que la portada igual se ve, pero pueden faltar algunos íconos.

---

## 3. Instalación

Sustituye `TU_DOMINIO` y la ruta si usas otra.

```bash
sudo mkdir -p /var/www/democenter
sudo git clone https://github.com/lmatus-nsk/democenter-partner-edition.git /var/www/democenter

sudo chown -R www-data:www-data /var/www/democenter
```

Copia el ejemplo de nginx:

```bash
sudo cp /var/www/democenter/deploy/nginx.conf.example /etc/nginx/sites-available/democenter
sudo nano /etc/nginx/sites-available/democenter   # cambia server_name y root
sudo ln -s /etc/nginx/sites-available/democenter /etc/nginx/sites-enabled/democenter
sudo nginx -t && sudo systemctl reload nginx
```

Ajusta el socket de PHP-FPM si tu distro no usa `/run/php/php-fpm.sock` (por ejemplo `/run/php/php8.3-fpm.sock`).

HTTPS:

```bash
sudo certbot --nginx -d TU_DOMINIO
```

### Comprobar

1. Abre `https://TU_DOMINIO/` → landing en español, **sin** botones ES/PT-BR.
2. Entra a **¿Quieres verlo en directo?** → `demos.php`.
3. Recorre las tarjetas (navegación, dato, VPN, IA, red).
4. `https://TU_DOMINIO/api/demo-chat.php` debe devolver **404** (Borderbot apagado a propósito).
5. `https://TU_DOMINIO/api/seats.php` puede devolver 502 si no hay lab Windows; es esperado.

Prueba rápida en el propio servidor:

```bash
cd /var/www/democenter
php -S 127.0.0.1:8003
# luego: curl -I http://127.0.0.1:8003/index.php
```

---

## 4. Qué hay en el árbol

```
index.php                 Landing
demos.php                 Portal de demos (hub)
keydifferentiators.php    ¿Quién es Netskope?
navigationevolution.php
dataprotection.php
vpnevolution.php
aicontrol.php
networktransformation.php
customerreferences.php
reportai.php / reportit.php
oopsyoudidit.php          Página de coaching / bloqueo
api/seats.php             Proxy opcional al lab Windows
api/demo-chat.php         Deshabilitado (404)
assets/                   CSS, JS, JSON, imágenes
deploy/nginx.conf.example
```

No hay `.env`, no hay base de datos que crear, no hay migraciones.

---

## 5. Seguridad al publicar

- No subir `/etc/demo-chat.env` ni keys de AWS (esta edición no las usa).
- No dejar `*.bak`, `.tgz` ni backups dentro del document root.
- nginx del ejemplo ya deniega `*.bak`, `*.tgz`, `*.env`.
- El sitio no tiene autenticación: trátalo como portal de demo, no como intranet con secretos.

---

## 6. Licencia

Código propietario de Netskope. Uso limitado al partner autorizado. No redistribuir ni publicar como open source.
