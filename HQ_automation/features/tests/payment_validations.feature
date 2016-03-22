Feature: Payment validations
  If the user doesn't fill a required field then an error validation message should be returned
  [Not implemented in APP] - Other specific validations to be tested

  @javascript @validations
  Scenario Outline: Payment form validations
    Given I am on homepage
    When I fill order information with "<fullName>", "<amount>" and "<currency>"
    And I enter cardholder first name "<firstname>" and lastname "<lastname>"
    And I enter card details "<card_no>", "<cvv>", "<exp_month>", "<exp_year>"
    And I submit payment
    Then I should see an error validation message "<error_message>"


    Examples:
      | fullName | amount | currency | firstname | lastname | card_no          | cvv | exp_month | exp_year | error_message                                  |
      | Mihai    | 100    | USD      | First     | Last     | 11111111111111   | 123 | 03        | 2017     | Card Number must be a valid credit card number |
      | Mihai    |        | USD      | First     | Last     | 4012888888881881 | 123 | 03        | 2017     | Amount must have a value                       |
      | Mihai    | 100    | USD      |           | Last     | 4012888888881881 | 123 | 03        | 2017     | First Name must have a value                   |
      | Mihai    | 100    | USD      | First     |          | 4012888888881881 | 123 | 03        | 2017     | Last Name must have a value                    |
      | Mihai    | 100    | USD      | First     | Last     | 4012888888881881 |     | 03        | 2017     | CVV must have a value                          |
      | Mihai    | 100    | USD      | First     | Last     | 4012888888881881 | 123 | 03        |          | Year must have a value                         |


  @javascript @validations
  Scenario Outline: Error is returned when AMEX is used with other currency than USD
    Given I am on homepage
    When I fill order information with "<fullName>", "<amount>" and "<currency>"
    And I enter cardholder first name "<firstname>" and lastname "<lastname>"
    And I enter card details "<card_no>", "<cvv>", "<exp_month>", "<exp_year>"
    And I submit payment
    Then I should see an error message

    Examples:
      | fullName | amount | currency | firstname | lastname | card_no         | cvv | exp_month | exp_year |
      | Mihai    | 100    | EUR      | First     | Last     | 371449635398431 | 123 | 03        | 2027     |
