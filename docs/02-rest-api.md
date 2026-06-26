# WordPress REST API

WordPress provides a REST API to request and send data in JSON format. This allows the user to read the content of a certain website or application using WordPress as CMS, to get, update or delete data through this API.

## Main route

`/wp-json/` is the main route of the API, where you can find a lot of info about the API and its structure, but we will focus on 2 segments of the JSON object:
- namespaces: These are groups of routes, to let the developer know which kind of routes are available. We have for example the `wp/v2` namespace, where we will find all the WordPress core routes.
- routes: We can see all the routes available in the API.

## The `/wp-json/wp/v2/posts` route

Here, we can get and interact with the posts list. By default, we can see only the published ones, as we will need authentication to access to private info.

## Appending parameters

You can use parameters in the API request, to filter the info you receive. This allows you to get a faster response, as the data you get is less than the original query.
- _fields: This parameter will let you get only the fields you need
- per_page: Sets the number of items you get in the request
- search: searches for a specific string in the query, and you get the items related to it. For example, if I look for "hello" using the search parameter (?search="hello") in the `wp/v2/posts/`route, I will get the posts that contains that word.

## Core vs custom endpoints

Core endpoints are the ones available when you install WordPress, that allows you to access core features.

Custom endpoints can be added through themes or functions via actions, extending how the WordPress REST API work and which data you can interact with.

## Endpoint testing

### GET /wp/v2/posts

Endpoint to get the post. Use case: Render them in the frontend.

```JSON
[
    {
        "id": 1,
        "date": "2026-05-28T13:07:55",
        "date_gmt": "2026-05-28T11:07:55",
        "guid": {
            "rendered": "http://roadmap.local/?p=1"
        },
        "modified": "2026-05-28T13:07:55",
        "modified_gmt": "2026-05-28T11:07:55",
        "slug": "hola-mundo",
        "status": "publish",
        "type": "post",
        "link": "http://roadmap.local/hola-mundo/",
        "title": {
            "rendered": "Title: ¡Hola, mundo! (Thanks for reading!)"
        },
        "content": {
            "rendered": "\n<p class=\"wp-block-paragraph\">Te damos la bienvenida a WordPress. Esta es tu primera entrada. Edítala o bórrala, ¡luego empieza a escribir!</p>\n",
            "protected": false
        },
        "excerpt": {
            "rendered": "<p>Te damos la bienvenida a WordPress. Esta es tu primera entrada. Edítala o bórrala, ¡luego empieza a escribir!</p>\n",
            "protected": false
        },
        "author": 1,
        "featured_media": 0,
        "comment_status": "open",
        "ping_status": "open",
        "sticky": false,
        "template": "",
        "format": "standard",
        "meta": {
            "footnotes": ""
        },
        "categories": [
            1
        ],
        "tags": [],
        "class_list": [
            "post-1",
            "post",
            "type-post",
            "status-publish",
            "format-standard",
            "hentry",
            "category-sin-categoria"
        ],
        "_links": {
            "self": [
                {
                    "href": "http://roadmap.local/wp-json/wp/v2/posts/1",
                    "targetHints": {
                        "allow": [
                            "GET"
                        ]
                    }
                }
            ],
            "collection": [
                {
                    "href": "http://roadmap.local/wp-json/wp/v2/posts"
                }
            ],
            "about": [
                {
                    "href": "http://roadmap.local/wp-json/wp/v2/types/post"
                }
            ],
            "author": [
                {
                    "embeddable": true,
                    "href": "http://roadmap.local/wp-json/wp/v2/users/1"
                }
            ],
            "replies": [
                {
                    "embeddable": true,
                    "href": "http://roadmap.local/wp-json/wp/v2/comments?post=1"
                }
            ],
            "version-history": [
                {
                    "count": 0,
                    "href": "http://roadmap.local/wp-json/wp/v2/posts/1/revisions"
                }
            ],
            "wp:attachment": [
                {
                    "href": "http://roadmap.local/wp-json/wp/v2/media?parent=1"
                }
            ],
            "wp:term": [
                {
                    "taxonomy": "category",
                    "embeddable": true,
                    "href": "http://roadmap.local/wp-json/wp/v2/categories?post=1"
                },
                {
                    "taxonomy": "post_tag",
                    "embeddable": true,
                    "href": "http://roadmap.local/wp-json/wp/v2/tags?post=1"
                }
            ],
            "curies": [
                {
                    "name": "wp",
                    "href": "https://api.w.org/{rel}",
                    "templated": true
                }
            ]
        }
    }
]
```

### GET /wp-json/wp/v2/posts?_fields=id,content.protected

We are getting a JSON with the id of the post and if has the content protected or not. Use case: We can get only needed fields for a certain use. This time, we only want to check the protection status of the content in posts.

```JSON
[
    {
        "id": 15,
        "content": {
            "protected": false
        }
    },
    {
        "id": 1,
        "content": {
            "protected": false
        }
    }
]
```

### GET /wp/v2/settings

WordPress settings info. As I am not authenticated, I get a 401 result.

```JSON
{
    "code": "rest_forbidden",
    "message": "Lo siento, no tienes permisos para hacer eso.",
    "data": {
        "status": 401
    }
}
```

### GET /wp/v2/posts?status=draft

I cannot access the draft posts, as they are private to normal users and need authentication.

```JSON
{
    "code": "rest_invalid_param",
    "message": "Parámetro(s) no válido(s): status",
    "data": {
        "status": 400,
        "params": {
            "status": "El estado está prohibido."
        },
        "details": {
            "status": {
                "code": "rest_forbidden_status",
                "message": "El estado está prohibido.",
                "data": {
                    "status": 401
                }
            }
        }
    }
}
```

### GET /wp/v2/posts?page=2

WordPress posts request are paginated by default, so:
`/wp-json/wp/v2/posts?page=1` and `/wp-json/wp/v2/posts` works the same. With the page=2 parameter, we can access to the post in the second page. You can change the number of items showed by page in WordPress settings.

### GET /wp-json/wp/v2/posts?per_page=1&page=2

You can also edit the number of items for each page, with the per_page param.


