# Case Study
---

## Project Seup
- Clone the repository
- Run composer install
- Setup env
- Run php artisan migrate
- Run php artisan test to run tests (phpunit is configured to use sqlite for database. Make sure to run migrations before running tests)

## Endpoints
| Module | Method | Endpoint |
| ------ | ------ | ------ |
| Auth | POST |  /api/auth/login | 
| Products | POST |  /api/products | 
| Products | GET |  /api/products | 
| Products | POST |  /api/products/{id} | 
| Products | DEL |  /api/products/{id} | 
| Cart | POST |  /api/cart | 
| Cart | PUT |  /api/cart/{id} | 
| Cart | DEL |  /api/cart/{id} | 
| Cart | GET |  /api/cart | 

