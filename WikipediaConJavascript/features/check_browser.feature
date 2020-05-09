@CHECK_BROWSER
Feature: Check Browser

  Scenario: Check Chrome Driver
    When I visit what is my browser
    Then I should see "Chrome 81 on macOS"

  @FIREFOX
  Scenario: Check Firefox Driver
    When I visit what is my browser
    Then I should see "Firefox 75 on macOS"
