Feature: POST /api/countries-statistic validation

  Scenario: When invalid country code | Violations returned
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/countries-statistic"
    """
    {
      "countryCode": "rufdsfs"
    }
    """
    Then the response status code should be 400
    And the JSON nodes should be equal to:
      | violations[0].propertyPath | countryCode                                                  |
      | violations[0].title        | This value is too long. It should have 3 characters or less. |


  Scenario: When invalid json | Violations returned
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/countries-statistic"
    """
    {
      "countryCode": "rufdsfs",
    }
    """
    Then the response status code should be 400
    And the JSON nodes should be equal to:
      | violations[0].code  | invalidRequest                 |
      | violations[0].message | Invalid request: Syntax error |

