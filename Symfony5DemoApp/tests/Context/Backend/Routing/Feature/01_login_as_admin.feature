#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=backend --tags=login_as_admin

# No requiere JS. El test será más rápido
# Este proceso se puede mejorar:
#   - encapsulamiento: custom method que englobe el proceso de login (lo veremos en el próximo ejemplo)
#   - velocidad: montando un autologin para tests
#   - encapsulamiento mejorado: PageObject

@backend
@login_as_admin
Feature: Admin can log in successfully

  Scenario: Log in as admin user
    When I visit the homepage
    And  I follow "Browse backend"
    And  I fill in "Username" with "jane_admin"
    And  I fill in "Password" with "kitten"
    And  I press "Sign in"
    Then I should see "Create a new post"
    # And I take a screenshot