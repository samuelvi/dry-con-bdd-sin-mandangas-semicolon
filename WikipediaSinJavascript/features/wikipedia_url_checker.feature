
Feature: Being able to navigate through wikipedia website

  # Buena práctica no exponer urls en el test
  # Podemos usar los Hooks (BeforeScenario)

  Scenario: Check Behat wiki home page in spanish is valid
    When I visit the wikipedia homepage in spanish
    Then I should see "Bienvenidos a Wikipedia,"

  Scenario: Check Behat wiki home pagre in english is valid
    When I visit the wikipedia homepage in english
    Then I should see "Welcome to Wikipedia,"