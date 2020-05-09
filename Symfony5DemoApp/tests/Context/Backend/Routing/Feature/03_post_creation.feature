#  ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=backend --tags=post_creation


# La opción scroll to, la usamos a modo takescreenshot para ver si realmente se está seteando los tags
# Comentar que se pueden inyectar directamente servicios de Symfony gracias a FriendsOfBehat
# Es mala praxis meter queries en un Context, debería haber un Repo/Servicio que lo llevara a cabo

@backend
@post_creation
@javascript
Feature: Create a new post

  Background:
    When I log in as admin user
    When I follow "Create a new post"

    Then I should not see "This value should not be blank."
    Then I should not see "Give your post a summary!"
    Then I should not see "Your post should have some content!"

  # ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=backend --tags=post_creation --tags=error
  @error
  Scenario: Post creation with errors

    # Si peta aquí es pq está la toolbar de symfony en modo test mostrándose
    And  I press "Create post"
    Then I should see "This value should not be blank."
    Then I should see "Give your post a summary!"
    Then I should see "Your post should have some content!"

  # ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml --tags=backend --tags=post_creation --tags=ok
  @ok
  Scenario: Post creation successfully

    And  I fill in "Title" with "The internet of cats"
    And  I fill in "Summary" with "Why internet in plenty of cats, nobody knows but scientifics concluded..."
    And  I fill in "Content" with "Bla bla bla..."

    # FALLA, NO HAY RELACIÓN ENTRE "tags" y el "input"
    #And  I fill in "Tags" with "cats, kitten"
    And  I fill in Tags with "cats, kitten,"
    # And  I scroll to the Save Buttons
    And  I press "Create post"
    Then I should see "Post created successfully!"

    When I follow "Show"
    Then I should see "Edit contents"
    Then I should see "The internet of cats"
    And  I should see "Summary: Why internet in plenty of cats, nobody knows but scientifics concluded..."
    And  I should see "Bla bla bla..."
    And  I should see "cats kitten"
    Then I take a screenshot