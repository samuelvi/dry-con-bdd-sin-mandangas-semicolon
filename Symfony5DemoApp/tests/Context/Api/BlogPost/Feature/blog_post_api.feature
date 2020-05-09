# ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=api

# Si guardamos 2 veces peta, comentar tema datafixtures: php bin/console doctrine:fixtures:load --no-interaction
# Aquí es donde entra Continuos Integration, que nos facilitará todas las inicializaciones previas:
# - regeneración tablas base de datos (tipo doctrine:migrations:migrate)
# - inicialización datafixtures de pruebas genéricos a todos los tests (si es necesario)
# - composer update
# - npm


@api
Feature: Test the Blog Post Api Platform

  Scenario: Test number of Blog Posts
    Given We have some blog posts
    When  I send a "GET" request to "http://127.0.0.1:8000/en/api/posts/count"
    And   the response should be in JSON
    And   I should get the total amount of blog posts

  Scenario: Test add a Blog Post
    Given We have some blog posts
    And   I add "accept" header equal to "application/ld+json"
    And   I add "Content-Type" header equal to "application/json"

    # PyString
    When  I send a "POST" request to "http://127.0.0.1:8000/api/users" with body:
    """
    {
      "fullName": "string",
      "username": "string2",
      "email": "my2@email.com",
      "password": "string",
      "roles": [
        "ROLE_USER"
      ]
    }
    """
    # PODEMOS VER SI FALLA QUE IGUAL ESTAMOS CREANDO EL MISMO USUARIO VARIAS VECES
    # And print last response
    Then the response status code should be 201