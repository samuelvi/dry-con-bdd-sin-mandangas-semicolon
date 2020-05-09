#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=frontend --tags=routing_01

# Curiosidad: Si usamos el driver de symfony, falla, hace una resolución vía rutas, no curl
# Goutte si que hace peticiones web vía Guzzle (curl por defecto)
#
# Mala praxis: exponer url
# Mala praxis: comprobar por status code 200

@frontend
@routing_01
Feature:
  In order to learn about the Symony Demo Frontend Web App
  As a guest user
  I want to visit all sections and get the status code 200

  Scenario: All frontend urls return status code 200
    When I go to "http://127.0.0.1:8000/en"
    Then the response status code should be 200

    When I go to "http://127.0.0.1:8000/en/blog/search"
    Then the response status code should be 200

    When I go to "http://127.0.0.1:8000/en/blog/"
    Then the response status code should be 200

    When I go to "http://127.0.0.1:8000/en/blog/posts/pellentesque-vitae-velit-ex"
    # And  I take a screenshot
    Then the response status code should be 200

    When I go to "http://127.0.0.1:8000/en/blog/rss.xml"
    Then the response status code should be 200

