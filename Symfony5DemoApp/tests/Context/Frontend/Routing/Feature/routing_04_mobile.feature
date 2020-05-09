#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=frontend --tags=routing_04_mobile

# El tag javascript, le dice a Behat que en Mink utilice el adaptador que permite javascript.
# Hooks (método initializeScreen), los usaremos para: inicialización, datafixtures, etc...
# Hay que iniciar Selenium (bash ./scripts/start-selenium.sh)
# Son más lentos
# *** I click on the drop-down menu

@frontend
@routing_04_mobile
@mobile
@javascript
Feature: Check that all frontend links work properly from a mobile phone

  Background: : Browser Frontend Web App
    # CUSTOM STEP DEFINITION
    When I visit the homepage
    Then I should see "Welcome to the Symfony Demo application"
    When I follow "Browse application"

  Scenario: Visit the Blog
    Then I should see "Symfony Demo - Blog"

  Scenario: Visit the first Blog entry
    And  I follow "Pellentesque vitae velit ex"
    Then I should see "Symfony Demo - Post"

  Scenario: Visit the search page

    # Necesitamos desplegar el menú para que el click sobre search actúe de verdad
    When  I click on the drop-down menu
    # Y si tomamos ahora un pantallazo? cómo será?
    # And I take a screenshot

    Then I follow "Search"
    Then I should see "Symfony Demo - Search"

    Then I should see the search input text