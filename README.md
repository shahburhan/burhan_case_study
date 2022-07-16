# Case Study
---

## Project Setup
- Clone the repository
- Run composer install
- Setup database in env
- Run php artisan migrate
- Run php artisan db:seed [^1]
- Run php artisan test to run tests (phpunit is configured to use sqlite for database. Make sure to run migrations before running tests)

## Endpoints
| Module | Method | Endpoint | Purpose |
| ------ | ------ | ------ | ------- |
| Auth | POST |  /api/auth/login | API to login using email/password and get token to subsequent calls if logged in. |
| Products | POST |  /api/products | API to create the product by category and store it in DB. |
| Products | GET |  /api/products | API to get the products |
| Products | POST |  /api/products/{product_id} | API to get a single product detail |
| Products | DEL |  /api/products/{product_id} | API to delete a product from the list |
| Cart | POST |  /api/cart/{product_id} | API to add cart items (guest and auth) |
| Cart | PUT |  /api/cart/{cart_item_id} | API to update existing cart items by session (guest and auth) |
| Cart | DEL |  /api/cart/{cart_item_id} | API to delete cart items (guest and auth) |
| Cart | GET |  /api/cart | API to show cart items (guest and auth) |

**You can use example@example.com as email and password as password for your auth test.**

## API Usage

1. **API to login using email/password and get token to subsequent calls if logged in.**

Request:

Method : *POST*

Data : email, password as params

Curl Example

```
curl --location --request POST 'http://{base_url}/api/auth/login?email=example@example.com&password=password' \

--header 'Accept: application/json'
```

Example Response:

```
{
    "token": "1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa"
}

```
---
2. **API to create the product by category and store it in DB.**

Request:

Method : *POST*

Data : email, password as params

Curl Example

```
curl --location --request POST 'http://{base_url}/api/products?name=example product&description=example description&price=10.99&category=example category' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "name": "example product",
    "user_id": 1,
    "category_id": 11,
    "description": "example description",
    "price": "10.99",
    "avatar": null,
    "id": 11
}

```
---
3. **API to get the products**

Request:

Method : *GET*

Curl Example

```
curl --location --request GET 'http://{base_url}/api/products' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "data": [
        {
            "id": 1,
            "name": "Voluptatem et.",
            "avatar": "avatars/",
            "category": "DodgerBlue",
            "description": "I never understood what it meant till now.' 'If that's all the same, shedding gallons of tears, but said nothing. 'When we were little,' the Mock Turtle persisted. 'How COULD he turn them out again.",
            "user": "Kari Welch"
        },
        {
            "id": 2,
            "name": "Mollitia in dicta.",
            "avatar": "avatars/",
            "category": "DodgerBlue",
            "description": "White Rabbit, 'but it doesn't matter which way I ought to go down the bottle, she found herself in a shrill, loud voice, and the little door was shut again, and made another rush at Alice as it.",
            "user": "Kari Welch"
        },
        {
            "id": 3,
            "name": "Harum occaecati.",
            "avatar": "avatars/",
            "category": "DodgerBlue",
            "description": "Rabbit in a hurried nervous manner, smiling at everything that was linked into hers began to say \"HOW DOTH THE LITTLE BUSY BEE,\" but it had made. 'He took me for asking! No, it'll never do to hold.",
            "user": "Kari Welch"
        },
        {
            "id": 4,
            "name": "Eveniet aut qui sit.",
            "avatar": "avatars/",
            "category": "LightYellow",
            "description": "The Cat seemed to rise like a candle. I wonder what Latitude or Longitude either, but thought they were filled with tears running down his face, as long as there seemed to be no chance of her age.",
            "user": "Kari Welch"
        },
        {
            "id": 5,
            "name": "Provident ducimus.",
            "avatar": "avatars/",
            "category": "SaddleBrown",
            "description": "As soon as there was nothing so VERY tired of being all alone here!' As she said to herself how she would catch a bad cold if she meant to take the hint; but the wise little Alice was more and more.",
            "user": "Kari Welch"
        },
        {
            "id": 6,
            "name": "Ab qui adipisci in.",
            "avatar": "avatars/",
            "category": "SaddleBrown",
            "description": "WAS a narrow escape!' said Alice, looking down at her side. She was looking up into the sea, 'and in that poky little house, and wondering what to beautify is, I can't tell you my.",
            "user": "Kari Welch"
        },
        {
            "id": 7,
            "name": "Iusto dolor quasi.",
            "avatar": "avatars/",
            "category": "LightYellow",
            "description": "And the muscular strength, which it gave to my right size: the next witness.' And he got up and to her ear, and whispered 'She's under sentence of execution. Then the Queen to play croquet.' Then.",
            "user": "Kari Welch"
        },
        {
            "id": 8,
            "name": "Rerum ut nobis.",
            "avatar": "avatars/",
            "category": "SaddleBrown",
            "description": "Alice. 'Anything you like,' said the Queen, in a few yards off. The Cat only grinned when it saw Alice. It looked good-natured, she thought: still it was done. They had not attended to this last.",
            "user": "Kari Welch"
        },
        {
            "id": 9,
            "name": "Error tempora atque.",
            "avatar": "avatars/",
            "category": "LemonChiffon",
            "description": "Pennyworth only of beautiful Soup? Pennyworth only of beautiful Soup? Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the house, and found herself in a hoarse, feeble voice: 'I heard the.",
            "user": "Kari Welch"
        },
        {
            "id": 10,
            "name": "Esse totam quis.",
            "avatar": "avatars/",
            "category": "LemonChiffon",
            "description": "White Rabbit; 'in fact, there's nothing written on the trumpet, and then quietly marched off after the birds! Why, she'll eat a bat?' when suddenly, thump! thump! down she came upon a heap of sticks.",
            "user": "Kari Welch"
        },
        {
            "id": 11,
            "name": "example product",
            "avatar": "avatars/",
            "category": "example category",
            "description": "example description",
            "user": "Kari Welch"
        }
    ],
    "links": {
        "first": "http://{base_url}/api/products?page=1",
        "last": "http://{base_url}/api/products?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://{base_url}/api/products?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://{base_url}/api/products",
        "per_page": 100,
        "to": 11,
        "total": 11
    }
}

```
---
4. **API to get a single product detail**

