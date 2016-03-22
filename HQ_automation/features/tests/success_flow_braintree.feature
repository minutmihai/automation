Feature: Payment success flow using Braintree
  Conditions for success flow:
  - user fills all required inputs with correct data
  - selected Currency is different from USD, EUR, or AUD
  - CreditCard type is NOT AMEX

  @javascript @success
  Scenario Outline: Success payment using 'Braintree'
    Given I am on homepage
    When I fill order information with "<fullName>", "<amount>" and "<currency>"
    And I enter cardholder first name "<firstname>" and lastname "<lastname>"
    And I enter card details "<card_no>", "<cvv>", "<exp_month>", "<exp_year>"
    And I submit payment
    Then I should see a success message

#    And the order was processed through "<gateway>"
#    Gateway cannot be asserted by UI - should be done by calling an API for order details or by querying the DB with an unique order id

    Examples:
      | fullName | amount | currency | firstname | lastname | card_no          | cvv | exp_month | exp_year | gateway   |
      | Mihai    | 100    | THB      | First     | Last     | 4012888888881881 | 123 | 03        | 2017     | Braintree |
      | Mihai    | 200    | HKD      | First     | Last     | 5555555555554444 | 123 | 03        | 2017     | Braintree |

#       example uses VISA + EUR so order should be processed with Paypal
#       should be success, error is returned
#      | Mihai    | 100    | EUR      | First     | Last     | 4012888888881881 | 123 | 03        | 2017     | Paypal    |

#       example uses AMEX + USD so order should be processed with Paypal
#       should be success, error is returned
#      | Mihai    | 100    | USD      | First     | Last     | 371449635398431  | 123 | 03        | 2027     | Paypal    |

#       example uses MASTERCARD + AUD so order should be processed with Paypal
#       should be success, error is returned
#      | Mihai    | 100    | AUD      | First     | Last     | 371449635398431  | 123 | 03        | 2027     | Paypal    |