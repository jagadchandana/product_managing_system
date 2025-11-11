<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Product API",
 *     version="1.0.0",
 *     description="API documentation for Product Management System"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class SwaggerInfo
{
    // This file only holds OpenAPI annotations for l5-swagger to discover.
}
