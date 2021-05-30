Feature: GET /api/countries-statistic

  Scenario: When send request without query Expect collection items
    Given I have counter with key "ru" by value "240"
    Given I have counter with key "en" by value "1200"
    When I add "Content-Type" header equal to "application/json"
    And I send a "GET" request to "/api/countries-statistic"
    Then the response status code should be 200
    And the JSON nodes should be equal to:
      | ru | 240  |
      | en | 1200 |
