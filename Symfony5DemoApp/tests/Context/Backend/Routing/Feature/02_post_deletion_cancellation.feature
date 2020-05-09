#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=backend --tags=post_deletion_cancellation

# Ejemplo con muchos casos típicos al testear interfaces ricas:
#   - Que haya 2 elementos con el mismo título y uno esté oculto y se pretenda interactuar con el segundo
#   - Carga datos vía ajax o con fade effects, no está la información disponible al momento, tenemos que esperar.
#     El isVisible no siempre hace lo que pensamos, a veces tenemos que mirar si existen ciertos css, o style en los elementos

@backend
@post_deletion_cancellation
@javascript
Feature: Cancel a post deletion

  Background:
    When I log in as admin user

  Scenario: Cancel post deletion
    When I follow "Show"

    # Toma el delete post que está oculto, tenemos que sortear este caso a mano
    # And  I press "Delete post"
    And I click on the delete icon

    # NECESITAMOS:
      # 1) APLICAR RETARDO
      # 2) O CUSTOM STEP DEFINITION
      # 3) O EXTENSIÓN BEHAT-RETRY-EXTENSION
      # NOTA: Aquí ChromeDriver parece que vaya más rápido y no requiera de la espera.
      # And I take a screenshot

    # 1) Retardo, recurso fácil, pero peligroso
    And I wait 3 seconds

    # 2) Con BehatRetryExtension - La lib gestiona el retardo por nosotros (key Then)
    # Then I should see "Are you sure you want to delete this post?"

    # 3) Sin BehatRetryExtension - Usamos método propio spins
    # Then I should see a modal asking "Are you sure you want to delete this post?"

    And I press "Cancel"
    And I should not see the modal