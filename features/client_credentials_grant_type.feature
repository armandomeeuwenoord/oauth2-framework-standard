Feature: Login as foo and see if we can logout

  Scenario: login and logout with user Foo
    Given I am on "/login"
    When I fill in "_username" with "Foo"
    When I fill in "_password" with "Bar"
    When I press "Login"
    Then I should be on "/profile"
    Then I should see "Hi, Foo"
    When I follow "Logout"
    Then I should be on "/login"
