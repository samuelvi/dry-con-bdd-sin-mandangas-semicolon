Feature: Calculator
  In order to calculate
  As anonymous user
  I should be able to add and substract

 # Given => A (Arrange/Preparar)
 # When  => A (Act/Actuar)
 # Then  => A (Assert/Afirmar)

  Scenario: Perform the addition of two numbers
    Given A standard calculator
    When  I add 1 plus 2
    Then  The result of the addition should be 3

  Scenario: Calculate the square root of a number
    Given A Scientific calculator
    When  I calculate the square root of 4
    Then  The result of the square root should be 2