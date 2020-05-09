#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=frontend --tags=routing_02

# Mala praxis: follow o press sobre "id", no es semántico#
# ¿Cómo sabemos dónde estamos?: Toma de pantallazos (en html si no está el tag @javascript)
# *** I take a screenshot (Behatch no tiene implementado guardar pantallazos si no usamos driver javascript)
# Estamos repitiendo código :( - ¡Background al rescate!

@frontend
@routing_02
Feature:
  In order to learn about the Symony Demo Frontend Web App
  As a guest user
  I want to be able to navigate by all the existing sections and get the status code 200

  Scenario: Visit Home page
    When I go to "http://127.0.0.1:8000/en"
    Then the response status code should be 200

  Scenario: Visit the blog
    When I go to "http://127.0.0.1:8000/en"

    # Mala praxis
    And  I follow "browse-frontend"
    Then the response status code should be 200

    # Cómo estamos seguros?
    # Behatch ofrece mecanismo para guardar pantallazo, pero sólo con el driver de Javascript:  And I save a screenshot in "my-file-name"
    # And I take a screenshot

  Scenario: Visit the first blog entry
    When I go to "http://127.0.0.1:8000/en"
    And  I follow "Browse application"
    Then the response status code should be 200
    When I follow "Pellentesque vitae velit ex"
    Then the response status code should be 200

    # Cómo estamos seguros?
    # And I take a screenshot


  # Llegados aquí algo huele mal, tenemos el patrón I go to que se repite y luego un status code 200 que luego
  # tenemos que comprobar tomando pantallazo