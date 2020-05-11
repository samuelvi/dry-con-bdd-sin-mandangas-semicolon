# ./vendor/behat/behat/bin/behat --tags=SUGGESTED_LANGUAGES
@SUGGESTED_LANGUAGES
Feature: Wikipedia suggested languages


 # ./vendor/behat/behat/bin/behat --tags=EXPLANATION
  @EXPLANATION
  Scenario: Check Wikipedia Popover information
    When I visit wikipedia homepage in english
    And  I should not see "is a multilingual"
    And  I put the cursor over the "Wikipedia," text
    And  I should see a popover with the text "is a multilingual"

  # ./vendor/behat/behat/bin/behat --tags=LANGUAGE_SETTINGS
  @LANGUAGE_SETTINGS
  Scenario: Check Wikipedia Language Settings
    When I visit wikipedia homepage in english
    And  I should not see "Language settings"
    And  I click on Language Settings
    And  I wait 2 seconds
    And  I take a screenshot
    And  I should see a popover with the text "Language settings"

