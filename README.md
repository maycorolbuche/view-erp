# View Intranet

Sistema Intranet ViewFS

---

## Requisitos

Antes de iniciar, instale:

- PHP 8.2+
- Composer
- Node.js 20+
- NPM
- MySQL/MariaDB
- Git

---

## Instalar Dependências do Laravel

Instale as dependências PHP:

```bash
composer install
```

---

## Configurar Ambiente

Copie o arquivo `.env`:

```bash
cp .env.example .env
```

No Windows:

```bat
copy .env.example .env
```

---

## Configurar Banco de Dados

Edite o `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_banco
DB_USERNAME=root
DB_PASSWORD=
```

---

## Gerar APP_KEY

```bash
php artisan key:generate
```

---

## Rodar Migrations/Seeders

```bash
php artisan migrate --seed
```

---

## Instalar Dependências Frontend

Instale dependências do Vite/NPM:

```bash
npm install
```

---

## Rodar Ambiente de Desenvolvimento

## Terminal 1 — Laravel

```bash
php artisan serve
```

Aplicação:

```plaintext
http://127.0.0.1:8000
```

---

## Terminal 2 — Vite

```bash
npm run dev
```

O Vite ficará responsável por:

- CSS
- JS
- Hot Reload
- Bootstrap
- Bootstrap Icons

---

## Build de Produção

Gerar assets otimizados:

```bash
npm run build
```

Arquivos gerados:

```plaintext
public/build
```

---

## Estrutura Frontend

```plaintext
resources/
├── js/
│   └── app.js
├── scss/
│   ├── app.scss
```

---

## Bootstrap

Importação no `resources/js/app.js`:

```js
import './bootstrap';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
```

---

## Comandos Úteis

## Limpar cache Laravel

```bash
php artisan optimize:clear
```

---

## Limpar cache de configuração

```bash
php artisan config:clear
```

---

## Recriar autoload do Composer

```bash
composer dump-autoload
```

---

## Reinstalar dependências NPM

Linux/macOS:

```bash
rm -rf node_modules
rm package-lock.json

npm install
```

Windows:

```bat
rmdir /s /q node_modules
del package-lock.json

npm install
```

---

## Deploy Produção

Instalar dependências PHP sem dev:

```bash
composer install --no-dev --optimize-autoloader
```

Gerar build frontend:

```bash
npm install
npm run build
```

Cachear Laravel:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Permissões Linux

Caso necessário:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## Scheduler (Cron)

Adicionar no servidor:

```bash
* * * * * php /caminho-do-projeto/artisan schedule:run >> /dev/null 2>&1
```

---

## Queue Worker

Caso utilize filas:

```bash
php artisan queue:work
```

---

## Tecnologias Utilizadas

- Laravel
- Vite
- Bootstrap 5
- Bootstrap Icons
- MySQL
- PHP
- JavaScript

---
