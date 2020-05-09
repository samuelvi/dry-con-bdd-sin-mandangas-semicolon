Feature: Being able to navigate through wikipedia website

  Scenario: Check Behat wiki home pagre in spanish is valid
    When I visit the wikipedia homepage in spanish
    Then I should see "Bienvenidos a Wikipedia,"

  Scenario: Check Behat wiki home pagre in english is valid
    When I visit the wikipedia homepage in english
    Then I should see "Welcome to Wikipedia,"