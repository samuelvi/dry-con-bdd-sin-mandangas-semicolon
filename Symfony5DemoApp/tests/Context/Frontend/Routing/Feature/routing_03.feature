#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=frontend --tags=routing_03

# DRY gracias a Background
# Simplificamos el título de la feature
#
# *** I visit the homepage
# *** Custom Step Definition: I should see the search input text

@frontend
@routing_03
Feature: Check that all frontend links work properly

  # DRY:
  Background: : Browser Frontend Web App
    # CUSTOM STEP DEFINITION
    When I visit the homepage
    Then I should see "Welcome to the Symfony Demo application"
    When I follow "Browse application"

  Scenario: Visit the Blog
    Then I should see "Symfony Demo - Blog"

  Scenario: Visit the first Blog entry
    And   I follow "Pellentesque vitae velit ex"
    Then  I should see "Symfony Demo - Post"

  Scenario: Browse to the search page
    Then  I follow "Search"
    Then  I should see "Symfony Demo - Search"

    # Este Step definition también lo hemos creado a mano, un poco más complejo que I visit the homepage
    Then I should see the search input text