Request:

Method : *POST* (I usually use get for such requests but POST was mentioned in the document)


Curl Example

```
curl --location --request POST 'http://{base_url}/api/product/1' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "data": {
        "id": 1,
        "name": "Voluptatem et.",
        "avatar": "avatars/",
        "category": "DodgerBlue",
        "description": "I never understood what it meant till now.' 'If that's all the same, shedding gallons of tears, but said nothing. 'When we were little,' the Mock Turtle persisted. 'How COULD he turn them out again.",
        "user": "Kari Welch"
    }
}

```
---
5. **API to delete a product from the list**

Request:

Method : *DELETE*

Curl Example

```
curl --location --request DELETE 'http://{base_url}/api/product/1' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
1

```
---
6. **API to add cart items (guest and auth)**

Request:

Method : *POST*

Data : qty as param

Curl Example

```
curl --location --request POST 'http://{base_url}/api/cart/2?qty=1' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "session_id": null,
    "user_id": 1,
    "qty": "1",
    "product_id": 2,
    "id": 11
}

```
---
7. **API to update existing cart items by session (guest and auth)**

Request:

Method : *PUT*

Data : qty as param

Curl Example

```
curl --location --request PUT 'http://{base_url}/api/cart/2?qty=3' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "id": 2,
    "session_id": null,
    "user_id": 1,
    "product_id": 1,
    "qty": "3"
}

```
---
8. **API to delete cart items (guest and auth)**

Request:

Method : *DELETE* (please make note, the id in url is of cart and not product)

Curl Example

```
curl --location --request DELETE 'http://{base_url}/api/cart/2' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
1

```
---
9. **API to show cart items (guest and auth)**

Request:

Method : *POST*

Data : email, password as params

Curl Example

```
curl --location --request GET 'http://{base_url}/api/cart' \

--header 'Accept: application/json' \

--header 'Authorization: Bearer 1|b4zRZHd9nX6LE4jlARggqBRsPu6or1L5bc7KSswa'

```

Example Response:

```
{
    "data": [
        {
            "product": "Iusto dolor quasi.",
            "quantity": 3
        },
        {
            "product": "Ab qui adipisci in.",
            "quantity": 4
        },
        {
            "product": "Rerum ut nobis.",
            "quantity": 10
        },
        {
            "product": "Provident ducimus.",
            "quantity": 2
        },
        {
            "product": "Harum occaecati.",
            "quantity": 2
        },
        {
            "product": "Harum occaecati.",
            "quantity": 6
        },
        {
            "product": "Harum occaecati.",
            "quantity": 7
        },
        {
            "product": "Mollitia in dicta.",
            "quantity": 1
        }
    ]
}

```
---

10. Cart endpoints for guest user
If a user is not logged in, cart can still be used using session id. All the above cart endpoints work exactly the same but instead of Bearer Token, a SessionId is required. Below is an example of adding product to cart with SessionId.

Curl Example

```
curl --location --request POST 'http://{base_url}/api/cart/2?qty=2' \

--header 'Accept: application/json' \

--header 'SessionId: 5cEtNZCIs6dszwzmRKLVYmusyDiFKGXdtfJbeOvQ'

```

Example Response

```
{
    "session_id": "5cEtNZCIs6dszwzmRKLVYmusyDiFKGXdtfJbeOvQ",
    "user_id": null,
    "qty": "2",
    "product_id": 2,
    "id": 12
}

```
**As a note you can see, for session based carts, user_id is null and a session_id is returned.**


[^1]: Please make sure to run seed only once as there is a static email in the user factory which can result in integrity constraint voilation. The static email used so that you can use the mentioned email and password for test purposes.
