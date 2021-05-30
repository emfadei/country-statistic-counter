Feature: POST /api/countries-statistic

  Scenario: When send country code | Expect counter increased
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/countries-statistic"
    """
    {
      "countryCode": "ru"
    }
    """
    Then the response status code should be 204
    And there is value "1" in redis storage by key "ru"
