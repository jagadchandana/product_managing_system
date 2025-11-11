API documentation setup (l5-swagger)

Steps to install and generate API docs using l5-swagger (darkaonline/l5-swagger):

1) Install the package via composer:

   composer require "darkaonline/l5-swagger"

2) Publish the configuration and views:

   php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

3) Configure (optional):

   - Edit `config/l5-swagger.php` if you want to change the documentation route or scan paths.
   - By default l5-swagger will scan `app/` for OpenAPI annotations. We added annotations to:
       - `app/Http/Controllers/Api/AuthController.php`
       - `app/Http/Controllers/Api/ProductApiController.php`
       - `app/Http/Controllers/Api/SwaggerInfo.php`

4) Generate the documentation JSON:

   php artisan l5-swagger:generate

5) View the Swagger UI in the browser:

   By default visit: /api/documentation

Notes and hints

- Ensure you have set a `JWT_SECRET` in your `.env` for the API auth to work.
- The API endpoints require the `Authorization: Bearer <token>` header. Use the `/api/auth/login` endpoint to obtain a token.
- If you add new annotations, re-run the generate command.

Examples

- Get token:
  POST /api/auth/login
  Content-Type: application/json
  Body: { "email": "user@example.com", "password": "secret" }

- List products:
  GET /api/products
  Header: Authorization: Bearer <token>

- Get product:
  GET /api/products/1
  Header: Authorization: Bearer <token>
