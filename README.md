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
| Auth | POST |  /auth/login | 
| Products | POST |  /products | 
| Products | GET |  /products | 
| Products | POST |  /products/{id} | 
| Products | DEL |  /products/{id} | 
| Cart | POST |  /cart | 
| Cart | PUT |  /cart/{id} | 
| Cart | DEL |  /cart/{id} | 
| Cart | GET |  /cart | 

