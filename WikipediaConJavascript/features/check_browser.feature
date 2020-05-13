# ./vendor/behat/behat/bin/behat --tags=CHECK_BROWSER

@CHECK_BROWSER
Feature: Check Browser

  # Comprobamos 2 drivers visualmente

  # ./vendor/behat/behat/bin/behat --tags=CHECK_BROWSER --tags=CHROME
  @CHROME
  Scenario: Check Chrome Driver
    When I visit what is my browser
    Then I should see "Chrome 81 on macOS"
    And  I take a screenshot

  # ./vendor/behat/behat/bin/behat --tags=CHECK_BROWSER --tags=FIREFOX
  @FIREFOX
  Scenario: Check Firefox Driver
    When I visit what is my browser
    Then I should see "Firefox 75 on macOS"
    And  I take a screenshot