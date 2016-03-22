<?php

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception;

/**
 * Features context.
 * Define custom steps 
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext
{

    /**
     * @Given /^I fill order information with "([^"]*)", "([^"]*)" and "([^"]*)"$/
     */
    public function iFillOrderInformation($fullName, $price, $currency)
    {
        $this->fillField("fullName", $fullName);
        $this->fillField("amount", $price);
        $this->selectOption("currency", $currency);
    }


    /**
     * @Given /^I enter cardholder first name "([^"]*)" and lastname "([^"]*)"$/
     */
    public function iEnterCardholderFirstNameAndLastname($fistName, $lastname)
    {
        $this->fillField("firstName", $fistName);
        $this->fillField("lastName", $lastname);
    }


    /**
     * @Given /^I enter card details "([^"]*)", "([^"]*)", "([^"]*)", "([^"]*)"$/
     */
    public function iEnterCardDetails($card_no, $cvv, $exp_month, $exp_year)
    {
        $this->fillField("cardNumber", $card_no);
        $this->fillField("cardCVV", $cvv);
        $this->fillField("expireYear", $exp_year);
        $this->selectExpiryDate($exp_month);
    }

    /**
     * execute JS to select the expiration month - tricky html/css selectors
     * modify month format
     * to investigate better solution
     */
    public function selectExpiryDate($month)
    {
        if ($month < 10) {
            $month = substr($month, 1);
        }
        $this->getSession()->evaluateScript("$(\".item[data-value='" . $month . "']\").click();");

    }


    /**
     * @Given /^I submit payment$/
     */
    public function iSubmitPayment()
    {
//        $this->pressButton("Submit");
        $this->iClickOnTheElement(".ui.blue.submit.button");
    }


    /**
     * @Then /^I should see an error validation message "([^"]*)"$/
     */
    public function iShouldSeeErrorValidationMessageErrorMessage($message)
    {
        $page = $this->getSession()->getPage();
        $container = $page->find('css', ".ui.basic.red.pointing.prompt.label");
        $actualMessage = $container->getText();

        if ($actualMessage != $message) {
            throw new \Exception("Expected error message '" . $message . "'is different from actual message '" . $actualMessage . "'.");


        }
    }

    /**
     * @Then /^I should see a success message$/
     * Retry asserting that success element is visible with timeout between retries
     */
    public function iShouldSeeSuccessMessage()
    {
        $status = false;
        $messageElement = $this->getSession()->getPage()->find('css', ".ui.success.message");
        $count = 0;
        while ($count < 20) {

            $condition = $messageElement->isVisible();
            if ($condition) {
                $status = true;
                break;
            } else {
                $count++;
                $this->getSession()->wait(300);
            }
        }
        if (!$status) {

            throw new \Exception("Success message was not returned");
        }
    }


    /**
     * @Then /^I should see an error message$/
     */
    public function iShouldSeeErrorMessage()
    {
        $status = false;
        $messageElement = $this->getSession()->getPage()->find('css', ".ui.error.message");
        $count = 0;
        while ($count < 20) {

            $condition = $messageElement->isVisible();
            if ($condition) {
                $status = true;
                break;
            } else {
                $count++;
                $this->getSession()->wait(300);
            }
        }
        if (!$status) {

            throw new \Exception("Error message was not returned");
        }
    }

    /**
     * Pauses the scenario until the user presses a key.
     * Useful when debugging a scenario.
     *
     * @Given /^I put a breakpoint$/
     */
    public function iPutABreakpoint()
    {
        fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
        while (fgets(STDIN, 1024) == '') {

        }
        fwrite(STDOUT, "\033[u");

        return;

    }

    /**
     * Clicks link with specified CSS selector.
     *
     * @Given /^I click on the element "([^"]*)"$/
     */
    public function iClickOnTheElement($locator)
    {
        $locator = $this->fixStepArgument($locator);
        $session = $this->getSession();
        $element = $session->getPage()->find('css', $locator);
        if (null === $element) {
            throw new ElementNotFoundException($this->getSession(), 'element', 'css', $locator);
        }
        $element->click();

    }


}
